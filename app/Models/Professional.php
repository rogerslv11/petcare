<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'user_id', 'name', 'document', 'email', 'phone', 'role', 'specialties', 'commission_pct', 'status', 'color'];

    protected $casts = ['specialties' => 'array'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
