<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccesoMiddleware
{
    /**
     * Verifica que exista una sesión iniciada.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (
            !session()->has('tipo_usuario') ||
            !session()->has('usuario_id')
        ) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'usuario' => 'Debes iniciar sesión para continuar.',
                ]);
        }

        return $next($request);
    }
}