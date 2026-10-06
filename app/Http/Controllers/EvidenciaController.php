<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Tarea;

class EvidenciaController extends Controller
{
    /**
     * Mostrar la evidencia de un alumno para una tarea.
     */
    public function show(Tarea $tarea, Alumno $alumno)
    {
        $evidencia = $tarea->entregas()
            ->where('alumno_id', $alumno->id)
            ->with('calificacion')
            ->first();

        if (!$evidencia) {
            return redirect()
                ->route('tareas.show', $tarea)
                ->with(
                    'error',
                    'El alumno todavía no ha entregado evidencia para esta tarea.'
                );
        }

        $calificacion = $evidencia->calificacion;

        return view(
            'docente.evidencias.show',
            compact(
                'tarea',
                'alumno',
                'evidencia',
                'calificacion'
            )
        );
    }
}