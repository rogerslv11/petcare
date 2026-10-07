<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\Product;

class ReportService
{
    public function revenueByDay(int $biz, int $days = 14): array
    {
        $rows = Payment::forBusiness($biz)->where('status', 'paid')->where('paid_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(paid_at) d, SUM(amount) total')->groupBy('d')->orderBy('d')->get();

        return ['labels' => $rows->pluck('d'), 'data' => $rows->pluck('total')];
    }

    public function topServices(int $biz, int $limit = 5)
    {
        return Appointment::forBusiness($biz)->selectRaw('service_id, COUNT(*) c')->with('service')->groupBy('service_id')->orderByDesc('c')->limit($limit)->get();
    }

    public function kpis(int $biz): array
    {
        return [
            'revenue_today' => Payment::forBusiness($biz)->where('status', 'paid')->whereDate('paid_at', today())->sum('amount'),
            'revenue_month' => Payment::forBusiness($biz)->where('status', 'paid')->whereMonth('paid_at', now()->month)->sum('amount'),
            'appt_today' => Appointment::forBusiness($biz)->whereDate('scheduled_at', today())->count(),
            'pets_waiting' => Appointment::forBusiness($biz)->whereDate('scheduled_at', today())->whereIn('status', ['checked_in', 'in_service'])->count(),
            'pending_payments' => Payment::forBusiness($biz)->where('status', 'pending')->sum('amount'),
            'low_stock' => Product::forBusiness($biz)->whereColumn('stock', '<=', 'min_stock')->count(),
            'active_customers' => Customer::forBusiness($biz)->where('status', 'active')->count(),
            'pets' => Pet::forBusiness($biz)->count(),
        ];
    }
}
