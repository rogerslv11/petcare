<?php

namespace App\Enums;

enum DaycareStatus: string
{
    case SCHEDULED = 'scheduled';
    case CHECKED_IN = 'checked_in';
    case PLAYING = 'playing';
    case RESTING = 'resting';
    case FEEDING = 'feeding';
    case READY = 'ready';
    case CHECKED_OUT = 'checked_out';

    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled',
            self::CHECKED_IN => 'Checked In',
            self::PLAYING => 'Playing',
            self::RESTING => 'Resting',
            self::FEEDING => 'Feeding',
            self::READY => 'Ready',
            self::CHECKED_OUT => 'Checked Out',
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
