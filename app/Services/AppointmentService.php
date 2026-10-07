<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Events\AppointmentStatusChanged;
use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function availableSlots(int $professionalId, string $date, int $duration = 60): array
    {
        $start = Carbon::parse($date)->setTime(8, 0);
        $end = Carbon::parse($date)->setTime(19, 0);
        $busy = Appointment::where('professional_id', $professionalId)->whereDate('scheduled_at', $date)
            ->whereNotIn('status', ['cancelled', 'no_show'])->get(['scheduled_at', 'ends_at']);
        $slots = [];
        $cursor = $start->copy();
        while ($cursor->copy()->addMinutes($duration)->lte($end)) {
            $s = $cursor->copy();
            $e = $cursor->copy()->addMinutes($duration);
            $conflict = $busy->contains(fn ($b) => $s->lt($b->ends_at ?? $b->scheduled_at) && $e->gt($b->scheduled_at));
            if (! $conflict) {
                $slots[] = $s->format('H:i');
            }
            $cursor->addMinutes(30);
        }

        return $slots;
    }

    public function transition(Appointment $a, AppointmentStatus|string $to, ?string $reason = null): Appointment
    {
        $to = $to instanceof AppointmentStatus ? $to : AppointmentStatus::from($to);
        DB::transaction(function () use ($a, $to, $reason) {
            $from = $a->status instanceof AppointmentStatus ? $a->status->value : $a->status;
            $a->update(['status' => $to->value, 'cancellation_reason' => $reason]);
            AppointmentStatusHistory::create(['appointment_id' => $a->id, 'from_status' => $from, 'to_status' => $to->value, 'user_id' => auth()->id()]);
            if ($to === AppointmentStatus::COMPLETED) {
                $this->generateCommission($a);
            }
            event(new AppointmentStatusChanged($a, $from, $to->value));
        });

        return $a->fresh();
    }

    protected function generateCommission(Appointment $a): void
    {
        if (! $a->professional_id) {
            return;
        }
        $prof = $a->professional;
        $svc = $a->service;
        $pct = $prof->commission_pct ?? $svc->commission_pct ?? 10;
        Commission::create(['business_id' => $a->business_id, 'professional_id' => $a->professional_id, 'appointment_id' => $a->id, 'amount' => round($a->price * $pct / 100, 2), 'pct' => $pct, 'status' => 'pending']);
    }

    public function noShowRate(int $businessId): float
    {
        $total = Appointment::forBusiness($businessId)->count();
        if (! $total) {
            return 0;
        }
        $ns = Appointment::forBusiness($businessId)->where('status', 'no_show')->count();

        return round($ns / $total * 100, 1);
    }
}
