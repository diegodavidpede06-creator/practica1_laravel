@extends('layouts.app')

@section('content')

@php
    $tipoTexto = match($tarea->tipo) {
        'casa' => 'Tarea en casa',
        'clase' => 'Actividad en clase',
        'exposicion' => 'Exposición',
        default => ucfirst($tarea->tipo),
    };

    $fechaLimite = $tarea->fecha_entrega
        ? \Carbon\Carbon::parse($tarea->fecha_entrega)
        : null;

    $finalizada = $fechaLimite && $fechaLimite->isPast();

    $entregas = $tarea->entregas ?? collect();

    $entregados = $entregas->count();

    $totalAlumnos = $totalAlumnos ?? 0;

    $pendientes = max(
        0,
        $totalAlumnos - $entregados
    );

    $porcentaje = $totalAlumnos > 0
        ? round(($entregados / $totalAlumnos) * 100)
        : 0;
@endphp


<div class="page-header">

    <div>

        <div class="breadcrumb">

            <a href="{{ route('docente.tareas.index') }}">
                Tareas
            </a>

            <span>/</span>

            <span>Detalle</span>

        </div>

        <div class="page-title-row">

            <h2 class="page-title">
                {{ $tarea->titulo }}
            </h2>

            @if($tarea->cancelada)

                <span class="badge badge-danger">
                    Cancelada
                </span>

            @elseif($finalizada)

                <span class="badge badge-warning">
                    Finalizada
                </span>

            @else

                <span class="badge badge-success">
                    Activa
                </span>

            @endif

        </div>

        <p class="page-description">
            {{ $tipoTexto }}
        </p>

    </div>


    <div class="page-header-actions">

        @if(!$tarea->cancelada)

            <button
                type="button"
                class="btn btn-danger"
                data-cancel-task
                data-task-name="{{ $tarea->titulo }}"
                data-cancel-url="{{ route('docente.tareas.cancelar', $tarea) }}"
            >

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    />

                    <path
                        d="M8 8l8 8M16 8l-8 8"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

                Cancelar tarea

            </button>

        @endif

    </div>

</div>


{{-- ==========================================================
    INFORMACIÓN DE LA TAREA
=========================================================== --}}

<div class="task-detail-grid">

    <section class="card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Información
                </h3>

                <p class="card-subtitle">
                    Datos de la actividad asignada.
                </p>

            </div>

        </div>


        <div class="card-body">

            <div class="task-description">

                {!! nl2br(e($tarea->descripcion)) !!}

            </div>


            <div class="info-grid">

                <div class="info-item">

                    <span class="info-label">
                        Tipo
                    </span>

                    <strong>
                        {{ $tipoTexto }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Fecha de creación
                    </span>

                    <strong>
                        {{ optional($tarea->created_at)->format('d/m/Y H:i') }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Fecha límite
                    </span>

                    <strong>
                        {{ $fechaLimite
                            ? $fechaLimite->format('d/m/Y H:i')
                            : 'Sin fecha' }}
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Estado
                    </span>

                    <strong>

                        @if($tarea->cancelada)
                            Cancelada
                        @elseif($finalizada)
                            Finalizada
                        @else
                            Activa
                        @endif

                    </strong>

                </div>

            </div>

        </div>

    </section>


    {{-- Resumen --}}
    <section class="card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Entregas
                </h3>

                <p class="card-subtitle">
                    Estado general del grupo.
                </p>

            </div>

        </div>


        <div class="card-body">

            <div class="task-progress">

                <div class="task-progress-header">

                    <strong>
                        {{ $entregados }} de {{ $totalAlumnos }}
                    </strong>

                    <span>
                        {{ $porcentaje }}%
                    </span>

                </div>


                <div class="progress-bar">

                    <div
                        class="progress-bar-fill"
                        style="width: {{ $porcentaje }}%"
                    ></div>

                </div>

            </div>


            <div class="dashboard-summary-list">

                <div class="summary-item">

                    <span class="summary-item-label">

                        <span class="status-dot status-dot-success"></span>

                        Entregadas

                    </span>

                    <strong>
                        {{ $entregados }}
                    </strong>

                </div>


                <div class="summary-item">

                    <span class="summary-item-label">

                        <span class="status-dot status-dot-warning"></span>

                        Pendientes

                    </span>

                    <strong>
                        {{ $pendientes }}
                    </strong>

                </div>

            </div>

        </div>

    </section>

</div>


{{-- ==========================================================
    LISTADO DE ALUMNOS
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h3 class="card-title">
                Entregas de alumnos
            </h3>

            <p class="card-subtitle">
                Revisa las evidencias recibidas y pendientes.
            </p>

        </div>

    </div>


    <div class="card-body no-padding">

        @if(isset($alumnos) && $alumnos->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Alumno</th>
                            <th>Estado</th>
                            <th>Entrega</th>
                            <th>Calificación</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($alumnos as $alumno)

                            @php
                                $entrega = $entregas->firstWhere(
                                    'alumno_id',
                                    $alumno->id
                                );
                            @endphp

                            <tr>

                                <td>

                                    <div class="table-user">

                                        <div class="avatar avatar-sm">
                                            {{ strtoupper(substr($alumno->nombre, 0, 1)) }}
                                        </div>

                                        <div class="table-primary">

                                            <strong>
                                                {{ $alumno->nombre }}
                                            </strong>

                                            <span>
                                                {{ $alumno->matricula ?: $alumno->usuario }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    @if($entrega)

                                        <span class="badge badge-success">
                                            Entregada
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Pendiente
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    @if($entrega)

                                        <div class="table-primary">

                                            <strong>
                                                {{ optional($entrega->created_at)->format('d/m/Y') }}
                                            </strong>

                                            <span>
                                                {{ optional($entrega->created_at)->format('H:i') }} h
                                            </span>

                                        </div>

                                    @else
                                        —
                                    @endif

                                </td>


                                <td>

                                    @if($entrega && $entrega->calificacion)

                                        <span class="grade-badge">
                                            {{ number_format($entrega->calificacion->calificacion, 1) }}
                                        </span>

                                    @elseif($entrega)

                                        <span class="badge badge-neutral">
                                            Sin calificar
                                        </span>

                                    @else
                                        —
                                    @endif

                                </td>


                                <td class="table-actions">

                                    @if($entrega)

                                        <a
                                            href="{{ route('docente.tareas.entrega', [$tarea, $alumno]) }}"
                                            class="btn btn-secondary btn-sm"
                                        >

                                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                                <path
                                                    d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                />
                                            </svg>

                                            Revisar

                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-state-icon">

                    <svg viewBox="0 0 24 24" aria-hidden="true">
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
                    </svg>

                </div>

                <h4>
                    Todavía no hay información de entregas
                </h4>

                <p>
                    Las evidencias aparecerán aquí cuando los alumnos las envíen.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- ==========================================================
    FORMULARIO OCULTO PARA CANCELAR
=========================================================== --}}

<form
    id="cancel-task-form"
    method="POST"
    style="display:none;"
>
    @csrf
    @method('PATCH')
</form>

@endsection