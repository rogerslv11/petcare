<?php

namespace App\Livewire;

use App\Models\FinancialTransaction;
use App\Models\Payment;
use App\Support\TenantContext;
use Livewire\Component;

class FinancialDashboard extends Component
{
    public function render()
    {
        $biz = TenantContext::businessId();
        $rev = Payment::forBusiness($biz)->where('status', 'paid')->whereMonth('paid_at', now()->month)->sum('amount');
        $exp = FinancialTransaction::where('business_id', $biz)->where('type', 'expense')->whereMonth('date', now()->month)->sum('amount');
        $rows = FinancialTransaction::where('business_id', $biz)->latest()->limit(15)->get();

        return view('livewire.financial-dashboard', compact('rev', 'exp', 'rows'));
    }
}
