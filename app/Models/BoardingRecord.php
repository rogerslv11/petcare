<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'pet_id', 'customer_id', 'unit', 'check_in', 'check_out', 'status', 'feeding', 'medication', 'activities', 'notes', 'price'];

    protected $casts = ['check_in' => 'datetime', 'check_out' => 'datetime'];
}
