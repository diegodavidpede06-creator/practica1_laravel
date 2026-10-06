<?php

use App\Http\Middleware\AccesoMiddleware;
use App\Http\Middleware\AlumnoMiddleware;
use App\Http\Middleware\DocenteMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'acceso' => AccesoMiddleware::class,
            'docente' => DocenteMiddleware::class,
            'alumno' => AlumnoMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();