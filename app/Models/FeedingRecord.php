<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'business_id', 'food_type', 'qty', 'time', 'notes', 'source'];
}
