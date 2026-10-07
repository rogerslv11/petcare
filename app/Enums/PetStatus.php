<?php

namespace App\Enums;

enum PetStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DECEASED = 'deceased';
    case TRANSFERRED = 'transferred';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::DECEASED => 'Deceased',
            self::TRANSFERRED => 'Transferred',
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
