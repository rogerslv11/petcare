<?php

namespace App\Livewire;

use App\Models\GroomingRecord;
use Livewire\Component;

class GroomingBoard extends Component
{
    public function render()
    {
        $cols = ['scheduled' => GroomingRecord::with('pet')->where('status', 'scheduled')->get(), 'in_bath' => GroomingRecord::with('pet')->where('status', 'in_bath')->get(), 'drying' => GroomingRecord::with('pet')->where('status', 'drying')->get(), 'ready' => GroomingRecord::with('pet')->where('status', 'ready')->get()];

        return view('livewire.grooming-board', compact('cols'));
    }

    public function move(int $id, string $to)
    {
        GroomingRecord::findOrFail($id)->update(['status' => $to]);
    }
}
