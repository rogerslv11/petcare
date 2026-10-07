<?php

namespace App\Livewire;

use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Support\TenantContext;
use Livewire\Component;

class CashRegisterWidget extends Component
{
    public $register;

    public float $amount = 0;

    public string $desc = '';

    public string $kind = 'in';

    public function mount()
    {
        $this->register = CashRegister::where('business_id', TenantContext::businessId())->where('status', 'open')->latest()->first();
    }

    public function open()
    {
        $this->register = CashRegister::create(['business_id' => TenantContext::businessId(), 'branch_id' => session('current_branch_id'), 'user_id' => auth()->id(), 'status' => 'open', 'opened_at' => now(), 'opening_balance' => 0]);
    }

    public function move()
    {
        CashMovement::create(['cash_register_id' => $this->register->id, 'type' => $this->kind, 'amount' => $this->amount, 'description' => $this->desc]);
        $this->reset(['amount', 'desc']);
    }

    public function close()
    {
        $bal = $this->register->opening_balance + $this->register->movements()->where('type', 'in')->sum('amount') - $this->register->movements()->where('type', 'out')->sum('amount');
        $this->register->update(['status' => 'closed', 'closed_at' => now(), 'closing_balance' => $bal]);
        $this->register = null;
    }

    public function render()
    {
        return view('livewire.cash-register-widget');
    }
}
