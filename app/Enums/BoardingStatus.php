<?php

namespace App\Enums;

enum BoardingStatus: string
{
    case RESERVED = 'reserved';
    case CHECKED_IN = 'checked_in';
    case STAYING = 'staying';
    case READY = 'ready';
    case CHECKED_OUT = 'checked_out';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::RESERVED => 'Reserved',
            self::CHECKED_IN => 'Checked In',
            self::STAYING => 'Staying',
            self::READY => 'Ready',
            self::CHECKED_OUT => 'Checked Out',
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
