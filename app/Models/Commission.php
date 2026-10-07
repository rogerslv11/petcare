<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'professional_id', 'appointment_id', 'amount', 'pct', 'status', 'paid_at'];

    protected $casts = ['paid_at' => 'datetime'];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
