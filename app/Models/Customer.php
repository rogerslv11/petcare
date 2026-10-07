<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use BelongsToBusiness, HasFactory, SoftDeletes;

    protected $fillable = ['business_id', 'branch_id', 'name', 'document', 'email', 'phone', 'whatsapp', 'birth_date', 'address', 'city', 'state', 'zip', 'notes', 'status', 'loyalty_points', 'custom_fields'];

    protected $casts = ['birth_date' => 'date', 'custom_fields' => 'array'];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function scopeSearch($q, $t)
    {
        return $q->where(fn ($x) => $x->where('name', 'like', "%$t%")->orWhere('phone', 'like', "%$t%")->orWhere('email', 'like', "%$t%"));
    }
}
