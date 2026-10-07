<?php

namespace App\Enums;

enum GroomingStatus: string
{
    case SCHEDULED = 'scheduled';
    case WAITING = 'waiting';
    case IN_BATH = 'in_bath';
    case DRYING = 'drying';
    case READY = 'ready';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled',
            self::WAITING => 'Waiting',
            self::IN_BATH => 'In Bath',
            self::DRYING => 'Drying',
            self::READY => 'Ready',
            self::COMPLETED => 'Completed',
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
