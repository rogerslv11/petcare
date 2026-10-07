<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'category_id', 'name', 'description', 'duration_min', 'price', 'cost', 'commission_pct', 'status'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}
