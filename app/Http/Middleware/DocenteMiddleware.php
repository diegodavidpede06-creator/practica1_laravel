<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocenteMiddleware
{
    /**
     * Permite el acceso únicamente al docente.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (session('tipo_usuario') !== 'docente') {
            return redirect()
                ->route('alumno.dashboard')
                ->withErrors([
                    'acceso' => 'No tienes permiso para acceder a esta sección.',
                ]);
        }

        return $next($request);
    }
}