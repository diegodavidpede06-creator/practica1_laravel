@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">
            <a href="{{ route('tareas.show', $tarea) }}">
                Regresar
            </a>
        </div>

        <h1 class="page-title">
            Evidencia del alumno
        </h1>

        <p class="page-description">
            Revisión de la evidencia entregada para la tarea.
        </p>

    </div>

</div>


{{-- ==========================================================
    INFORMACIÓN DE LA EVIDENCIA
=========================================================== --}}

<div class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Archivo entregado
            </h2>

            <p class="card-subtitle">
                Evidencia enviada por el alumno.
            </p>

        </div>

        @if($evidencia && $evidencia->archivo)

            <a
                href="{{ asset('storage/' . $evidencia->archivo) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-secondary"
            >

                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        d="M14 3h7v7"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M21 3 12 12"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <path
                        d="M19 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

                Abrir PDF

            </a>

        @endif

    </div>


    @if(!$evidencia)

        <div class="card-body">

            <div class="empty-state">

                <div class="empty-state-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M12 8v4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <circle
                            cx="12"
                            cy="16"
                            r="1"
                            fill="currentColor"
                        />
                    </svg>

                </div>

                <h3>
                    El alumno no ha entregado evidencia
                </h3>

                <p>
                    Actualmente no existe una entrega registrada para esta tarea.
                </p>

            </div>

        </div>

    @else

        {{-- ==================================================
            DATOS DEL ALUMNO
        =================================================== --}}

        <div class="card-body">

            <div class="profile-summary">

                <div class="avatar avatar-md">

                    {{ strtoupper(substr($alumno->nombre, 0, 1)) }}

                </div>

                <div>

                    <h3>
                        {{ $alumno->nombre }}
                    </h3>

                    <p>
                        Usuario: {{ $alumno->usuario }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================================
            INFORMACIÓN DE LA TAREA
        =================================================== --}}

        <div class="card-body">

            <div class="info-grid">

                <div class="info-item">

                    <span class="info-label">
                        Tarea
                    </span>

                    <strong>
                        {{ $tarea->titulo }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Tipo
                    </span>

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
                                {{ ucfirst($tarea->tipo) }}

                        @endswitch

                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Fecha de entrega
                    </span>

                    <strong>

                        @if($tarea->fecha_entrega)

                            {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i') }}

                        @else

                            Sin fecha

                        @endif

                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Entrega realizada
                    </span>

                    <strong>

                        {{ $evidencia->created_at
                            ? $evidencia->created_at->format('d/m/Y H:i')
                            : 'Sin fecha'
                        }}

                    </strong>

                </div>

            </div>

        </div>


        {{-- ==================================================
            ARCHIVO
        =================================================== --}}

        <div class="card-body">

            <h3 class="section-title">
                Archivo enviado
            </h3>

            <div class="file-card">

                <div class="file-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M14 3v5h5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M8 15h8M8 18h6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                </div>


                <div class="file-info">

                    <strong>

                        {{ $evidencia->nombre_archivo
                            ?? basename($evidencia->archivo)
                        }}

                    </strong>

                    <span>
                        Archivo PDF
                    </span>

                </div>


                @if($evidencia->archivo)

                    <a
                        href="{{ asset('storage/' . $evidencia->archivo) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-secondary"
                    >

                        Abrir PDF

                    </a>

                @endif

            </div>

        </div>


        {{-- ==================================================
            EVALUACIÓN
        =================================================== --}}

        <div class="card-body">

            <div class="section-header">

                <div>

                    <h2 class="card-title">
                        Evaluación
                    </h2>

                    <p class="card-subtitle">
                        Consulta o registra la calificación.
                    </p>

                </div>

            </div>


            @php

                $fechaEntrega = $tarea->fecha_entrega
                    ? \Carbon\Carbon::parse($tarea->fecha_entrega)
                    : null;

                $puedeEvaluar = $fechaEntrega
                    ? now()->greaterThanOrEqualTo($fechaEntrega)
                    : false;

            @endphp


            @if(!$puedeEvaluar)

                <div class="alert alert-warning">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M12 7v5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <circle
                            cx="12"
                            cy="16"
                            r="1"
                            fill="currentColor"
                        />

                    </svg>

                    <span>
                        La calificación estará disponible después de la fecha de entrega.
                    </span>

                </div>

            @else

                @if($calificacion)

                    <div class="grade-display">

                        <strong>
                            {{ number_format((float) $calificacion->calificacion, 1) }}
                        </strong>

                        <span>
                            / 10
                        </span>

                    </div>


                    <div class="info-grid">

                        <div class="info-item">

                            <span class="info-label">
                                Estado
                            </span>

                            <strong>

                                @if($calificacion->estado === 'publicada')

                                    Publicada

                                @else

                                    Borrador

                                @endif

                            </strong>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Fecha de evaluación
                            </span>

                            <strong>

                                {{ $calificacion->updated_at
                                    ? $calificacion->updated_at->format('d/m/Y H:i')
                                    : 'Sin fecha'
                                }}

                            </strong>

                        </div>

                    </div>


                    <div class="page-header-actions">

                        <a
                            href="{{ route('tareas.evaluar', [
                                'tarea' => $tarea->id,
                                'alumno' => $alumno->id
                            ]) }}"
                            class="btn btn-primary"
                        >

                            Editar evaluación

                        </a>

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-state-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    d="M5 4h14v16H5z"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M8 9h8M8 13h5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <h3>
                            Evidencia pendiente de evaluación
                        </h3>

                        <p>
                            La evidencia ya fue entregada y puede ser calificada.
                        </p>


                        <div class="page-header-actions">

                            <a
                                href="{{ route('tareas.evaluar', [
                                    'tarea' => $tarea->id,
                                    'alumno' => $alumno->id
                                ]) }}"
                                class="btn btn-primary"
                            >

                                Evaluar evidencia

                            </a>

                        </div>

                    </div>

                @endif

            @endif

        </div>

    @endif

</div>

@endsection