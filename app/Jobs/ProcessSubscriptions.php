<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSubscriptions implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle(): void
    {
        Subscription::where('status', 'active')->whereDate('ends_at', '<', today())->update(['status' => 'expired']);
    }
}
