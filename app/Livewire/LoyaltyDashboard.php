<?php

namespace App\Livewire;

use App\Models\LoyaltyAccount;
use App\Models\LoyaltyTransaction;
use App\Support\TenantContext;
use Livewire\Component;

class LoyaltyDashboard extends Component
{
    public function redeem(int $id)
    {
        $a = LoyaltyAccount::findOrFail($id);
        if ($a->points >= 500) {
            $a->decrement('points', 500);
            $a->increment('total_redeemed', 500);
            LoyaltyTransaction::create(['loyalty_account_id' => $a->id, 'points' => -500, 'type' => 'redeem', 'description' => 'Resgate R$20']);
        }
    }

    public function render()
    {
        $rows = LoyaltyAccount::with('customer')->where('business_id', TenantContext::businessId())->orderByDesc('points')->paginate(15);

        return view('livewire.loyalty-dashboard', compact('rows'));
    }
}
