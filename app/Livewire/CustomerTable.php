<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    protected $queryString = ['search', 'status'];

    public function render()
    {
        $rows = Customer::withCount('pets')->when($this->search, fn ($q) => $q->search($this->search))->when($this->status, fn ($q) => $q->where('status', $this->status))->latest()->paginate(12);

        return view('livewire.customer-table', compact('rows'));
    }

    public function delete(int $id)
    {
        $this->authorize('delete', Customer::withoutGlobalScope('business')->findOrFail($id));
        Customer::withoutGlobalScope('business')->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Cliente excluído');
    }
}
