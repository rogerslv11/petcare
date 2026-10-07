<?php

namespace App\Livewire;

use App\Models\Pet;
use Livewire\Component;

class PetTimeline extends Component
{
    public Pet $pet;

    public function mount(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function render()
    {
        $appts = $this->pet->appointments()->with(['service', 'professional'])->latest('scheduled_at')->limit(20)->get();
        $vacc = $this->pet->vaccines()->latest('date')->get();

        return view('livewire.pet-timeline', compact('appts', 'vacc'));
    }
}
