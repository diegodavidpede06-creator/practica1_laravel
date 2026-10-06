@extends('layouts.app')

@section('content')

@php
    $tipoTexto = match($tarea->tipo) {
        'casa' => 'Tarea en casa',
        'clase' => 'Actividad en clase',
        'exposicion' => 'Exposición',
        default => ucfirst($tarea->tipo),
    };

    $fechaEntrega = $tarea->fecha_entrega
        ? \Carbon\Carbon::parse($tarea->fecha_entrega)
        : null;

    $finalizada = $fechaEntrega && $fechaEntrega->isPast();

    $puedeCancelar = !$tarea->cancelada && !$finalizada;
@endphp


<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Gestión</span>
            <span>/</span>
            <span>Tareas</span>
            <span>/</span>
            <span>Detalle</span>
        </div>

        <h1 class="page-title">
            {{ $tarea->titulo }}
        </h1>

        <p class="page-description">
            Consulta la información y el estado de entrega de esta tarea.
        </p>

    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('tareas.index') }}"
            class="btn btn-ghost"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path
                    d="M19 12H5M12 19l-7-7 7-7"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            Volver a tareas
        </a>

    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">

        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path
                d="m5 12 4 4L19 6"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger">

        <svg viewBox="0 0 24 24" aria-hidden="true">
            <circle
                cx="12"
                cy="12"
                r="9"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            />

            <path
                d="M9 9l6 6M15 9l-6 6"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />
        </svg>

        <span>
            {{ session('error') }}
        </span>

    </div>

@endif


<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Información de la tarea
            </h2>

            <p class="card-subtitle">
                Datos generales de la actividad.
            </p>

        </div>

        <div>

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

    </div>


    <div class="card-body">

        <div class="info-grid">

            <div class="info-item">

                <span class="info-label">
                    Tipo de tarea
                </span>

                <strong>
                    {{ $tipoTexto }}
                </strong>

            </div>


            <div class="info-item">

                <span class="info-label">
                    Fecha de entrega
                </span>

                <strong>

                    @if($fechaEntrega)
                        {{ $fechaEntrega->format('d/m/Y H:i') }}
                    @else
                        Sin fecha
                    @endif

                </strong>

            </div>

        </div>


        @if($tarea->descripcion)

            <div class="detail-section">

                <h3>
                    Descripción e instrucciones
                </h3>

                <div class="detail-content">
                    {!! nl2br(e($tarea->descripcion)) !!}
                </div>

            </div>

        @endif


        @if($puedeCancelar)

            <div class="form-footer">

                <form
                    method="POST"
                    action="{{ route('tareas.cancelar', $tarea) }}"
                    data-confirm-submit
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-danger"
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
                                d="M9 9l6 6M15 9l-6 6"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        Cancelar tarea

                    </button>

                </form>

            </div>

        @endif

    </div>

</section>


<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-card-icon stat-icon-purple">

            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle
                    cx="9"
                    cy="8"
                    r="3"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M3.5 20c.6-3.3 2.4-5 5.5-5s4.9 1.7 5.5 5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Alumnos
            </span>

            <strong class="stat-value">
                {{ $estadisticas['alumnos'] }}
            </strong>

            <span class="stat-description">
                Alumnos activos
            </span>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-card-icon stat-icon-green">

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
                    d="m8 12 2.5 2.5L16 9"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Entregadas
            </span>

            <strong class="stat-value">
                {{ $estadisticas['entregas'] }}
            </strong>

            <span class="stat-description">
                Evidencias recibidas
            </span>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-card-icon stat-icon-orange">

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
                    d="M12 7v5l3 2"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Pendientes
            </span>

            <strong class="stat-value">
                {{ $estadisticas['pendientes'] }}
            </strong>

            <span class="stat-description">
                Sin evidencia
            </span>

        </div>

    </div>


    <div class="stat-card">

        <div class="stat-card-icon stat-icon-blue">

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
                    d="m8 12 2.5 2.5L16 9"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Calificadas
            </span>

            <strong class="stat-value">
                {{ $estadisticas['calificadas'] }}
            </strong>

            <span class="stat-description">
                Evaluaciones realizadas
            </span>

        </div>

    </div>

</div>


<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Estado de entregas
            </h2>

            <p class="card-subtitle">
                Consulta quién entregó y quién está pendiente.
            </p>

        </div>

    </div>


    <div class="card-body no-padding">

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
                            $entrega = $entregasPorAlumno->get($alumno->id);
                        @endphp

                        <tr>

                            <td>

                                <div class="table-primary">

                                    <strong>
                                        {{ $alumno->nombre }}
                                    </strong>

                                    <span>
                                        {{ $alumno->usuario }}
                                    </span>

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
                                    {{ $entrega->created_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="table-secondary">
                                        Sin entrega
                                    </span>
                                @endif

                            </td>


                            <td>

                                @if($entrega && $entrega->calificacion)

                                    <span class="grade-table-value">

                                        <strong>
                                            {{ number_format($entrega->calificacion->calificacion, 1) }}
                                        </strong>

                                        <span>/ 10</span>

                                    </span>

                                    @if($entrega->calificacion->estado === 'publicada')

                                        <span class="badge badge-success">
                                            Publicada
                                        </span>

                                    @else

                                        <span class="badge badge-neutral">
                                            Borrador
                                        </span>

                                    @endif

                                @else

                                    <span class="table-secondary">
                                        Sin calificar
                                    </span>

                                @endif

                            </td>


                            <td>

                                <div class="table-actions">

                                    @if($entrega)

                                        <a
                                            href="{{ route('docente.evidencias.show', [$tarea, $alumno]) }}"
                                            class="icon-button"
                                            title="Ver evidencia"
                                        >

                                            <svg
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >

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

                                        </a>

                                    @endif

                                    @if($entrega && $finalizada && !$tarea->cancelada)

                                        <a
                                            href="{{ route('tareas.evaluar', [$tarea, $alumno]) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            Evaluar
                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</section>

@endsection