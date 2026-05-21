<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEmprendedor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->isEmprendedor()) {
            abort(403, 'Solo los emprendedores pueden acceder a este recurso.');
        }

        return $next($request);
    }
}
