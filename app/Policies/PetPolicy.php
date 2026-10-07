<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use App\Support\TenantContext;

class PetPolicy
{
    public function viewAny(User $u): bool
    {
        return $u->canAccess('pets');
    }

    public function view(User $u, Pet $p): bool
    {
        return TenantContext::businessId() === $p->business_id;
    }

    public function create(User $u): bool
    {
        return $u->canAccess('pets') || $u->canAccess('customers');
    }

    public function update(User $u, Pet $p): bool
    {
        return TenantContext::businessId() === $p->business_id;
    }

    public function delete(User $u, Pet $p): bool
    {
        return $u->hasRole('owner', 'manager');
    }
}
