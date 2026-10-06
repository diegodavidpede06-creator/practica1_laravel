@extends('layouts.app')

@section('title', 'Tareas')

@section('content')

<div class="page-header">

    <div class="page-header-content">

        <div class="breadcrumb">
            Gestión / Tareas
        </div>

        <h1 class="page-title">
            Tareas
        </h1>

        <p class="page-subtitle">
            Administra las tareas y consulta el estado de las entregas de tus alumnos.
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

            Nueva tarea
        </a>

    </div>

</div>


{{-- ==========================================================
     MENSAJES
=========================================================== --}}

@if(session('success'))

    <div class="alert alert-success">

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
                d="m8 12 2.5 2.5L16 9"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
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
                d="M12 8v5"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
            />

            <circle
                cx="12"
                cy="16.5"
                r="1"
                fill="currentColor"
            />
        </svg>

        <span>
            {{ session('error') }}
        </span>

    </div>

@endif


{{-- ==========================================================
     ESTADÍSTICAS
=========================================================== --}}

<div class="stats-grid">

    {{-- Total --}}

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
                Total de tareas
            </span>

            <strong class="stat-value">
                {{ $total ?? $tareas->count() }}
            </strong>

            <span class="stat-description">
                Tareas registradas
            </span>

        </div>

    </div>


    {{-- Activas --}}

    <div class="stat-card">

        <div class="stat-card-icon stat-icon-green">

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
                Activas
            </span>

            <strong class="stat-value">
                {{ $activas ?? 0 }}
            </strong>

            <span class="stat-description">
                Tareas disponibles
            </span>

        </div>

    </div>


    {{-- Finalizadas --}}

    <div class="stat-card">

        <div class="stat-card-icon stat-icon-orange">

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
                Finalizadas
            </span>

            <strong class="stat-value">
                {{ $finalizadas ?? 0 }}
            </strong>

            <span class="stat-description">
                Fuera de plazo
            </span>

        </div>

    </div>


    {{-- Canceladas --}}

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
                    d="m9 9 6 6M15 9l-6 6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Canceladas
            </span>

            <strong class="stat-value">
                {{ $canceladas ?? 0 }}
            </strong>

            <span class="stat-description">
                Tareas canceladas
            </span>

        </div>

    </div>

</div>


{{-- ==========================================================
     LISTADO DE TAREAS
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Listado de tareas
            </h2>

            <p class="card-subtitle">
                Consulta las tareas creadas y su fecha límite.
            </p>

        </div>

        <a
            href="{{ route('tareas.canceladas') }}"
            class="btn btn-ghost btn-sm"
        >
            Ver canceladas
        </a>

    </div>


    <div class="card-body no-padding">

        @if($tareas->count() > 0)

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>
                                Tarea
                            </th>

                            <th>
                                Tipo
                            </th>

                            <th>
                                Fecha límite
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($tareas as $tarea)

                            <tr>

                                {{-- Tarea --}}

                                <td>

                                    <div class="table-primary">

                                        <strong>
                                            {{ $tarea->titulo }}
                                        </strong>

                                        @if($tarea->descripcion)

                                            <span>
                                                {{ \Illuminate\Support\Str::limit($tarea->descripcion, 70) }}
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- Tipo --}}

                                <td>

                                    @php

                                        $tipoTexto = match($tarea->tipo) {

                                            'casa' =>
                                                'Tarea en casa',

                                            'clase' =>
                                                'Actividad en clase',

                                            'exposicion' =>
                                                'Exposición',

                                            default =>
                                                ucfirst($tarea->tipo),

                                        };

                                    @endphp

                                    <span class="badge badge-neutral">

                                        {{ $tipoTexto }}

                                    </span>

                                </td>


                                {{-- Fecha --}}

                                <td>

                                    @if($tarea->fecha_entrega)

                                        {{ \Carbon\Carbon::parse($tarea->fecha_entrega)->format('d/m/Y H:i') }}

                                    @else

                                        Sin fecha

                                    @endif

                                </td>


                                {{-- Estado --}}

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


                                {{-- Acción --}}

                                <td class="table-actions">

                                    <a
                                        href="{{ route('tareas.show', $tarea) }}"
                                        class="icon-button icon-button-sm"
                                        title="Ver tarea"
                                        aria-label="Ver tarea"
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

            {{-- ==================================================
                 SIN TAREAS
            =================================================== --}}

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

                    Nueva tarea

                </a>

            </div>

        @endif

    </div>

</section>

@endsection