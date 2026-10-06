@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">
            <span>Gestión</span>
            <span>/</span>
            <span>Tareas</span>
            <span>/</span>
            <span>Nueva tarea</span>
        </div>

        <h1 class="page-title">
            Nueva tarea
        </h1>

        <p class="page-description">
            Crea una nueva actividad para todos los alumnos del grupo.
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


{{-- ==========================================================
    ERRORES DE VALIDACIÓN
=========================================================== --}}

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
                d="M12 7v5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />

            <circle
                cx="12"
                cy="16"
                r="1"
                fill="currentColor"
            />
        </svg>

        <div>

            <strong>
                Revisa los datos del formulario.
            </strong>

            <ul class="alert-list">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    </div>

@endif


{{-- ==========================================================
    FORMULARIO
=========================================================== --}}

<form
    method="POST"
    action="{{ route('tareas.store') }}"
    data-confirm-submit
>

    @csrf


    <div class="form-layout">

        {{-- ==================================================
            INFORMACIÓN DE LA TAREA
        =================================================== --}}

        <section class="card">

            <div class="card-header">

                <div>

                    <h2 class="card-title">
                        Información de la tarea
                    </h2>

                    <p class="card-subtitle">
                        Define los datos principales de la actividad.
                    </p>

                </div>

            </div>


            <div class="card-body">

                <div class="form-grid">


                    {{-- Título --}}
                    <div class="form-group form-group-full">

                        <label for="titulo">
                            Título de la tarea
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            value="{{ old('titulo') }}"
                            placeholder="Ej. Investigación sobre redes LAN"
                            maxlength="255"
                            required
                            autofocus
                        >

                        <small class="form-help">
                            Escribe un nombre claro para identificar la actividad.
                        </small>

                        @error('titulo')

                            <span class="form-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Tipo --}}
                    <div class="form-group">

                        <label for="tipo">
                            Tipo de tarea
                            <span class="required">*</span>
                        </label>

                        <select
                            id="tipo"
                            name="tipo"
                            required
                        >

                            <option value="">
                                Selecciona un tipo
                            </option>

                            <option
                                value="casa"
                                @selected(old('tipo') === 'casa')
                            >
                                Tarea en casa
                            </option>

                            <option
                                value="clase"
                                @selected(old('tipo') === 'clase')
                            >
                                Actividad en clase
                            </option>

                            <option
                                value="exposicion"
                                @selected(old('tipo') === 'exposicion')
                            >
                                Exposición
                            </option>

                        </select>

                        <small class="form-help">
                            Selecciona una de las tres categorías disponibles.
                        </small>

                        @error('tipo')

                            <span class="form-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Fecha --}}
                    <div class="form-group">

                        <label for="fecha_entrega">
                            Fecha y hora de entrega
                            <span class="required">*</span>
                        </label>

                        <input
                            type="datetime-local"
                            id="fecha_entrega"
                            name="fecha_entrega"
                            value="{{ old('fecha_entrega') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            required
                        >

                        <small class="form-help">
                            Los alumnos podrán entregar hasta esta fecha y hora.
                        </small>

                        @error('fecha_entrega')

                            <span class="form-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Descripción --}}
                    <div class="form-group form-group-full">

                        <label for="descripcion">
                            Descripción e instrucciones
                        </label>

                        <textarea
                            id="descripcion"
                            name="descripcion"
                            rows="7"
                            maxlength="5000"
                            placeholder="Escribe aquí las instrucciones, requisitos o indicaciones para los alumnos..."
                        >{{ old('descripcion') }}</textarea>

                        <small class="form-help">
                            Explica qué deben realizar los alumnos y qué deben incluir en su evidencia.
                        </small>

                        @error('descripcion')

                            <span class="form-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>

        </section>


        {{-- ==================================================
            REGLAS DE ENTREGA
        =================================================== --}}

        <section class="card">

            <div class="card-header">

                <div>

                    <h2 class="card-title">
                        Reglas de entrega
                    </h2>

                    <p class="card-subtitle">
                        Consideraciones importantes para los alumnos.
                    </p>

                </div>

            </div>


            <div class="card-body">

                <div class="info-list">


                    {{-- Regla 1 --}}
                    <div class="info-list-item">

                        <div class="info-list-icon">

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

                        <div>

                            <strong>
                                Una evidencia por tarea
                            </strong>

                            <span>
                                Cada alumno podrá entregar un único archivo PDF.
                            </span>

                        </div>

                    </div>


                    {{-- Regla 2 --}}
                    <div class="info-list-item">

                        <div class="info-list-icon">

                            <svg viewBox="0 0 24 24" aria-hidden="true">

                                <path
                                    d="M12 3v12"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="m7 10 5 5 5-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M5 21h14"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <strong>
                                Formato PDF
                            </strong>

                            <span>
                                El archivo de evidencia no deberá superar los 10 MB.
                            </span>

                        </div>

                    </div>


                    {{-- Regla 3 --}}
                    <div class="info-list-item">

                        <div class="info-list-icon">

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
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </div>

                        <div>

                            <strong>
                                Fecha límite
                            </strong>

                            <span>
                                Después de la fecha establecida ya no se podrán realizar entregas.
                            </span>

                        </div>

                    </div>


                    {{-- Regla 4 --}}
                    <div class="info-list-item">

                        <div class="info-list-icon">

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

                        </div>

                        <div>

                            <strong>
                                Sin edición posterior
                            </strong>

                            <span>
                                Una vez creada, la tarea no podrá editarse. Solo podrá cancelarse.
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ==================================================
            AVISO
        =================================================== --}}

        <div class="info-box">

            <div class="info-box-icon">

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
                        d="M12 10v6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <circle
                        cx="12"
                        cy="7"
                        r="1"
                        fill="currentColor"
                    />

                </svg>

            </div>

            <div>

                <strong>
                    Antes de crear la tarea
                </strong>

                <p>
                    Verifica el título, tipo, instrucciones y fecha de entrega.
                    Después de crearla no podrás modificar estos datos.
                </p>

            </div>

        </div>


        {{-- ==================================================
            BOTONES
        =================================================== --}}

        <div class="form-footer">

            <a
                href="{{ route('tareas.index') }}"
                class="btn btn-ghost"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >

                <svg viewBox="0 0 24 24" aria-hidden="true">

                    <path
                        d="M5 4h14v16H5z"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M8 4v5h8V4M8 16h8"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />

                </svg>

                Crear tarea

            </button>

        </div>

    </div>

</form>

@endsection