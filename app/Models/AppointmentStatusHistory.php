<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatusHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['appointment_id', 'from_status', 'to_status', 'user_id', 'created_at'];
}
