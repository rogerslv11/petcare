<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\Service;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $q = '';

    public $results = [];

    public function updatedQ()
    {
        $t = trim($this->q);
        if (strlen($t) < 2) {
            $this->results = [];

            return;
        }
        $this->results = ['customers' => Customer::search($t)->limit(5)->get(['id', 'name', 'phone'])->toArray(), 'pets' => Pet::search($t)->limit(5)->get(['id', 'name'])->toArray(), 'services' => Service::where('name', 'like', "%$t%")->limit(5)->get(['id', 'name'])->toArray()];
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
