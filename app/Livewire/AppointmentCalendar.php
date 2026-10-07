<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Professional;
use Carbon\Carbon;
use Livewire\Component;

class AppointmentCalendar extends Component
{
    public string $date;

    public string $view = 'day';

    public string $pro = '';

    public function mount()
    {
        $this->date = today()->toDateString();
    }

    public function render()
    {
        $d = Carbon::parse($this->date);
        $rows = Appointment::with(['pet', 'customer', 'service', 'professional'])->when($this->view === 'day', fn ($q) => $q->whereDate('scheduled_at', $d))->when($this->view === 'week', fn ($q) => $q->whereBetween('scheduled_at', [$d->copy()->startOfWeek(), $d->copy()->endOfWeek()]))->when($this->pro, fn ($q) => $q->where('professional_id', $this->pro))->orderBy('scheduled_at')->limit(100)->get();
        $pros = Professional::where('status', 'active')->get();

        return view('livewire.appointment-calendar', compact('rows', 'pros'));
    }

    public function move(int $id, string $newDateTime)
    {
        $a = Appointment::findOrFail($id);
        $this->authorize('update', $a);
        $a->update(['scheduled_at' => $newDateTime]);
        $this->dispatch('notify', message: 'Reagendado para '.$newDateTime);
    }
}
