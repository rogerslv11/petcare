<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'code', 'type', 'value', 'min_value', 'usage_limit', 'used', 'starts_at', 'ends_at', 'status'];

    protected $casts = ['starts_at' => 'date', 'ends_at' => 'date'];
}
