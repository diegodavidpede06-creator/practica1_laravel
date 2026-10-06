@extends('layouts.app')

@section('title', 'Evaluar tarea')

@section('content')

<div class="page-header">

    <div>

        <a
            href="{{ route('docente.evidencias.show', [$tarea, $alumno]) }}"
            class="back-link"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>

            Volver a la evidencia
        </a>

        <h1>Evaluar evidencia</h1>

        <p>
            {{ $tarea->titulo }}
        </p>

    </div>

</div>


@if(session('success'))

    <div class="alert alert-success" data-auto-dismiss>

        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M5 12l4 4L19 6"/>
        </svg>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger" data-auto-dismiss>

        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 8v4"/>
            <path d="M12 16h.01"/>
            <circle cx="12" cy="12" r="9"/>
        </svg>

        <span>
            {{ session('error') }}
        </span>

    </div>

@endif


<div class="detail-grid">

    {{-- RESUMEN --}}
    <section class="card">

        <div class="card-header">

            <div>

                <h2>Datos de la evaluación</h2>

                <p>
                    Revisa la información antes de registrar la calificación.
                </p>

            </div>

        </div>


        <div class="student-mini-profile">

            <div class="avatar avatar-lg">
                {{ strtoupper(substr($alumno->nombre, 0, 1)) }}
            </div>

            <div>

                <strong>
                    {{ $alumno->nombre }}
                </strong>

                @if($alumno->matricula)
                    <span>
                        Matrícula: {{ $alumno->matricula }}
                    </span>
                @endif

            </div>

        </div>


        <div class="info-grid">

            <div class="info-item">

                <span>Tarea</span>

                <strong>
                    {{ $tarea->titulo }}
                </strong>

            </div>


            <div class="info-item">

                <span>Tipo</span>

                <strong>

                    @switch($tarea->tipo)

                        @case('casa')
                            Tarea en casa
                            @break

                        @case('clase')
                            Actividad en clase
                            @break

                        @case('exposicion')
                            Exposición
                            @break

                        @default
                            {{ $tarea->tipo }}

                    @endswitch

                </strong>

            </div>


            <div class="info-item">

                <span>Fecha límite</span>

                <strong>
                    {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}
                </strong>

            </div>


            <div class="info-item">

                <span>Estado</span>

                @if($tarea->cancelada)

                    <strong class="text-danger">
                        Cancelada
                    </strong>

                @else

                    <strong class="text-success">
                        Activa
                    </strong>

                @endif

            </div>

        </div>

    </section>


    {{-- FORMULARIO DE CALIFICACIÓN --}}
    <aside class="card">

        <div class="card-header">

            <div>

                <h2>Calificación</h2>

                <p>
                    La escala permitida es de 0 a 10.
                </p>

            </div>

        </div>


        @if($tarea->cancelada)

            <div class="alert alert-danger">

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M8 8l8 8"/>
                    <path d="M16 8l-8 8"/>
                </svg>

                <span>
                    No puedes calificar una tarea cancelada.
                </span>

            </div>


        @elseif(!$tarea->fecha_entrega->isPast())

            <div class="alert alert-warning">

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>

                <span>
                    Aún no se puede registrar la calificación.
                </span>

            </div>


        @else

            <form
                action="{{ route('tareas.evaluar.guardar', [$tarea, $alumno]) }}"
                method="POST"
                class="form-stack"
            >

                @csrf


                <div class="form-group">

                    <label for="calificacion">
                        Calificación
                    </label>


                    <div class="grade-input-wrapper">

                        <input
                            type="number"
                            id="calificacion"
                            name="calificacion"
                            value="{{ old('calificacion', $calificacion->calificacion ?? '') }}"
                            min="0"
                            max="10"
                            step="0.1"
                            inputmode="decimal"
                            required
                            data-grade-input
                        >

                        <span>
                            / 10
                        </span>

                    </div>


                    @error('calificacion')

                        <small class="form-error">
                            {{ $message }}
                        </small>

                    @enderror


                    <small class="form-help">
                        Puedes utilizar valores decimales.
                    </small>

                </div>


                <div class="grade-current">

                    <span>
                        Estado
                    </span>


                    @if(($calificacion->estado ?? null) === 'publicada')

                        <span class="badge badge-success">
                            Publicada
                        </span>

                    @elseif(($calificacion->estado ?? null) === 'borrador')

                        <span class="badge badge-warning">
                            Borrador
                        </span>

                    @else

                        <span class="badge badge-neutral">
                            Sin calificar
                        </span>

                    @endif

                </div>


                <div class="form-actions form-actions-stacked">

                    <button
                        type="submit"
                        name="accion"
                        value="publicar"
                        class="btn btn-primary btn-block"
                    >

                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3v12"/>
                            <path d="M7 8l5-5 5 5"/>
                            <path d="M5 21h14"/>
                            <path d="M5 17h14"/>
                        </svg>

                        Publicar calificación

                    </button>


                    <button
                        type="submit"
                        name="accion"
                        value="borrador"
                        class="btn btn-secondary btn-block"
                    >

                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 4h16v16H4z"/>
                            <path d="M8 4v5h8V4"/>
                            <path d="M8 15h8"/>
                        </svg>

                        Guardar como borrador

                    </button>

                </div>

            </form>

        @endif

    </aside>

</div>

@endsection