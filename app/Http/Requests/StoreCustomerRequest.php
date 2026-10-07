<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->canAccess('customers');
    }

    public function rules(): array
    {
        return ['name' => 'required|string|max:255', 'email' => 'nullable|email', 'phone' => 'nullable|string|max:30', 'document' => 'nullable|string|max:30', 'status' => 'in:active,inactive'];
    }
}
