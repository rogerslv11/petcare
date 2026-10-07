<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'type', 'category', 'description', 'amount', 'date', 'status'];

    protected $casts = ['date' => 'date'];
}
