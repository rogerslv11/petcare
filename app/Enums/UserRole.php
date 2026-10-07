<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case OWNER = 'owner';
    case MANAGER = 'manager';
    case RECEPTIONIST = 'receptionist';
    case GROOMER = 'groomer';
    case BATH = 'bath';
    case VET = 'veterinarian';
    case SITTER = 'pet_sitter';
    case DAYCARE = 'daycare_staff';
    case CASHIER = 'cashier';
    case STOCK = 'stock_manager';
    case CUSTOMER = 'customer';
    case VIEWER = 'viewer';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::OWNER => 'Owner',
            self::MANAGER => 'Manager',
            self::RECEPTIONIST => 'Receptionist',
            self::GROOMER => 'Groomer',
            self::BATH => 'Bath',
            self::VET => 'Veterinarian',
            self::SITTER => 'Pet Sitter',
            self::DAYCARE => 'Daycare Staff',
            self::CASHIER => 'Cashier',
            self::STOCK => 'Stock Manager',
            self::CUSTOMER => 'Customer',
            self::VIEWER => 'Viewer',
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
