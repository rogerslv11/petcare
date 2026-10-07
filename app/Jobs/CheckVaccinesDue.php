<?php

namespace App\Jobs;

use App\Models\Vaccine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckVaccinesDue implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle(): void
    {
        $due = Vaccine::whereBetween('next_dose', [now(), now()->addDays(7)])->count();
        \Log::info("[Vaccines] $due vacinas vencendo em 7 dias");
    }
}
