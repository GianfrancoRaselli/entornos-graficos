<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateUsuario
{
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->roles as $rol) {
          if ($rol->descripcion == "Usuario") return $next($request);
        }
        
        return response('No autorizado', 401);
    }
}
