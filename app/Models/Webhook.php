<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'url', 'secret', 'events', 'status'];

    protected $casts = ['events' => 'array'];
}
