<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateJefeCatedra
{
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->roles as $rol) {
          if ($rol->descripcion == "Jefe Catedra") return $next($request);
        }
        
        return response('No autorizado', 401);
    }
}
