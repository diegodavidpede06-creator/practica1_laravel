@extends('layouts.app')

@section('title', 'Mi dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1>Bienvenido, {{ $alumno->nombre }}</h1>

        <p>
            Consulta tus tareas, entregas y calificaciones.
        </p>
    </div>

    <a
        href="{{ route('alumno.tareas') }}"
        class="btn btn-primary"
    >
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M4 6h16"/>
            <path d="M4 12h16"/>
            <path d="M4 18h16"/>
        </svg>

        Ver mis tareas
    </a>
</div>


@if(session('success'))
    <div class="alert alert-success" data-auto-dismiss>
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M5 12l4 4L19 6"/>
        </svg>

        <span>{{ session('success') }}</span>
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger" data-auto-dismiss>
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 8v4"/>
            <path d="M12 16h.01"/>
            <circle cx="12" cy="12" r="9"/>
        </svg>

        <span>{{ session('error') }}</span>
    </div>
@endif


{{-- ESTADÍSTICAS --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                <path d="M8 7h8"/>
                <path d="M8 11h8"/>
                <path d="M8 15h5"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">Tareas activas</span>
            <strong class="stat-value">{{ $estadisticas['activas'] ?? 0 }}</strong>
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 12l4 4L19 6"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">Entregadas</span>
            <strong class="stat-value">{{ $estadisticas['entregadas'] ?? 0 }}</strong>
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">Pendientes</span>
            <strong class="stat-value">{{ $estadisticas['pendientes'] ?? 0 }}</strong>
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9z"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">Promedio</span>
            <strong class="stat-value">
                {{ isset($estadisticas['promedio']) ? number_format($estadisticas['promedio'], 1) : '--' }}
            </strong>
        </div>
    </div>

</div>


{{-- PRÓXIMAS TAREAS --}}
<div class="section-header">
    <div>
        <h2>Próximas tareas</h2>
        <p>Estas son las tareas que debes entregar próximamente.</p>
    </div>

    <a
        href="{{ route('alumno.tareas') }}"
        class="text-link"
    >
        Ver todas
    </a>
</div>


<div class="card">

    @if(isset($proximasTareas) && $proximasTareas->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Tarea</th>
                        <th>Tipo</th>
                        <th>Fecha de entrega</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($proximasTareas as $tarea)

                        <tr>

                            <td>
                                <div class="table-primary">
                                    {{ $tarea->titulo }}
                                </div>

                                <div class="table-secondary">
                                    {{ Str::limit($tarea->descripcion, 60) }}
                                </div>
                            </td>

                            <td>
                                @switch($tarea->tipo)

                                    @case('casa')
                                        <span class="badge badge-info">
                                            Tarea en casa
                                        </span>
                                        @break

                                    @case('clase')
                                        <span class="badge badge-neutral">
                                            Actividad en clase
                                        </span>
                                        @break

                                    @case('exposicion')
                                        <span class="badge badge-warning">
                                            Exposición
                                        </span>
                                        @break

                                    @default
                                        <span class="badge badge-neutral">
                                            {{ $tarea->tipo }}
                                        </span>

                                @endswitch
                            </td>

                            <td>
                                {{ $tarea->fecha_entrega->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                @if($tarea->entrega)

                                    <span class="badge badge-success">
                                        Entregada
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Pendiente
                                    </span>

                                @endif

                            </td>

                            <td class="table-actions">

                                <a
                                    href="{{ route('alumno.tarea', $tarea) }}"
                                    class="btn btn-sm btn-secondary"
                                >
                                    Ver
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
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
                    <path d="M8 7h8"/>
                    <path d="M8 11h8"/>
                    <path d="M8 15h5"/>
                </svg>
            </div>

            <h3>No tienes tareas pendientes</h3>

            <p>
                Cuando el docente publique una nueva tarea aparecerá aquí.
            </p>

        </div>

    @endif

</div>

@endsection