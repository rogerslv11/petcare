<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'business_id', 'name', 'dosage', 'frequency', 'time', 'start_date', 'end_date', 'instructions', 'responsible'];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
