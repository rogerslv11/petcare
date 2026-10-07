<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'customer_id', 'pet_id', 'user_id', 'subtotal', 'discount', 'total', 'coupon_code', 'notes', 'status'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
