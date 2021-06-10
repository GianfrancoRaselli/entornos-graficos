<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
{
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->roles as $rol) {
          if ($rol->descripcion == "Administrador") return $next($request);
        }
        
        return response('No autorizado', 401);
    }
}
