<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetBreed extends Model
{
    use HasFactory;

    protected $fillable = ['species_id', 'business_id', 'name', 'size', 'custom'];

    public function species()
    {
        return $this->belongsTo(PetSpecies::class, 'species_id');
    }
}
