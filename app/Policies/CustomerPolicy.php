<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Support\TenantContext;

class CustomerPolicy
{
    public function viewAny(User $u): bool
    {
        return $u->canAccess('customers');
    }

    public function view(User $u, Customer $c): bool
    {
        return TenantContext::businessId() === $c->business_id && $u->canAccess('customers');
    }

    public function create(User $u): bool
    {
        return $u->canAccess('customers');
    }

    public function update(User $u, Customer $c): bool
    {
        return TenantContext::businessId() === $c->business_id && $u->canAccess('customers');
    }

    public function delete(User $u, Customer $c): bool
    {
        return $u->hasRole('owner', 'manager');
    }
}
