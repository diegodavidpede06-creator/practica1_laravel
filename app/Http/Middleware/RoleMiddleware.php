<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja una petición entrante.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        if (!$usuario->active) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Tu cuenta se encuentra desactivada.');
        }

        if (!in_array($usuario->role, $roles, true)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}