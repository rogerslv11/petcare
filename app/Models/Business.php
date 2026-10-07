<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'document', 'email', 'phone', 'plan', 'status', 'settings'];

    protected $casts = ['settings' => 'array'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'business_user')->withPivot(['role', 'branch_id']);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }
}
