<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetSpecies extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'status'];

    public function breeds()
    {
        return $this->hasMany(PetBreed::class, 'species_id');
    }
}
