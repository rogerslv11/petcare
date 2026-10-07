<?php

namespace App\Enums;

enum CouponType: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';
    case FREE_SERVICE = 'free_service';

    public function label(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'Percentage',
            self::FIXED => 'Fixed',
            self::FREE_SERVICE => 'Free Service',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            'active','paid','completed','ready','checked_out','customer' => 'emerald',
            'pending','scheduled','waiting','reserved','new_lead' => 'amber',
            'cancelled','no_show','overdue','lost','expired','depleted' => 'rose',
            default => 'pink',
        };
    }
}
