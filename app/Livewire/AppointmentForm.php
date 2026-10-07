<?php

namespace App\Livewire;

use App\Actions\CreateAppointmentAction;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Professional;
use App\Models\Service;
use App\Services\AppointmentService;
use App\Support\TenantContext;
use Livewire\Component;

class AppointmentForm extends Component
{
    public $customer_id;

    public $pet_id;

    public $service_id;

    public $professional_id;

    public $scheduled_at;

    public $type = 'bath';

    public $notes = '';

    public array $freeSlots = [];

    public $pets = [];

    public function updatedCustomerId()
    {
        $this->pets = Pet::where('customer_id', $this->customer_id)->get();
    }

    public function updatedProfessionalId()
    {
        $this->loadSlots();
    }

    public function loadSlots()
    {
        if ($this->professional_id && $this->scheduled_at) {
            $this->freeSlots = app(AppointmentService::class)->availableSlots($this->professional_id, substr($this->scheduled_at, 0, 10));
        }
    }

    public function save(CreateAppointmentAction $action)
    {
        $a = $action->execute(['business_id' => TenantContext::businessId(), 'branch_id' => session('current_branch_id'), 'customer_id' => $this->customer_id, 'pet_id' => $this->pet_id, 'service_id' => $this->service_id, 'professional_id' => $this->professional_id, 'scheduled_at' => $this->scheduled_at, 'type' => $this->type, 'notes' => $this->notes, 'price' => Service::find($this->service_id)?->price ?? 0]);

        return redirect()->route('appointments.show', $a);
    }

    public function render()
    {
        return view('livewire.appointment-form', ['customers' => Customer::active()->limit(200)->get(), 'services' => Service::active()->get(), 'pros' => Professional::where('status', 'active')->get()]);
    }
}
