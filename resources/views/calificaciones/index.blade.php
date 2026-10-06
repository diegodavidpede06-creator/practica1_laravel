@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Gestión</span>
            <span>/</span>
            <span>Calificaciones</span>
        </div>

        <h1 class="page-title">
            Calificaciones
        </h1>

        <p class="page-description">
            Consulta y administra las calificaciones de los alumnos.
        </p>

    </div>

</div>


{{-- ==========================================================
    ESTADÍSTICAS
=========================================================== --}}

<div class="stats-grid">

    {{-- Total --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-purple">

            <svg viewBox="0 0 24 24" aria-hidden="true">

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
                Total
            </span>

            <strong class="stat-value">
                {{ $total }}
            </strong>

            <span class="stat-description">
                Calificaciones registradas
            </span>

        </div>

    </div>


    {{-- Publicadas --}}
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
                Publicadas
            </span>

            <strong class="stat-value">
                {{ $publicadas }}
            </strong>

            <span class="stat-description">
                Visibles para alumnos
            </span>

        </div>

    </div>


    {{-- Borradores --}}
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
                Borradores
            </span>

            <strong class="stat-value">
                {{ $borradores }}
            </strong>

            <span class="stat-description">
                Pendientes de publicar
            </span>

        </div>

    </div>


    {{-- Promedio --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-blue">

            <svg viewBox="0 0 24 24" aria-hidden="true">

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

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Promedio
            </span>

            <strong class="stat-value">

                {{ $promedio !== null
                    ? number_format($promedio, 1)
                    : '—'
                }}

            </strong>

            <span class="stat-description">
                Sobre calificaciones publicadas
            </span>

        </div>

    </div>

</div>


{{-- ==========================================================
    FILTROS
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Buscar calificaciones
            </h2>

            <p class="card-subtitle">
                Filtra por alumno, tarea o estado.
            </p>

        </div>

    </div>


    <div class="card-body">

        <form
            method="GET"
            action="{{ route('docente.calificaciones.index') }}"
        >

            <div class="form-grid">

                {{-- Buscar --}}
                <div class="form-group form-group-full">

                    <label for="buscar">
                        Buscar
                    </label>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Nombre del alumno, usuario o tarea..."
                    >

                </div>


                {{-- Alumno --}}
                <div class="form-group">

                    <label for="alumno_id">
                        Alumno
                    </label>

                    <select
                        id="alumno_id"
                        name="alumno_id"
                    >

                        <option value="">
                            Todos los alumnos
                        </option>

                        @foreach($alumnos as $alumno)

                            <option
                                value="{{ $alumno->id }}"
                                @selected((string) request('alumno_id') === (string) $alumno->id)
                            >
                                {{ $alumno->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Tarea --}}
                <div class="form-group">

                    <label for="tarea_id">
                        Tarea
                    </label>

                    <select
                        id="tarea_id"
                        name="tarea_id"
                    >

                        <option value="">
                            Todas las tareas
                        </option>

                        @foreach($tareas as $tarea)

                            <option
                                value="{{ $tarea->id }}"
                                @selected((string) request('tarea_id') === (string) $tarea->id)
                            >
                                {{ $tarea->titulo }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Estado --}}
                <div class="form-group">

                    <label for="estado">
                        Estado
                    </label>

                    <select
                        id="estado"
                        name="estado"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option
                            value="publicada"
                            @selected(request('estado') === 'publicada')
                        >
                            Publicadas
                        </option>

                        <option
                            value="borrador"
                            @selected(request('estado') === 'borrador')
                        >
                            Borradores
                        </option>

                    </select>

                </div>


                {{-- Botones --}}
                <div class="form-group">

                    <label>
                        &nbsp;
                    </label>

                    <div class="table-actions">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <svg viewBox="0 0 24 24" aria-hidden="true">

                                <circle
                                    cx="11"
                                    cy="11"
                                    r="7"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="m16 16 5 5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                            Filtrar

                        </button>


                        <a
                            href="{{ route('docente.calificaciones.index') }}"
                            class="btn btn-ghost"
                        >
                            Limpiar
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</section>


{{-- ==========================================================
    TABLA
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Registro de calificaciones
            </h2>

            <p class="card-subtitle">
                Calificaciones guardadas y publicadas.
            </p>

        </div>

    </div>


    <div class="card-body no-padding">

        @if($calificaciones->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>Alumno</th>

                            <th>Tarea</th>

                            <th>Tipo</th>

                            <th>Calificación</th>

                            <th>Estado</th>

                            <th>Actualizada</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($calificaciones as $calificacion)

                            @php

                                $tipoTexto = match($calificacion->tarea_tipo) {
                                    'casa' => 'Tarea en casa',
                                    'clase' => 'Actividad en clase',
                                    'exposicion' => 'Exposición',
                                    default => ucfirst($calificacion->tarea_tipo),
                                };

                            @endphp

                            <tr>

                                {{-- Alumno --}}
                                <td>

                                    <div class="table-primary">

                                        <strong>
                                            {{ $calificacion->alumno_nombre }}
                                        </strong>

                                        <span>
                                            {{ $calificacion->alumno_usuario }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Tarea --}}
                                <td>

                                    <div class="table-primary">

                                        <strong>
                                            {{ $calificacion->tarea_titulo }}
                                        </strong>

                                    </div>

                                </td>


                                {{-- Tipo --}}
                                <td>

                                    <span class="badge badge-neutral">
                                        {{ $tipoTexto }}
                                    </span>

                                </td>


                                {{-- Calificación --}}
                                <td>

                                    <span class="grade-table-value">

                                        <strong>
                                            {{ number_format($calificacion->calificacion, 1) }}
                                        </strong>

                                        <span>
                                            / 10
                                        </span>

                                    </span>

                                </td>


                                {{-- Estado --}}
                                <td>

                                    @if($calificacion->estado === 'publicada')

                                        <span class="badge badge-success">
                                            Publicada
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Borrador
                                        </span>

                                    @endif

                                </td>


                                {{-- Fecha --}}
                                <td>

                                    {{ \Carbon\Carbon::parse(
                                        $calificacion->updated_at
                                    )->format('d/m/Y H:i') }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            @if($calificaciones->hasPages())

                <div class="pagination-wrapper">

                    {{ $calificaciones->links() }}

                </div>

            @endif

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
                            d="M14 3v5h5M8 12h8M8 16h6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>

                <h3>
                    No hay calificaciones todavía
                </h3>

                <p>
                    Las calificaciones aparecerán aquí cuando el docente evalúe las evidencias.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection