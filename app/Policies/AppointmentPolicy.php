<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use App\Support\TenantContext;

class AppointmentPolicy
{
    public function viewAny(User $u): bool
    {
        return $u->canAccess('agenda');
    }

    public function view(User $u, Appointment $a): bool
    {
        return TenantContext::businessId() === $a->business_id;
    }

    public function create(User $u): bool
    {
        return $u->canAccess('agenda');
    }

    public function update(User $u, Appointment $a): bool
    {
        return TenantContext::businessId() === $a->business_id && $u->canAccess('agenda');
    }

    public function delete(User $u, Appointment $a): bool
    {
        return $u->hasRole('owner', 'manager', 'receptionist');
    }
}
