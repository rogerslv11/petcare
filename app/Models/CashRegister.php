<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'branch_id', 'user_id', 'status', 'opened_at', 'closed_at', 'opening_balance', 'closing_balance', 'notes'];

    protected $casts = ['opened_at' => 'datetime', 'closed_at' => 'datetime'];

    public function movements()
    {
        return $this->hasMany(CashMovement::class);
    }
}
