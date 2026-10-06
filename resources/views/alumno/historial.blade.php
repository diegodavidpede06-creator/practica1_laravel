@extends('layouts.app')

@section('title', 'Historial')

@section('content')

<div class="page-header">

    <div>

        <h1>Mi historial</h1>

        <p>
            Consulta tus entregas y calificaciones publicadas.
        </p>

    </div>

</div>


<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 12l4 4L19 6"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">
                Tareas calificadas
            </span>

            <strong class="stat-value">
                {{ $estadisticas['calificadas'] ?? 0 }}
            </strong>
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9z"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">
                Promedio
            </span>

            <strong class="stat-value">
                @if(isset($estadisticas['promedio']))
                    {{ number_format($estadisticas['promedio'], 1) }}
                @else
                    --
                @endif
            </strong>
        </div>

    </div>

</div>


<div class="card">

    <div class="card-header">

        <div>

            <h2>Calificaciones publicadas</h2>

            <p>
                Aquí aparecen únicamente las calificaciones
                que el docente ya publicó.
            </p>

        </div>

    </div>


    @if($calificaciones->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>
                        <th>Tarea</th>
                        <th>Tipo</th>
                        <th>Entrega</th>
                        <th>Calificación</th>
                        <th></th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($calificaciones as $calificacion)

                        <tr>

                            <td>

                                <div class="table-primary">
                                    {{ $calificacion->tarea->titulo }}
                                </div>

                                <div class="table-secondary">

                                    Publicada
                                    {{ $calificacion->updated_at->format('d/m/Y H:i') }}

                                </div>

                            </td>


                            <td>

                                @switch($calificacion->tarea->tipo)

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

                                @endswitch

                            </td>


                            <td>

                                @if($calificacion->tarea->entrega)

                                    {{ $calificacion->tarea->entrega->created_at->format('d/m/Y H:i') }}

                                @else

                                    —

                                @endif

                            </td>


                            <td>

                                <div class="grade-table-value">

                                    <strong>
                                        {{ number_format($calificacion->calificacion, 1) }}
                                    </strong>

                                    <span>
                                        / 10
                                    </span>

                                </div>

                            </td>


                            <td class="table-actions">

                                <a
                                    href="{{ route('alumno.tarea', $calificacion->tarea) }}"
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


        @if(method_exists($calificaciones, 'links'))

            <div class="pagination-wrapper">
                {{ $calificaciones->links() }}
            </div>

        @endif


    @else

        <div class="empty-state">

            <div class="empty-state-icon">

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9z"/>
                </svg>

            </div>

            <h3>Aún no tienes calificaciones</h3>

            <p>
                Cuando el docente publique una calificación,
                aparecerá en este apartado.
            </p>

        </div>

    @endif

</div>

@endsection