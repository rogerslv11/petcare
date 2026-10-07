<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class PortalDashboard extends Component
{
    public function render()
    {
        $u = auth()->user();
        $cust = Customer::where('email', $u->email)->first();
        $pets = $cust?->pets()->with(['vaccines', 'appointments'])->get() ?? collect();
        $next = $cust?->appointments()->with('service')->upcoming()->first();

        return view('livewire.portal-dashboard', compact('cust', 'pets', 'next'));
    }
}
