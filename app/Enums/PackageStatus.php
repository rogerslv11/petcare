<?php

namespace App\Enums;

enum PackageStatus: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case DEPLETED = 'depleted';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::DEPLETED => 'Depleted',
            self::CANCELLED => 'Cancelled',
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
