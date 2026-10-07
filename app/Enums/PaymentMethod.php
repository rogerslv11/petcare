<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case PIX = 'pix';
    case CASH = 'cash';
    case CREDIT = 'credit_card';
    case DEBIT = 'debit_card';
    case BOLETO = 'boleto';
    case TRANSFER = 'transfer';

    public function label(): string
    {
        return match ($this) {
            self::PIX => 'Pix',
            self::CASH => 'Cash',
            self::CREDIT => 'Credit Card',
            self::DEBIT => 'Debit Card',
            self::BOLETO => 'Boleto',
            self::TRANSFER => 'Transfer',
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
