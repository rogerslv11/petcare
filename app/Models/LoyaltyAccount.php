<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyAccount extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'customer_id', 'points', 'total_earned', 'total_redeemed'];

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }
}
