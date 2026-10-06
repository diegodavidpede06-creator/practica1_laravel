@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">

            <a href="{{ route('docente.alumnos.index') }}">
                Alumnos
            </a>

            <span>/</span>

            <span>Nuevo alumno</span>

        </div>

        <h2 class="page-title">
            Nuevo alumno
        </h2>

        <p class="page-description">
            Registra individualmente una nueva cuenta de alumno.
        </p>

    </div>

</div>


<div class="form-layout">

    <section class="card">

        <div class="card-header">

            <div>

                <h3 class="card-title">
                    Información del alumno
                </h3>

                <p class="card-subtitle">
                    Completa los datos necesarios para crear su cuenta.
                </p>

            </div>

        </div>


        <form
            action="{{ route('docente.alumnos.store') }}"
            method="POST"
        >

            @csrf

            <div class="card-body">

                <div class="form-grid">

                    {{-- Nombre --}}
                    <div class="form-group form-group-full">

                        <label for="nombre">
                            Nombre completo
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej. Juan Pérez López"
                            required
                        >

                    </div>


                    {{-- Matrícula --}}
                    <div class="form-group">

                        <label for="matricula">
                            Matrícula
                        </label>

                        <input
                            type="text"
                            id="matricula"
                            name="matricula"
                            value="{{ old('matricula') }}"
                            placeholder="Ej. A00125"
                        >

                    </div>


                    {{-- Correo --}}
                    <div class="form-group">

                        <label for="correo">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            value="{{ old('correo') }}"
                            placeholder="alumno@ejemplo.com"
                        >

                    </div>


                    {{-- Usuario --}}
                    <div class="form-group">

                        <label for="usuario">
                            Usuario
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="usuario"
                            name="usuario"
                            value="{{ old('usuario') }}"
                            placeholder="Ej. juan.perez"
                            required
                        >

                        <span class="form-help">
                            Será utilizado para iniciar sesión.
                        </span>

                    </div>


                    {{-- Contraseña --}}
                    <div class="form-group">

                        <label for="password">
                            Contraseña
                            <span class="required">*</span>
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Contraseña inicial"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-password-toggle
                                aria-label="Mostrar contraseña"
                            >

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                    data-password-icon="show"
                                >
                                    <path
                                        d="M3 12s3.5-6 9-6 9 6 9 6-3.5 6-9 6-9-6-9-6Z"
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

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                    data-password-icon="hide"
                                    hidden
                                >
                                    <path
                                        d="M4 4l16 16"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M6 7c-2 1.5-3 3.5-3 5 0 0 3.5 6 9 6 1.1 0 2.1-.2 3-.6M10.5 6.2A8.7 8.7 0 0 1 12 6c5.5 0 9 6 9 6a15.7 15.7 0 0 1-3 3.7"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </button>

                        </div>

                    </div>

                </div>


                <div class="info-box">

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
                            d="M12 11v5M12 8h.01"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                    <div>

                        <strong>
                            Acceso del alumno
                        </strong>

                        <p>
                            El alumno podrá utilizar el usuario y contraseña
                            registrados para ingresar al sistema y entregar
                            sus evidencias.
                        </p>

                    </div>

                </div>

            </div>


            <div class="card-footer">

                <a
                    href="{{ route('docente.alumnos.index') }}"
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
                            d="m5 12 4 4L19 6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Crear alumno

                </button>

            </div>

        </form>

    </section>


    {{-- Ayuda lateral --}}
    <aside class="side-card">

        <div class="side-card-icon">

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
                    d="M12 11v5M12 8h.01"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <h3>
            Recomendaciones
        </h3>

        <ul class="side-card-list">

            <li>
                Utiliza un usuario único para cada alumno.
            </li>

            <li>
                Evita compartir contraseñas entre alumnos.
            </li>

            <li>
                La matrícula puede utilizarse para identificar al alumno.
            </li>

            <li>
                Puedes registrar más alumnos posteriormente mediante carga masiva.
            </li>

        </ul>

    </aside>

</div>

@endsection