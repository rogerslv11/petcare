<?php

namespace App\Concerns;

use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToBusiness
{
    public static function bootBelongsToBusiness(): void
    {
        static::creating(function ($m) {
            if (! $m->business_id) {
                $id = auth()->check() ? auth()->user()->current_business_id : null;
                $m->business_id = $id ?? TenantContext::businessId();
            }
        });
        static::addGlobalScope('business', function (Builder $q) {
            if (! in_array('business_id', $q->getModel()->getFillable())) {
                return;
            }
            $id = auth()->check() ? auth()->user()->current_business_id : null;
            $id = $id ?? TenantContext::businessId();
            if ($id) {
                $q->where($q->getModel()->getTable().'.business_id', $id);
            }
        });
    }

    public function scopeForBusiness(Builder $q, int $id): Builder
    {
        return $q->withoutGlobalScope('business')->where('business_id', $id);
    }
}
