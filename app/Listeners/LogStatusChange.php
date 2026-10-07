<?php

namespace App\Listeners;

use App\Events\AppointmentStatusChanged;
use App\Models\ActivityLog;

class LogStatusChange
{
    public function handle(AppointmentStatusChanged $e): void
    {
        ActivityLog::create(['business_id' => $e->appointment->business_id, 'action' => 'appointment.'.$e->to, 'entity_type' => 'appointment', 'entity_id' => $e->appointment->id, 'user_id' => auth()->id(), 'meta' => ['from' => $e->from, 'to' => $e->to]]);
    }
}
