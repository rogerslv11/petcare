<?php

namespace App\Observers;

use App\Models\Appointment;

class AppointmentObserver
{
    public function creating(Appointment $a): void
    {
        if ($a->service_id && ! $a->ends_at) {
            $svc = $a->service;
            $mins = $svc?->duration_min ?? 60;
            $a->ends_at = $a->scheduled_at->copy()->addMinutes($mins);
        }
        if ($a->service_id && ! $a->price) {
            $a->price = $a->service?->price ?? 0;
        }
    }
}
