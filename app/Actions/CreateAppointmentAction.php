<?php

namespace App\Actions;

use App\Events\AppointmentCreated;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class CreateAppointmentAction
{
    public function execute(array $data): Appointment
    {
        Validator::make($data, ['business_id' => 'required|exists:businesses,id', 'customer_id' => 'required|exists:customers,id', 'pet_id' => 'required|exists:pets,id', 'scheduled_at' => 'required|date', 'service_id' => 'nullable|exists:services,id'])->validate();
        $a = Appointment::create($data + ['status' => 'pending']);
        event(new AppointmentCreated($a));

        return $a;
    }
}
