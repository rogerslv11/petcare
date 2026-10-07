<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->canAccess('agenda');
    }

    public function rules(): array
    {
        return ['customer_id' => 'required|exists:customers,id', 'pet_id' => 'required|exists:pets,id', 'service_id' => 'nullable|exists:services,id', 'professional_id' => 'nullable|exists:professionals,id', 'scheduled_at' => 'required|date|after:now', 'type' => 'required|string'];
    }
}
