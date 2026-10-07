<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCredit extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'customer_id', 'pet_id', 'business_id', 'total_credits', 'used_credits', 'expires_at', 'status'];

    protected $casts = ['expires_at' => 'date'];

    public function getRemainingAttribute()
    {
        return $this->total_credits - $this->used_credits;
    }
}
