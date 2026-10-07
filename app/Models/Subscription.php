<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'plan_id', 'customer_id', 'pet_id', 'status', 'started_at', 'ends_at', 'price'];

    protected $casts = ['started_at' => 'date', 'ends_at' => 'date'];
}
