<?php

namespace App\Http\Middleware;

use Closure;

class EnsureTenantAccess
{
    // Sistema single-loja: qualquer usuário autenticado tem acesso.
    // Mantido por compatibilidade com rotas antigas.
    public function handle($request, Closure $next, string $perm = 'agenda')
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
