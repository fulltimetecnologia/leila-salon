<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! currentUser()->isAdmin()) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
