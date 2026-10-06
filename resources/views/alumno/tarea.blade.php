@extends('layouts.app')

@section('content')

@php
    $fechaEntrega = $tarea->fecha_entrega
        ? \Carbon\Carbon::parse($tarea->fecha_entrega)
        : null;

    $finalizada = $fechaEntrega && $fechaEntrega->isPast();

    $tipoTexto = match($tarea->tipo) {
        'casa' => 'Tarea en casa',
        'clase' => 'Actividad en clase',
        'exposicion' => 'Exposición',
        default => ucfirst($tarea->tipo),
    };
@endphp


<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Mis tareas</span>
            <span>/</span>
            <span>Detalle</span>
        </div>

        <h1 class="page-title">
            {{ $tarea->titulo }}
        </h1>

        <p class="page-description">
            Consulta las instrucciones y entrega tu evidencia.
        </p>

    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('alumno.tareas') }}"
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

            Volver a mis tareas
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


@if($errors->any())

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
                d="M12 8v5M12 16h.01"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />

        </svg>

        <div>

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    </div>

@endif


{{-- ==========================================================
    INFORMACIÓN DE LA TAREA
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Información de la tarea
            </h2>

            <p class="card-subtitle">
                Revisa las instrucciones antes de entregar tu evidencia.
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
                    Fecha límite
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

    </div>

</section>


{{-- ==========================================================
    EVIDENCIA
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Tu evidencia
            </h2>

            <p class="card-subtitle">
                Debes entregar un único archivo PDF.
            </p>

        </div>

    </div>


    <div class="card-body">

        @if($entrega)

            {{-- ==================================================
                YA ENTREGÓ
            =================================================== --}}

            <div class="alert alert-success">

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
                        d="m8 12 2.5 2.5L16 9"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

                <span>
                    Tu evidencia fue entregada correctamente.
                </span>

            </div>


            <div class="detail-section">

                <h3>
                    Evidencia entregada
                </h3>

                <div class="detail-content">

                    <div class="table-primary">

                        <strong>
                            {{ basename($entrega->archivo) }}
                        </strong>

                        <span>
                            Entregada el
                            {{ $entrega->created_at->format('d/m/Y H:i') }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                CALIFICACIÓN
            =================================================== --}}

            @if($calificacion && $calificacion->estado === 'publicada')

                <div class="detail-section">

                    <h3>
                        Calificación
                    </h3>

                    <div class="grade-table-value">

                        <strong>
                            {{ number_format($calificacion->calificacion, 1) }}
                        </strong>

                        <span>
                            / 10
                        </span>

                    </div>


                    @if($calificacion->observaciones)

                        <div class="detail-content">

                            <strong>
                                Observaciones
                            </strong>

                            <p>
                                {{ $calificacion->observaciones }}
                            </p>

                        </div>

                    @endif

                </div>

            @elseif($calificacion)

                <div class="alert alert-warning">

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
                            d="M12 7v5l3 2"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />

                    </svg>

                    <span>
                        Tu calificación todavía no ha sido publicada.
                    </span>

                </div>

            @endif


        @elseif($tarea->cancelada)

            {{-- ==================================================
                TAREA CANCELADA
            =================================================== --}}

            <div class="empty-state">

                <div class="empty-state-icon">

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

                </div>

                <h3>
                    Tarea cancelada
                </h3>

                <p>
                    Esta tarea ya no acepta entregas.
                </p>

            </div>


        @elseif($finalizada)

            {{-- ==================================================
                FECHA VENCIDA
            =================================================== --}}

            <div class="empty-state">

                <div class="empty-state-icon">

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

                <h3>
                    Fecha de entrega vencida
                </h3>

                <p>
                    Ya no es posible entregar evidencia para esta tarea.
                </p>

            </div>


        @else

            {{-- ==================================================
                FORMULARIO DE ENTREGA
            =================================================== --}}

            <form
                method="POST"
                action="{{ route('alumno.tarea.entregar', $tarea) }}"
                enctype="multipart/form-data"
                data-pdf-form
            >

                @csrf


                <div class="form-group">

                    <label for="archivo">
                        Archivo PDF
                    </label>


                    <input
                        type="file"
                        id="archivo"
                        name="archivo"
                        accept="application/pdf,.pdf"
                        data-pdf-input
                        required
                    >


                    <small class="form-help">
                        Máximo 10 MB. Solo archivos PDF.
                    </small>


                    <div
                        class="file-selected"
                        data-file-name
                    >
                        Ningún archivo seleccionado
                    </div>

                </div>


                <div class="form-footer">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-submit-button
                    >

                        <svg viewBox="0 0 24 24" aria-hidden="true">

                            <path
                                d="M12 16V4M7 9l5-5 5 5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M5 14v5h14v-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>

                        Entregar evidencia

                    </button>

                </div>

            </form>

        @endif

    </div>

</section>

@endsection