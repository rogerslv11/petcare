<?php

namespace App\Support;

use App\Models\Business;

class TenantContext
{
    // Sistema single-loja: sempre usa a empresa única (cria se não existir).
    public static function businessId(): ?int
    {
        if (auth()->check() && auth()->user()->current_business_id) {
            return (int) auth()->user()->current_business_id;
        }
        try {
            $biz = Business::first();
            if (! $biz) {
                $biz = Business::create(['name' => config('app.name', 'PetCare'), 'slug' => 'loja', 'email' => 'contato@petcare.test']);
            }

            return $biz->id;
        } catch (\Throwable $e) {
            return auth()->check() ? auth()->user()->current_business_id : null;
        }
    }

    public static function branchId(): ?int
    {
        return session('current_branch_id') ?? auth()->user()?->current_branch_id;
    }
}
