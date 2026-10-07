<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'price', 'cycle', 'services', 'benefits', 'status'];

    protected $casts = ['services' => 'array', 'benefits' => 'array'];
}
