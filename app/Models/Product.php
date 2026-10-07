<?php

namespace App\Models;

use App\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToBusiness, HasFactory;

    protected $fillable = ['business_id', 'category_id', 'name', 'sku', 'barcode', 'price', 'cost', 'stock', 'min_stock', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function scopeLowStock($q)
    {
        return $q->whereColumn('stock', '<=', 'min_stock');
    }
}
