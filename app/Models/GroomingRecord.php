<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroomingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_id', 'pet_id', 'business_id', 'type', 'status', 'machine', 'blade_height', 'behavior', 'products_used', 'notes', 'started_at', 'finished_at', 'professional_id', 'before_photo', 'after_photo'];

    protected $casts = ['started_at' => 'datetime', 'finished_at' => 'datetime', 'products_used' => 'array'];
}
