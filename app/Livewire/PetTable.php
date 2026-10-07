<?php

namespace App\Livewire;

use App\Models\Pet;
use Livewire\Component;
use Livewire\WithPagination;

class PetTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $rows = Pet::with(['customer', 'species', 'breed'])->when($this->search, fn ($q) => $q->search($this->search))->latest()->paginate(12);

        return view('livewire.pet-table', compact('rows'));
    }
}
