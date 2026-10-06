<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AlumnoPortalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD GENERAL
|--------------------------------------------------------------------------
*/

Route::middleware('acceso')->group(function () {

    Route::get('/dashboard', function () {

        $tipo = session('tipo_usuario');

        if ($tipo === 'docente') {
            return redirect()->route('docente.dashboard');
        }

        return redirect()->route('alumno.dashboard');

    })->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| ÁREA DEL DOCENTE
|--------------------------------------------------------------------------
*/

Route::middleware(['acceso', 'docente'])
    ->prefix('docente')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {
            return view('docente.dashboard');
        })->name('docente.dashboard');


        /*
        |--------------------------------------------------------------------------
        | ALUMNOS
        |--------------------------------------------------------------------------
        */

        Route::prefix('alumnos')
            ->name('docente.alumnos.')
            ->group(function () {

                Route::get(
                    '/',
                    [AlumnoController::class, 'index']
                )->name('index');

                Route::get(
                    '/crear',
                    [AlumnoController::class, 'create']
                )->name('create');

                Route::post(
                    '/',
                    [AlumnoController::class, 'store']
                )->name('store');

                Route::post(
                    '/importar',
                    [AlumnoController::class, 'importar']
                )->name('importar');

                Route::get(
                    '/{alumno}',
                    [AlumnoController::class, 'show']
                )->name('show');

                Route::get(
                    '/{alumno}/editar',
                    [AlumnoController::class, 'edit']
                )->name('edit');

                Route::put(
                    '/{alumno}',
                    [AlumnoController::class, 'update']
                )->name('update');

                Route::patch(
                    '/{alumno}/estado',
                    [AlumnoController::class, 'toggle']
                )->name('toggle');
            });


        /*
        |--------------------------------------------------------------------------
        | TAREAS
        |--------------------------------------------------------------------------
        */

        Route::prefix('tareas')
            ->name('tareas.')
            ->group(function () {

                /*
                | Lista
                */

                Route::get(
                    '/',
                    [TareaController::class, 'index']
                )->name('index');


                /*
                | Crear
                */

                Route::get(
                    '/crear',
                    [TareaController::class, 'create']
                )->name('create');

                Route::post(
                    '/',
                    [TareaController::class, 'store']
                )->name('store');


                /*
                | Canceladas
                */

                Route::get(
                    '/canceladas',
                    [TareaController::class, 'canceladas']
                )->name('canceladas');


                /*
                | Ver tarea
                */

                Route::get(
                    '/{tarea}',
                    [TareaController::class, 'show']
                )->name('show');


                /*
                | Cancelar
                */

                Route::post(
                    '/{tarea}/cancelar',
                    [TareaController::class, 'cancelar']
                )->name('cancelar');


                /*
                | Evaluar
                */

                Route::get(
                    '/{tarea}/alumno/{alumno}/evaluar',
                    [TareaController::class, 'evaluar']
                )->name('evaluar');

                Route::post(
                    '/{tarea}/alumno/{alumno}/evaluar',
                    [TareaController::class, 'guardarEvaluacion']
                )->name('evaluar.guardar');
            });


        /*
        |--------------------------------------------------------------------------
        | EVIDENCIA DE ALUMNO
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/tareas/{tarea}/alumno/{alumno}/evidencia',
            [EvidenciaController::class, 'show']
        )->name('docente.evidencias.show');

    });


/*
|--------------------------------------------------------------------------
| ÁREA DEL ALUMNO
|--------------------------------------------------------------------------
*/

Route::middleware(['acceso', 'alumno'])
    ->prefix('alumno')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [AlumnoPortalController::class, 'dashboard']
        )->name('alumno.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Tareas
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/tareas',
            [AlumnoPortalController::class, 'tareas']
        )->name('alumno.tareas');


        Route::get(
            '/tareas/{tarea}',
            [AlumnoPortalController::class, 'tarea']
        )->name('alumno.tarea');


        /*
        |--------------------------------------------------------------------------
        | Entregar evidencia
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/tareas/{tarea}/entregar',
            [AlumnoPortalController::class, 'entregar']
        )->name('alumno.tarea.entregar');


        /*
        |--------------------------------------------------------------------------
        | Historial
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/historial',
            [AlumnoPortalController::class, 'historial']
        )->name('alumno.historial');
    });