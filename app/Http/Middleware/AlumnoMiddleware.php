<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlumnoMiddleware
{
    /**
     * Permite el acceso únicamente al alumno.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (session('tipo_usuario') !== 'alumno') {
            return redirect()
                ->route('docente.dashboard')
                ->withErrors([
                    'acceso' => 'No tienes permiso para acceder a esta sección.',
                ]);
        }

        return $next($request);
    }
}