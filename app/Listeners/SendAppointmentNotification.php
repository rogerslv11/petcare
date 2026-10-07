<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAppointmentNotification implements ShouldQueue
{
    public function handle(AppointmentCreated $e): void
    {
        ActivityLog::create(['business_id' => $e->appointment->business_id, 'action' => 'appointment.created', 'entity_type' => 'appointment', 'entity_id' => $e->appointment->id, 'meta' => ['pet' => $e->appointment->pet_id]]);
    }
}
