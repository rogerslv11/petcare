<?php

namespace App\Services;

use App\Models\PackageCredit;

class PackageService
{
    public function consume(PackageCredit $credit): bool
    {
        if ($credit->remaining <= 0 || ($credit->expires_at && $credit->expires_at->isPast())) {
            $credit->update(['status' => 'expired']);

            return false;
        }
        $credit->increment('used_credits');
        if ($credit->remaining <= 0) {
            $credit->update(['status' => 'depleted']);
        }

        return true;
    }
}
