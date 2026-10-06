@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">

            <a href="{{ route('docente.tareas.index') }}">
                Tareas
            </a>

            <span>/</span>

            <span>Nueva tarea</span>

        </div>

        <h2 class="page-title">
            Nueva tarea
        </h2>

        <p class="page-description">
            Crea una actividad y establece la fecha límite de entrega.
        </p>

    </div>

</div>


<form
    action="{{ route('docente.tareas.store') }}"
    method="POST"
    data-unsaved-form
>

    @csrf


    <div class="form-layout">

        <section class="card">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        Información de la tarea
                    </h3>

                    <p class="card-subtitle">
                        Define los datos que verán todos los alumnos.
                    </p>

                </div>

            </div>


            <div class="card-body">

                {{-- Título --}}
                <div class="form-group">

                    <label for="titulo">
                        Título de la tarea
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        value="{{ old('titulo') }}"
                        placeholder="Ej. Investigación sobre ecosistemas"
                        maxlength="255"
                        required
                    >

                </div>


                {{-- Descripción --}}
                <div class="form-group">

                    <label for="descripcion">
                        Instrucciones
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="6"
                        maxlength="5000"
                        placeholder="Escribe las instrucciones de la actividad..."
                        required
                    >{{ old('descripcion') }}</textarea>

                    <span class="form-help">
                        Explica claramente qué debe realizar y entregar el alumno.
                    </span>

                </div>


                {{-- Fecha --}}
                <div class="form-grid">

                    <div class="form-group">

                        <label for="fecha_entrega">
                            Fecha y hora límite
                            <span class="required">*</span>
                        </label>

                        <input
                            type="datetime-local"
                            id="fecha_entrega"
                            name="fecha_entrega"
                            value="{{ old('fecha_entrega') }}"
                            required
                        >

                        <span class="form-help">
                            Después de esta fecha se podrán registrar las calificaciones.
                        </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- ======================================================
            TIPO DE TAREA
        ======================================================= --}}

        <section class="card">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        Tipo de actividad
                    </h3>

                    <p class="card-subtitle">
                        Selecciona exactamente un tipo de tarea.
                    </p>

                </div>

            </div>


            <div class="card-body">

                <div class="task-type-grid">


                    {{-- Casa --}}
                    <label class="task-type-card">

                        <input
                            type="radio"
                            name="tipo"
                            value="casa"
                            @checked(old('tipo') === 'casa')
                            required
                        >

                        <span class="task-type-card-content">

                            <span class="task-type-icon">

                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="m3 10 9-7 9 7"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="M5 9v11h14V9M9 20v-6h6v6"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                            </span>

                            <span class="task-type-text">

                                <strong>
                                    Tarea en casa
                                </strong>

                                <small>
                                    Actividad que el alumno realiza fuera del aula.
                                </small>

                            </span>

                            <span class="task-type-check">

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

                            </span>

                        </span>

                    </label>


                    {{-- Clase --}}
                    <label class="task-type-card">

                        <input
                            type="radio"
                            name="tipo"
                            value="clase"
                            @checked(old('tipo') === 'clase')
                        >

                        <span class="task-type-card-content">

                            <span class="task-type-icon">

                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect
                                        x="4"
                                        y="4"
                                        width="16"
                                        height="16"
                                        rx="2"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        d="M8 9h8M8 13h8M8 17h4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </span>

                            <span class="task-type-text">

                                <strong>
                                    Actividad en clase
                                </strong>

                                <small>
                                    Trabajo realizado durante la sesión de clase.
                                </small>

                            </span>

                            <span class="task-type-check">

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

                            </span>

                        </span>

                    </label>


                    {{-- Exposición --}}
                    <label class="task-type-card">

                        <input
                            type="radio"
                            name="tipo"
                            value="exposicion"
                            @checked(old('tipo') === 'exposicion')
                        >

                        <span class="task-type-card-content">

                            <span class="task-type-icon">

                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect
                                        x="4"
                                        y="4"
                                        width="16"
                                        height="13"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        d="M8 21h8M12 17v4M8 9h8M8 12h5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </span>

                            <span class="task-type-text">

                                <strong>
                                    Exposición
                                </strong>

                                <small>
                                    Presentación o exposición asignada al alumno.
                                </small>

                            </span>

                            <span class="task-type-check">

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

                            </span>

                        </span>

                    </label>

                </div>

            </div>

        </section>


        {{-- ======================================================
            REGLAS
        ======================================================= --}}

        <section class="card">

            <div class="card-header">

                <div>

                    <h3 class="card-title">
                        Reglas de entrega
                    </h3>

                    <p class="card-subtitle">
                        Estas condiciones se aplicarán automáticamente.
                    </p>

                </div>

            </div>


            <div class="card-body">

                <div class="rules-list">

                    <div class="rule-item">

                        <span class="rule-icon">

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

                        </span>

                        <div>
                            <strong>
                                Un solo archivo
                            </strong>

                            <span>
                                Cada alumno podrá entregar una única evidencia.
                            </span>
                        </div>

                    </div>


                    <div class="rule-item">

                        <span class="rule-icon">

                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M4 5h16v14H4z"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M8 9h8M8 13h8M8 17h4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                            </svg>

                        </span>

                        <div>
                            <strong>
                                Formato PDF
                            </strong>

                            <span>
                                La evidencia deberá ser un archivo PDF.
                            </span>
                        </div>

                    </div>


                    <div class="rule-item">

                        <span class="rule-icon">

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

                        </span>

                        <div>
                            <strong>
                                Fecha límite
                            </strong>

                            <span>
                                Las calificaciones se habilitan después de la fecha límite.
                            </span>
                        </div>

                    </div>


                    <div class="rule-item">

                        <span class="rule-icon">

                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M6 4h12v16H6z"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M9 8h6M9 12h6M9 16h4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                            </svg>

                        </span>

                        <div>
                            <strong>
                                Sin edición posterior
                            </strong>

                            <span>
                                Una vez creada, la tarea no podrá modificarse.
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- Botones --}}
        <div class="form-actions">

            <a
                href="{{ route('docente.tareas.index') }}"
                class="btn btn-ghost"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-primary btn-lg"
            >

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

                Crear y publicar tarea

            </button>

        </div>

    </div>

</form>

@endsection