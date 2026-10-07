<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'customer_id', 'pet_id', 'professional_id', 'service_id', 'type', 'status', 'scheduled_at', 'ends_at', 'price', 'notes', 'preferences', 'cancellation_reason'];

    protected $casts = ['scheduled_at' => 'datetime', 'ends_at' => 'datetime', 'status' => AppointmentStatus::class];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(AppointmentStatusHistory::class);
    }

    public function groomingRecord()
    {
        return $this->hasOne(GroomingRecord::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeToday($q)
    {
        return $q->whereDate('scheduled_at', today());
    }

    public function scopeByStatus($q, $s)
    {
        return $q->where('status', $s);
    }

    public function scopeUpcoming($q)
    {
        return $q->where('scheduled_at', '>=', now())->orderBy('scheduled_at');
    }
}
