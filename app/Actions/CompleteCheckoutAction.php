<?php

namespace App\Actions;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Payment;
use App\Services\AppointmentService;

class CompleteCheckoutAction
{
    public function __construct(protected AppointmentService $svc) {}

    public function execute(Appointment $a, string $method = 'pix'): Appointment
    {
        if ($a->price > 0) {
            Payment::create(['business_id' => $a->business_id, 'branch_id' => $a->branch_id, 'customer_id' => $a->customer_id, 'appointment_id' => $a->id, 'method' => $method, 'status' => 'paid', 'amount' => $a->price, 'paid_at' => now()]);
        }

        return $this->svc->transition($a, AppointmentStatus::COMPLETED);
    }
}
