<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use BelongsToBusiness, HasFactory, SoftDeletes;

    protected $fillable = ['business_id', 'customer_id', 'species_id', 'breed_id', 'name', 'photo', 'sex', 'birth_date', 'weight', 'color', 'size', 'microchip', 'temperament', 'behavior', 'notes', 'status', 'allergies_summary', 'custom_fields'];

    protected $casts = ['birth_date' => 'date', 'custom_fields' => 'array'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function species()
    {
        return $this->belongsTo(PetSpecies::class, 'species_id');
    }

    public function breed()
    {
        return $this->belongsTo(PetBreed::class, 'breed_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function allergies()
    {
        return $this->hasMany(PetAllergy::class);
    }

    public function photos()
    {
        return $this->hasMany(PetPhoto::class);
    }

    public function groomingRecords()
    {
        return $this->hasMany(GroomingRecord::class);
    }

    public function getAgeAttribute(): ?string
    {
        if (! $this->birth_date) {
            return null;
        } $d = $this->birth_date->diff(now());

        return $d->y > 0 ? "{$d->y}a {$d->m}m" : "{$d->m}m";
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function scopeSearch($q, $t)
    {
        return $q->where(fn ($x) => $x->where('name', 'like', "%$t%")->orWhere('microchip', 'like', "%$t%"));
    }
}
