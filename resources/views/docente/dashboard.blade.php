@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Inicio</span>
        </div>

        <h2 class="page-title">
            Dashboard
        </h2>

        <p class="page-description">
            Consulta rápidamente el estado de tus alumnos, tareas y calificaciones.
        </p>

    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('tareas.create') }}"
            class="btn btn-primary"
        >

            <svg
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    d="M12 5v14M5 12h14"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>

            <span>
                Nueva tarea
            </span>

        </a>

    </div>

</div>


{{-- ==========================================================
    ESTADÍSTICAS
=========================================================== --}}

<div class="stats-grid">

    {{-- Alumnos --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-purple">

            <svg
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
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

                <path
                    d="M15 6a3 3 0 0 1 0 5.8M16 15c2.5.5 3.9 2.1 4.5 4.5"
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
                {{ $estadisticas['alumnos'] ?? 0 }}
            </strong>

            <span class="stat-description">
                Alumnos registrados
            </span>

        </div>

    </div>


    {{-- Tareas activas --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-blue">

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
                    d="M14 3v5h5M8 12h8M8 16h6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Tareas activas
            </span>

            <strong class="stat-value">
                {{ $estadisticas['tareas_activas'] ?? 0 }}
            </strong>

            <span class="stat-description">
                Tareas disponibles
            </span>

        </div>

    </div>


    {{-- Entregas --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-orange">

            <svg
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    d="M5 4h14v16H5z"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linejoin="round"
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
                Entregas
            </span>

            <strong class="stat-value">
                {{ $estadisticas['entregas'] ?? 0 }}
            </strong>

            <span class="stat-description">
                Evidencias recibidas
            </span>

        </div>

    </div>


    {{-- Pendientes --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-red">

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
                    d="M12 7v5l3 2"
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
                Pendientes
            </span>

            <strong class="stat-value">
                {{ $estadisticas['pendientes'] ?? 0 }}
            </strong>

            <span class="stat-description">
                Entregas pendientes
            </span>

        </div>

    </div>

</div>


{{-- ==========================================================
    CONTENIDO PRINCIPAL
=========================================================== --}}

<div class="dashboard-grid">

    {{-- Tareas recientes --}}
    <section class="card dashboard-card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Tareas recientes
                </h3>

                <p class="card-subtitle">
                    Últimas tareas creadas
                </p>

            </div>

            <a
                href="{{ route('tareas.index') }}"
                class="btn btn-ghost btn-sm"
            >
                Ver todas
            </a>

        </div>


        <div class="card-body no-padding">

            @if(isset($tareasRecientes) && $tareasRecientes->count())

                <div class="table-wrapper">

                    <table class="data-table">

                        <thead>

                            <tr>
                                <th>Tarea</th>
                                <th>Tipo</th>
                                <th>Fecha límite</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($tareasRecientes as $tarea)

                                <tr>

                                    <td>

                                        <div class="table-primary">

                                            <strong>
                                                {{ $tarea->titulo }}
                                            </strong>

                                            @if($tarea->descripcion)

                                                <span>
                                                    {{ \Illuminate\Support\Str::limit($tarea->descripcion, 60) }}
                                                </span>

                                            @endif

                                        </div>

                                    </td>


                                    <td>

                                        @php

                                            $tipoTexto = match($tarea->tipo) {

                                                'casa' => 'Tarea en casa',

                                                'clase' => 'Actividad en clase',

                                                'exposicion' => 'Exposición',

                                                default => ucfirst($tarea->tipo),

                                            };

                                        @endphp

                                        <span class="badge badge-neutral">
                                            {{ $tipoTexto }}
                                        </span>

                                    </td>


                                    <td>

                                        {{ $tarea->fecha_entrega
                                            ? \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i')
                                            : 'Sin fecha'
                                        }}

                                    </td>


                                    <td>

                                        @if($tarea->cancelada)

                                            <span class="badge badge-danger">
                                                Cancelada
                                            </span>

                                        @elseif(
                                            $tarea->fecha_entrega &&
                                            \Carbon\Carbon::parse($tarea->fecha_entrega)->isPast()
                                        )

                                            <span class="badge badge-warning">
                                                Finalizada
                                            </span>

                                        @else

                                            <span class="badge badge-success">
                                                Activa
                                            </span>

                                        @endif

                                    </td>


                                    <td class="table-actions">

                                        <a
                                            href="{{ route('tareas.show', $tarea) }}"
                                            class="icon-button icon-button-sm"
                                            title="Ver tarea"
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

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <div class="empty-state-icon">

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

                        </svg>

                    </div>

                    <h4>
                        No hay tareas todavía
                    </h4>

                    <p>
                        Crea tu primera tarea para comenzar.
                    </p>

                    <a
                        href="{{ route('tareas.create') }}"
                        class="btn btn-primary"
                    >
                        Crear tarea
                    </a>

                </div>

            @endif

        </div>

    </section>


    {{-- Resumen de entregas --}}
    <section class="card dashboard-card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Estado de entregas
                </h3>

                <p class="card-subtitle">
                    Resumen de la actividad reciente
                </p>

            </div>

            <a
                href="{{ route('tareas.index') }}"
                class="btn btn-ghost btn-sm"
            >
                Calificaciones
            </a>

        </div>


        <div class="card-body">

            <div class="progress-summary">

                <div class="progress-summary-header">

                    <span>
                        Entregas recibidas
                    </span>

                    <strong>
                        {{ $estadisticas['entregas'] ?? 0 }}
                    </strong>

                </div>


                <div class="progress-bar">

                    @php

                        $totalEsperado = max(
                            1,
                            $estadisticas['entregas_esperadas'] ?? 0
                        );

                        $entregas = $estadisticas['entregas'] ?? 0;

                        $porcentajeEntregas = min(
                            100,
                            round(($entregas / $totalEsperado) * 100)
                        );

                    @endphp

                    <div
                        class="progress-bar-fill"
                        style="width: {{ $porcentajeEntregas }}%"
                    ></div>

                </div>

                <span class="progress-description">
                    {{ $porcentajeEntregas }}% del total esperado
                </span>

            </div>


            <div class="dashboard-summary-list">

                <div class="summary-item">

                    <span class="summary-item-label">

                        <span class="status-dot status-dot-success"></span>

                        Entregadas

                    </span>

                    <strong>
                        {{ $estadisticas['entregas'] ?? 0 }}
                    </strong>

                </div>


                <div class="summary-item">

                    <span class="summary-item-label">

                        <span class="status-dot status-dot-warning"></span>

                        Pendientes

                    </span>

                    <strong>
                        {{ $estadisticas['pendientes'] ?? 0 }}
                    </strong>

                </div>


                <div class="summary-item">

                    <span class="summary-item-label">

                        <span class="status-dot status-dot-danger"></span>

                        Sin calificar

                    </span>

                    <strong>
                        {{ $estadisticas['sin_calificar'] ?? 0 }}
                    </strong>

                </div>

            </div>

        </div>

    </section>

</div>


{{-- ==========================================================
    ACCIONES RÁPIDAS
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h3 class="card-title">
                Acciones rápidas
            </h3>

            <p class="card-subtitle">
                Administra los elementos principales del sistema.
            </p>

        </div>

    </div>


    <div class="quick-actions">


        <a
            href="{{ route('docente.alumnos.create') }}"
            class="quick-action"
        >

            <span class="quick-action-icon">

                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >

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

                    <path
                        d="M17 8v6M14 11h6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                </svg>

            </span>


            <span class="quick-action-content">

                <strong>
                    Agregar alumno
                </strong>

                <small>
                    Registrar un nuevo alumno
                </small>

            </span>


            <svg
                class="quick-action-arrow"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >

                <path
                    d="M5 12h13M13 6l6 6-6 6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>

        </a>


        <a
            href="{{ route('tareas.create') }}"
            class="quick-action"
        >

            <span class="quick-action-icon">

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
                        d="M14 3v5h5M12 11v6M9 14h6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                </svg>

            </span>


            <span class="quick-action-content">

                <strong>
                    Crear tarea
                </strong>

                <small>
                    Publicar una nueva actividad
                </small>

            </span>


            <svg
                class="quick-action-arrow"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >

                <path
                    d="M5 12h13M13 6l6 6-6 6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>

        </a>


        <a
            href="{{ route('tareas.index') }}"
            class="quick-action"
        >

            <span class="quick-action-icon">

                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >

                    <path
                        d="M4 19V5M4 19h17"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <path
                        d="m7 15 4-4 3 2 5-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </span>


            <span class="quick-action-content">

                <strong>
                    Revisar calificaciones
                </strong>

                <small>
                    Consulta las tareas y registra calificaciones
                </small>

            </span>


            <svg
                class="quick-action-arrow"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >

                <path
                    d="M5 12h13M13 6l6 6-6 6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>

        </a>

    </div>

</section>

@endsection