<?php

namespace App\Livewire;

use App\Models\Commission;
use App\Support\TenantContext;
use Livewire\Component;

class CommissionTable extends Component
{
    public function pay(int $id)
    {
        Commission::findOrFail($id)->update(['status' => 'paid', 'paid_at' => now()]);
    }

    public function render()
    {
        $rows = Commission::with('professional')->where('business_id', TenantContext::businessId())->latest()->paginate(15);

        return view('livewire.commission-table', compact('rows'));
    }
}
