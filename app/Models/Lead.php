<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'phone', 'email', 'source', 'interest', 'status', 'last_contact_at', 'next_contact_at', 'notes'];

    protected $casts = ['last_contact_at' => 'datetime', 'next_contact_at' => 'datetime'];
}
