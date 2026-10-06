<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Tarea;
use Illuminate\Http\Request;

class AlumnoPortalController extends Controller
{
    /**
     * Obtener el alumno que inició sesión.
     */
    private function alumnoActual(): Alumno
    {
        return Alumno::findOrFail(
            session('usuario_id')
        );
    }

    /**
     * Dashboard del alumno.
     */
    public function dashboard()
    {
        $alumno = $this->alumnoActual();

        $tareas = Tarea::query()
            ->where('cancelada', false)
            ->with([
                'entregas' => function ($query) use ($alumno) {
                    $query->where('alumno_id', $alumno->id)
                        ->with('calificacion');
                },
            ])
            ->orderBy('fecha_entrega')
            ->get();

        $activas = $tareas->count();

        $entregadas = $tareas
            ->filter(function ($tarea) {
                return $tarea->entregas->isNotEmpty();
            })
            ->count();

        $pendientes = $tareas
            ->filter(function ($tarea) {
                return $tarea->entregas->isEmpty()
                    && $tarea->fecha_entrega->isFuture();
            })
            ->count();

        $calificaciones = Calificacion::query()
            ->where('alumno_id', $alumno->id)
            ->where('estado', 'publicada')
            ->get();

        $promedio = $calificaciones->avg('calificacion');

        $estadisticas = [
            'activas' => $activas,
            'entregadas' => $entregadas,
            'pendientes' => $pendientes,
            'promedio' => $promedio,
        ];

        $proximasTareas = $tareas
            ->filter(function ($tarea) {
                return $tarea->fecha_entrega->isFuture();
            })
            ->take(5);

        return view(
            'alumno.dashboard',
            compact(
                'alumno',
                'estadisticas',
                'proximasTareas'
            )
        );
    }

    /**
     * Mostrar todas las tareas disponibles.
     */
    public function tareas()
    {
        $alumno = $this->alumnoActual();

        $tareas = Tarea::query()
            ->where('cancelada', false)
            ->with([
                'entregas' => function ($query) use ($alumno) {
                    $query->where('alumno_id', $alumno->id)
                        ->with('calificacion');
                },
            ])
            ->orderByDesc('fecha_entrega')
            ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | Crear relación auxiliar "entrega"
        |--------------------------------------------------------------------------
        |
        | Las vistas utilizan $tarea->entrega para acceder
        | directamente a la evidencia del alumno.
        |
        */

        $tareas->getCollection()->transform(
            function ($tarea) {
                $tarea->setRelation(
                    'entrega',
                    $tarea->entregas->first()
                );

                return $tarea;
            }
        );

        return view(
            'alumno.tareas',
            compact('tareas')
        );
    }

    /**
     * Mostrar una tarea específica.
     */
    public function tarea(Tarea $tarea)
    {
        $alumno = $this->alumnoActual();

        $entrega = $tarea->entregas()
            ->where('alumno_id', $alumno->id)
            ->with('calificacion')
            ->first();

        $calificacion = $entrega?->calificacion;

        return view(
            'alumno.tarea',
            compact(
                'alumno',
                'tarea',
                'entrega',
                'calificacion'
            )
        );
    }

    /**
     * Recibir evidencia del alumno.
     */
    public function entregar(
        Request $request,
        Tarea $tarea
    ) {
        $alumno = $this->alumnoActual();

        /*
        |--------------------------------------------------------------------------
        | Tarea cancelada
        |--------------------------------------------------------------------------
        */

        if ($tarea->cancelada) {
            return back()->with(
                'error',
                'Esta tarea fue cancelada y ya no acepta evidencias.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Fecha límite
        |--------------------------------------------------------------------------
        */

        if ($tarea->fecha_entrega->isPast()) {
            return back()->with(
                'error',
                'La fecha de entrega ya terminó.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Una sola evidencia por tarea
        |--------------------------------------------------------------------------
        */

        $yaEntrego = $tarea->entregas()
            ->where('alumno_id', $alumno->id)
            ->exists();

        if ($yaEntrego) {
            return back()->with(
                'error',
                'Ya tienes una evidencia registrada para esta tarea.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validación del PDF
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ], [
            'archivo.required' =>
                'Debes seleccionar un archivo PDF.',

            'archivo.file' =>
                'El archivo seleccionado no es válido.',

            'archivo.mimes' =>
                'La evidencia debe estar en formato PDF.',

            'archivo.max' =>
                'El archivo no puede superar los 10 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Guardar archivo
        |--------------------------------------------------------------------------
        */

        $archivo = $request->file('archivo');

        $ruta = $archivo->store(
            'evidencias/' . $tarea->id . '/' . $alumno->id,
            'public'
        );

        /*
        |--------------------------------------------------------------------------
        | Registrar evidencia
        |--------------------------------------------------------------------------
        */

        $tarea->entregas()->create([
            'alumno_id' => $alumno->id,
            'archivo' => $ruta,
            'nombre_archivo' =>
                $archivo->getClientOriginalName(),
        ]);

        return redirect()
            ->route('alumno.tarea', $tarea)
            ->with(
                'success',
                'Tu evidencia fue entregada correctamente.'
            );
    }

    /**
     * Historial de calificaciones publicadas.
     */
    public function historial()
    {
        $alumno = $this->alumnoActual();

        $calificaciones = Calificacion::query()
            ->where('alumno_id', $alumno->id)
            ->where('estado', 'publicada')
            ->with([
                'tarea',
                'entrega',
            ])
            ->orderByDesc('updated_at')
            ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | Asociar la evidencia correspondiente a la tarea
        |--------------------------------------------------------------------------
        */

        $calificaciones->getCollection()->transform(
            function ($calificacion) use ($alumno) {

                if ($calificacion->tarea) {
                    $entrega = $calificacion
                        ->tarea
                        ->entregas()
                        ->where('alumno_id', $alumno->id)
                        ->first();

                    $calificacion->tarea->setRelation(
                        'entrega',
                        $entrega
                    );
                }

                return $calificacion;
            }
        );

        $promedio = Calificacion::query()
            ->where('alumno_id', $alumno->id)
            ->where('estado', 'publicada')
            ->avg('calificacion');

        $estadisticas = [
            'calificadas' => $calificaciones->total(),
            'promedio' => $promedio,
        ];

        return view(
            'alumno.historial',
            compact(
                'calificaciones',
                'estadisticas'
            )
        );
    }
}