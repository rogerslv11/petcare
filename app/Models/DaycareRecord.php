<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaycareRecord extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'pet_id', 'customer_id', 'date', 'check_in', 'check_out', 'status', 'activities', 'feeding', 'behavior', 'notes', 'price'];

    protected $casts = ['date' => 'date', 'activities' => 'array'];
}
