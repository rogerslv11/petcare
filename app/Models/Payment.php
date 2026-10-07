<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'customer_id', 'sale_id', 'appointment_id', 'method', 'status', 'amount', 'discount', 'fee', 'paid_at', 'due_date', 'notes'];

    protected $casts = ['paid_at' => 'datetime', 'due_date' => 'date'];

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }
}
