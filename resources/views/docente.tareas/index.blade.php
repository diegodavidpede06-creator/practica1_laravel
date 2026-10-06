@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Gestión</span>
            <span>/</span>
            <span>Tareas</span>
        </div>

        <h2 class="page-title">
            Tareas
        </h2>

        <p class="page-description">
            Administra las actividades asignadas a tus alumnos.
        </p>

    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('docente.tareas.create') }}"
            class="btn btn-primary"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
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
    FILTROS
=========================================================== --}}

<section class="card">

    <div class="card-body">

        <form
            action="{{ route('docente.tareas.index') }}"
            method="GET"
            class="filters"
        >

            <div class="filter-group filter-search">

                <label for="buscar">
                    Buscar
                </label>

                <div class="input-wrapper">

                    <span class="input-icon">

                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle
                                cx="10.5"
                                cy="10.5"
                                r="6"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="m15 15 5 5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                    </span>

                    <input
                        type="search"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar tarea..."
                    >

                </div>

            </div>


            <div class="filter-group">

                <label for="tipo">
                    Tipo
                </label>

                <select
                    id="tipo"
                    name="tipo"
                >

                    <option value="">
                        Todos
                    </option>

                    <option
                        value="casa"
                        @selected(request('tipo') === 'casa')
                    >
                        Tareas en casa
                    </option>

                    <option
                        value="clase"
                        @selected(request('tipo') === 'clase')
                    >
                        Actividades en clase
                    </option>

                    <option
                        value="exposicion"
                        @selected(request('tipo') === 'exposicion')
                    >
                        Exposiciones
                    </option>

                </select>

            </div>


            <div class="filter-group">

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
                        value="activa"
                        @selected(request('estado') === 'activa')
                    >
                        Activas
                    </option>

                    <option
                        value="finalizada"
                        @selected(request('estado') === 'finalizada')
                    >
                        Finalizadas
                    </option>

                    <option
                        value="cancelada"
                        @selected(request('estado') === 'cancelada')
                    >
                        Canceladas
                    </option>

                </select>

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-secondary"
                >
                    Filtrar
                </button>

                <a
                    href="{{ route('docente.tareas.index') }}"
                    class="btn btn-ghost"
                >
                    Limpiar
                </a>

            </div>

        </form>

    </div>

</section>


{{-- ==========================================================
    LISTADO
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h3 class="card-title">
                Todas las tareas
            </h3>

            <p class="card-subtitle">
                {{ $tareas->total() }} tareas registradas.
            </p>

        </div>

    </div>


    <div class="card-body no-padding">

        @if($tareas->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Tarea</th>
                            <th>Tipo</th>
                            <th>Fecha límite</th>
                            <th>Entregas</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($tareas as $tarea)

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

                            @endphp

                            <tr>

                                <td>

                                    <div class="table-primary">

                                        <strong>
                                            {{ $tarea->titulo }}
                                        </strong>

                                        @if($tarea->descripcion)

                                            <span>
                                                {{ \Illuminate\Support\Str::limit($tarea->descripcion, 80) }}
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                <td>

                                    <span class="badge badge-neutral">
                                        {{ $tipoTexto }}
                                    </span>

                                </td>


                                <td>

                                    @if($fechaLimite)

                                        <div class="table-primary">

                                            <strong>
                                                {{ $fechaLimite->format('d/m/Y') }}
                                            </strong>

                                            <span>
                                                {{ $fechaLimite->format('H:i') }} h
                                            </span>

                                        </div>

                                    @else
                                        —
                                    @endif

                                </td>


                                <td>

                                    <div class="delivery-summary">

                                        <span class="delivery-count">
                                            {{ $tarea->entregas_count ?? 0 }}
                                        </span>

                                        <span>
                                            de {{ $totalAlumnos ?? 0 }}
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    @if($tarea->cancelada)

                                        <span class="badge badge-danger">
                                            Cancelada
                                        </span>

                                    @elseif($fechaLimite && $fechaLimite->isPast())

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
                                        href="{{ route('docente.tareas.show', $tarea) }}"
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


            @if($tareas->hasPages())

                <div class="pagination-wrapper">
                    {{ $tareas->withQueryString()->links() }}
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
                            d="M14 3v5h5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />
                    </svg>

                </div>

                <h4>
                    No hay tareas registradas
                </h4>

                <p>
                    Crea una tarea para comenzar a recibir evidencias.
                </p>

                <a
                    href="{{ route('docente.tareas.create') }}"
                    class="btn btn-primary"
                >
                    Crear primera tarea
                </a>

            </div>

        @endif

    </div>

</section>

@endsection