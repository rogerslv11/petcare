<?php

namespace App\Enums;

enum LeadStatus: string
{
    case NEW = 'new_lead';
    case CONTACTED = 'contacted';
    case INTERESTED = 'interested';
    case SCHEDULED = 'scheduled';
    case FIRST_VISIT = 'first_visit';
    case CUSTOMER = 'customer';
    case LOST = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New Lead',
            self::CONTACTED => 'Contacted',
            self::INTERESTED => 'Interested',
            self::SCHEDULED => 'Scheduled',
            self::FIRST_VISIT => 'First Visit',
            self::CUSTOMER => 'Customer',
            self::LOST => 'Lost',
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
