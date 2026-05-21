<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCliente
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->isCliente()) {
            abort(403, 'Solo los clientes pueden acceder a este recurso.');
        }

        return $next($request);
    }
}
