<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'business_id', 'name', 'date', 'batch', 'manufacturer', 'next_dose', 'vet_name', 'notes'];

    protected $casts = ['date' => 'date', 'next_dose' => 'date'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function scopeDueSoon($q, $days = 30)
    {
        return $q->whereBetween('next_dose', [now(), now()->addDays($days)]);
    }
}
