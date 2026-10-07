<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'product_id', 'user_id', 'type', 'qty', 'reason'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
