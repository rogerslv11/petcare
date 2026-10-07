<?php

namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendAppointmentReminder implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function handle(): void
    {
        $list = Appointment::where('status', 'confirmed')->whereBetween('scheduled_at', [now()->addHours(23), now()->addHours(25)])->with(['customer', 'pet'])->get();
        foreach ($list as $a) {
            \Log::info("[Reminder] {$a->customer->phone} - Olá! {$a->pet->name} tem {$a->type} amanhã às {$a->scheduled_at->format('H:i')} 🐾");
        }
    }
}
