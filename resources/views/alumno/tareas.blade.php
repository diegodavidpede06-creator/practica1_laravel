@extends('layouts.app')

@section('title', 'Mis tareas')

@section('content')

<div class="page-header">

    <div>
        <h1>Mis tareas</h1>

        <p>
            Consulta tus tareas y entrega tus evidencias.
        </p>
    </div>

</div>


@if(session('success'))
    <div class="alert alert-success" data-auto-dismiss>
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M5 12l4 4L19 6"/>
        </svg>

        <span>{{ session('success') }}</span>
    </div>
@endif


<div class="filter-bar">

    <div class="filter-group">

        <label for="filtro-tipo">
            Tipo
        </label>

        <select id="filtro-tipo">
            <option value="">Todos</option>
            <option value="casa">Tareas en casa</option>
            <option value="clase">Actividades en clase</option>
            <option value="exposicion">Exposiciones</option>
        </select>

    </div>


    <div class="filter-group">

        <label for="filtro-estado">
            Estado
        </label>

        <select id="filtro-estado">
            <option value="">Todos</option>
            <option value="pendiente">Pendientes</option>
            <option value="entregada">Entregadas</option>
            <option value="calificada">Calificadas</option>
        </select>

    </div>

</div>


<div class="card">

    @if($tareas->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Tarea</th>
                        <th>Tipo</th>
                        <th>Entrega</th>
                        <th>Estado</th>
                        <th>Calificación</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($tareas as $tarea)

                        @php
                            $entrega = $tarea->entrega ?? null;
                            $calificacion = $entrega?->calificacion ?? null;
                        @endphp

                        <tr>

                            <td>

                                <div class="table-primary">
                                    {{ $tarea->titulo }}
                                </div>

                                <div class="table-secondary">
                                    {{ Str::limit($tarea->descripcion, 70) }}
                                </div>

                            </td>


                            <td>

                                @switch($tarea->tipo)

                                    @case('casa')
                                        <span class="badge badge-info">
                                            Casa
                                        </span>
                                        @break

                                    @case('clase')
                                        <span class="badge badge-neutral">
                                            Clase
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

                                <div>
                                    {{ $tarea->fecha_entrega->format('d/m/Y') }}
                                </div>

                                <div class="table-secondary">
                                    {{ $tarea->fecha_entrega->format('H:i') }}
                                </div>

                            </td>


                            <td>

                                @if($tarea->cancelada)

                                    <span class="badge badge-danger">
                                        Cancelada
                                    </span>

                                @elseif($calificacion && $calificacion->estado === 'publicada')

                                    <span class="badge badge-success">
                                        Calificada
                                    </span>

                                @elseif($entrega)

                                    <span class="badge badge-info">
                                        Entregada
                                    </span>

                                @elseif($tarea->fecha_entrega->isPast())

                                    <span class="badge badge-danger">
                                        No entregada
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Pendiente
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($calificacion && $calificacion->estado === 'publicada')

                                    <strong class="grade-value">
                                        {{ number_format($calificacion->calificacion, 1) }}
                                    </strong>

                                    <span class="table-secondary">
                                        / 10
                                    </span>

                                @else

                                    <span class="table-secondary">
                                        —
                                    </span>

                                @endif

                            </td>


                            <td class="table-actions">

                                <a
                                    href="{{ route('alumno.tarea', $tarea) }}"
                                    class="btn btn-sm btn-secondary"
                                >
                                    Ver tarea
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        @if(method_exists($tareas, 'links'))

            <div class="pagination-wrapper">
                {{ $tareas->links() }}
            </div>

        @endif

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

            <h3>No hay tareas</h3>

            <p>
                Cuando el docente publique tareas aparecerán aquí.
            </p>

        </div>

    @endif

</div>

@endsection