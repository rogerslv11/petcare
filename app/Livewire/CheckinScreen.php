<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Livewire\Component;

class CheckinScreen extends Component
{
    public string $q = '';

    public $found = [];

    public function search()
    {
        $this->found = Appointment::with(['pet', 'customer', 'service'])->whereDate('scheduled_at', today())->whereHas('customer', fn ($x) => $x->where('name', 'like', "%{$this->q}%"))->get();
    }

    public function checkin(int $id, AppointmentService $svc)
    {
        $svc->transition(Appointment::findOrFail($id), AppointmentStatus::CHECKED_IN);
        $this->dispatch('notify', message: 'Check-in realizado ✅');
    }

    public function render()
    {
        $today = Appointment::with(['pet', 'customer', 'service'])->whereDate('scheduled_at', today())->whereIn('status', ['pending', 'confirmed'])->orderBy('scheduled_at')->get();

        return view('livewire.checkin-screen', compact('today'));
    }
}
