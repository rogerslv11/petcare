<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Notifications\PetReadyNotification;
use App\Services\AppointmentService;
use Livewire\Component;

class KanbanBoard extends Component
{
    public array $cols = ['pending' => 'Agendados', 'checked_in' => 'Check-in', 'in_service' => 'Em atendimento', 'ready' => 'Prontos', 'completed' => 'Finalizados'];

    public function render()
    {
        $cards = [];
        foreach (array_keys($this->cols) as $s) {
            $cards[$s] = Appointment::with(['pet', 'service', 'professional'])->whereDate('scheduled_at', today())->where('status', $s)->orderBy('scheduled_at')->get();
        }

return view('livewire.kanban-board', compact('cards'));
    }

    public function move(int $id, string $to, AppointmentService $svc)
    {
        $a = Appointment::findOrFail($id);
        $svc->transition($a, $to);
        if ($to === 'ready') {
            $a->customer;
            auth()->user()->notify(new PetReadyNotification($a->pet->name));
        } $this->dispatch('notify', message: 'Pet movido para '.$to);
    }
}
