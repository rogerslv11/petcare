<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone', 'avatar', 'status', 'current_business_id', 'current_branch_id'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_user')->withPivot(['role', 'branch_id'])->withTimestamps();
    }

    public function currentBusiness()
    {
        return $this->belongsTo(Business::class, 'current_business_id');
    }

    public function hasRole(string ...$roles): bool
    {
        // Single-loja: primeiro usuário / owner tem tudo. Mantém compat com pivot legado.
        $pivot = $this->businesses->firstWhere('id', $this->current_business_id)?->pivot;
        if (! $pivot) {
            return true;
        }

        return in_array($pivot->role, $roles) || in_array($pivot->role, ['owner', 'super_admin']);
    }

    public function canAccess(string $perm): bool
    {
        // Sistema interno de loja única: acesso liberado (permissões granulares futuras).
        return true;
    }
}
