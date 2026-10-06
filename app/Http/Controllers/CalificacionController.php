<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Tarea;

class CalificacionController extends Controller
{
    /**
     * Mostrar el listado de calificaciones.
     */
    public function index()
    {
        // Todas las calificaciones con sus relaciones
        $calificaciones = Calificacion::with([
            'alumno',
            'tarea',
            'entrega',
        ])
        ->orderByDesc('id')
        ->get();

        // Alumnos activos para el filtro
        $alumnos = Alumno::where('activo', true)
            ->orderBy('nombre')
            ->get();

        // Todas las tareas para el filtro
        $tareas = Tarea::orderByDesc('fecha_limite')
            ->get();

        // Estadísticas
        $total = $calificaciones->count();

        $publicadas = $calificaciones
            ->where('estado', 'publicada')
            ->count();

        $borradores = $calificaciones
            ->where('estado', 'borrador')
            ->count();

        $promedio = $calificaciones
            ->where('estado', 'publicada')
            ->avg('calificacion');

        // Evitar null en la vista
        $promedio = $promedio !== null
            ? round($promedio, 2)
            : 0;

        return view('calificaciones.index', compact(
            'calificaciones',
            'alumnos',
            'tareas',
            'total',
            'publicadas',
            'borradores',
            'promedio'
        ));
    }
}