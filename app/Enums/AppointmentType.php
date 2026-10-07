<?php

namespace App\Enums;

enum AppointmentType: string
{
    case BATH = 'bath';
    case GROOMING = 'grooming';
    case VET = 'vet';
    case DAYCARE = 'daycare';
    case BOARDING = 'boarding';
    case EVALUATION = 'evaluation';
    case PICKUP = 'pickup';

    public function label(): string
    {
        return match ($this) {
            self::BATH => 'Bath',
            self::GROOMING => 'Grooming',
            self::VET => 'Vet',
            self::DAYCARE => 'Daycare',
            self::BOARDING => 'Boarding',
            self::EVALUATION => 'Evaluation',
            self::PICKUP => 'Pickup',
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
