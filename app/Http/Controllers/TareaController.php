<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Entrega;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE TAREAS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $tareas = Tarea::query()
            ->orderByDesc('created_at')
            ->get();

        $total = $tareas->count();

        $activas = $tareas->filter(function ($tarea) {
            return !$tarea->cancelada
                && $tarea->fecha_entrega
                && now()->lt($tarea->fecha_entrega);
        })->count();

        $finalizadas = $tareas->filter(function ($tarea) {
            return !$tarea->cancelada
                && $tarea->fecha_entrega
                && now()->gte($tarea->fecha_entrega);
        })->count();

        $canceladas = $tareas->where('cancelada', true)->count();

        return view('tareas.index', compact(
            'tareas',
            'total',
            'activas',
            'finalizadas',
            'canceladas'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO CREAR
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('tareas.create');
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR TAREA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'tipo' => [
                'required',
                'in:casa,clase,exposicion',
            ],

            'fecha_entrega' => [
                'required',
                'date',
                'after:now',
            ],
        ], [
            'titulo.required' => 'El título de la tarea es obligatorio.',

            'titulo.max' => 'El título no puede superar los 255 caracteres.',

            'tipo.required' => 'Debes seleccionar el tipo de tarea.',

            'tipo.in' => 'El tipo de tarea seleccionado no es válido.',

            'fecha_entrega.required' => 'La fecha límite es obligatoria.',

            'fecha_entrega.date' => 'La fecha límite no es válida.',

            'fecha_entrega.after' => 'La fecha límite debe ser posterior a la fecha y hora actual.',
        ]);

        Tarea::create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'tipo' => $validated['tipo'],
            'fecha_entrega' => $validated['fecha_entrega'],
            'cancelada' => false,
        ]);

        return redirect()
            ->route('tareas.index')
            ->with('success', 'La tarea fue creada correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | VER TAREA
    |--------------------------------------------------------------------------
    */

    public function show(Tarea $tarea)
    {
        /*
        | Cargamos las relaciones existentes de la tarea.
        */
        $tarea->load([
            'entregas.alumno',
            'entregas.calificacion',
        ]);

        /*
        | Obtenemos todos los alumnos activos.
        |
        | Esto corrige el error:
        | Variable indefinida $alumnos
        */
        $alumnos = Alumno::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        /*
        | Entregas de esta tarea agrupadas por alumno.
        */
        $entregasPorAlumno = $tarea->entregas->keyBy('alumno_id');

        /*
        | Estadísticas de la tarea.
        */
        $totalAlumnos = $alumnos->count();

        $totalEntregas = $tarea->entregas->count();

        $entregasPendientes = max(
            0,
            $totalAlumnos - $totalEntregas
        );

        $totalCalificadas = $tarea->entregas
            ->filter(function ($entrega) {
                return $entrega->calificacion !== null;
            })
            ->count();

        $estadisticas = [
            'alumnos' => $totalAlumnos,
            'entregas' => $totalEntregas,
            'pendientes' => $entregasPendientes,
            'calificadas' => $totalCalificadas,
        ];

        return view('tareas.show', compact(
            'tarea',
            'alumnos',
            'entregasPorAlumno',
            'estadisticas'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | TAREAS CANCELADAS
    |--------------------------------------------------------------------------
    */

    public function canceladas()
    {
        $tareas = Tarea::query()
            ->where('cancelada', true)
            ->orderByDesc('updated_at')
            ->get();

        return view('tareas.canceladas', compact('tareas'));
    }


    /*
    |--------------------------------------------------------------------------
    | CANCELAR TAREA
    |--------------------------------------------------------------------------
    */

    public function cancelar(Tarea $tarea)
    {
        if ($tarea->cancelada) {
            return back()->with(
                'error',
                'La tarea ya se encuentra cancelada.'
            );
        }

        $tarea->update([
            'cancelada' => true,
        ]);

        return redirect()
            ->route('tareas.index')
            ->with(
                'success',
                'La tarea fue cancelada correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE EVALUACIÓN
    |--------------------------------------------------------------------------
    */

    public function evaluar(
        Tarea $tarea,
        Alumno $alumno
    ) {
        /*
        | No permitir calificar antes de la fecha límite.
        */
        if (
            $tarea->fecha_entrega &&
            now()->lt($tarea->fecha_entrega)
        ) {
            return back()->with(
                'error',
                'La tarea todavía no puede ser calificada porque no ha terminado el plazo de entrega.'
            );
        }

        /*
        | Buscar la evidencia del alumno.
        */
        $entrega = Entrega::query()
            ->where('tarea_id', $tarea->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if (!$entrega) {
            return back()->with(
                'error',
                'Este alumno todavía no ha entregado evidencia.'
            );
        }

        /*
        | Buscar calificación existente.
        */
        $calificacion = Calificacion::query()
            ->where('tarea_id', $tarea->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        return view(
            'tareas.evaluar',
            compact(
                'tarea',
                'alumno',
                'entrega',
                'calificacion'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR EVALUACIÓN
    |--------------------------------------------------------------------------
    */

    public function guardarEvaluacion(
        Request $request,
        Tarea $tarea,
        Alumno $alumno
    ) {
        /*
        | La calificación solamente puede hacerse
        | después de terminar el plazo.
        */
        if (
            $tarea->fecha_entrega &&
            now()->lt($tarea->fecha_entrega)
        ) {
            return back()->with(
                'error',
                'No puedes calificar esta tarea antes de que termine el plazo de entrega.'
            );
        }

        /*
        | Debe existir evidencia.
        */
        $entrega = Entrega::query()
            ->where('tarea_id', $tarea->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if (!$entrega) {
            return back()->with(
                'error',
                'El alumno no tiene una evidencia entregada para esta tarea.'
            );
        }

        /*
        | Validar calificación.
        */
        $validated = $request->validate([
            'calificacion' => [
                'required',
                'numeric',
                'min:0',
                'max:10',
            ],

            'estado' => [
                'required',
                'in:borrador,publicada',
            ],
        ], [
            'calificacion.required' =>
                'La calificación es obligatoria.',

            'calificacion.numeric' =>
                'La calificación debe ser un número.',

            'calificacion.min' =>
                'La calificación mínima es 0.',

            'calificacion.max' =>
                'La calificación máxima es 10.',

            'estado.required' =>
                'Debes seleccionar el estado de la calificación.',

            'estado.in' =>
                'El estado de la calificación no es válido.',
        ]);

        /*
        | Crear o actualizar calificación.
        */
        Calificacion::updateOrCreate(
            [
                'tarea_id' => $tarea->id,
                'alumno_id' => $alumno->id,
            ],
            [
                'calificacion' => $validated['calificacion'],
                'estado' => $validated['estado'],
            ]
        );

        $mensaje = $validated['estado'] === 'publicada'
            ? 'La calificación fue publicada correctamente.'
            : 'La calificación fue guardada como borrador.';

        return redirect()
            ->route(
                'tareas.show',
                $tarea
            )
            ->with(
                'success',
                $mensaje
            );
    }
}