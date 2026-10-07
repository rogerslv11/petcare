<?php

namespace App\Http\Middleware;

use Closure;

class SetCurrentBranch
{
    public function handle($request, Closure $next)
    {
        if ($request->has('branch_id')) {
            session(['current_branch_id' => $request->branch_id]);
        }

        return $next($request);
    }
}
