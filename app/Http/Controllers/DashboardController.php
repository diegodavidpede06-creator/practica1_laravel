<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Tarea;
use App\Models\Evidencia;
use App\Models\Calificacion;

class DashboardController extends Controller
{
    /**
     * Dashboard del docente.
     */
    public function docente()
    {
        $docente = auth()->user()->docente;

        $totalAlumnos = Alumno::where('activo', true)->count();

        $totalTareas = $docente->tareas()->count();

        $tareasActivas = $docente->tareas()
            ->where('estado', 'activa')
            ->count();

        $tareasVencidas = $docente->tareas()
            ->where('estado', 'activa')
            ->where('fecha_limite', '<', now())
            ->count();

        $evidenciasPendientes = 0;

        $alumnosActivos = Alumno::where('activo', true)->count();

        $tareas = $docente->tareas()
            ->where('estado', 'activa')
            ->get();

        foreach ($tareas as $tarea) {
            $entregadas = $tarea->evidencias()->count();

            $evidenciasPendientes += max(
                0,
                $alumnosActivos - $entregadas
            );
        }

        $ultimasTareas = $docente->tareas()
            ->withCount('evidencias')
            ->latest('fecha_asignacion')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalAlumnos',
            'totalTareas',
            'tareasActivas',
            'tareasVencidas',
            'evidenciasPendientes',
            'ultimasTareas'
        ));
    }

    /**
     * Dashboard del alumno.
     */
    public function alumno()
    {
        $alumno = auth()->user()->alumno;

        $tareas = Tarea::where('estado', 'activa')
            ->with([
                'evidencias' => function ($query) use ($alumno) {
                    $query->where('alumno_id', $alumno->id);
                },
                'calificaciones' => function ($query) use ($alumno) {
                    $query
                        ->where('alumno_id', $alumno->id)
                        ->where('estado', 'publicada');
                },
            ])
            ->orderByDesc('fecha_asignacion')
            ->get();

        $totalTareas = $tareas->count();

        $entregadas = $tareas->filter(function ($tarea) {
            return $tarea->evidencias->isNotEmpty();
        })->count();

        $pendientes = $tareas->filter(function ($tarea) {
            return $tarea->evidencias->isEmpty();
        })->count();

        $calificadas = $tareas->filter(function ($tarea) {
            return $tarea->calificaciones->isNotEmpty();
        })->count();

        return view('alumno.dashboard', compact(
            'tareas',
            'totalTareas',
            'entregadas',
            'pendientes',
            'calificadas'
        ));
    }
}