<?php

namespace App\Livewire;

use App\Services\ReportService;
use App\Support\TenantContext;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render(ReportService $rep)
    {
        $biz = TenantContext::businessId();
        $kpis = $biz ? $rep->kpis($biz) : [];
        $rev = $biz ? $rep->revenueByDay($biz) : ['labels' => [], 'data' => []];

        return view('livewire.dashboard-stats', compact('kpis', 'rev'));
    }
}
