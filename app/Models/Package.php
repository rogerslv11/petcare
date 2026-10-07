<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'description', 'price', 'validity_days', 'status', 'services'];

    protected $casts = ['services' => 'array'];

    public function credits()
    {
        return $this->hasMany(PackageCredit::class);
    }
}
