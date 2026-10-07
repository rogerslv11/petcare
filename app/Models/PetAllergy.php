<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetAllergy extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'business_id', 'type', 'description', 'severity'];
}
