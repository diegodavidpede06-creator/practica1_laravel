@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>

        <div class="breadcrumb">

            <a href="{{ route('docente.alumnos.index') }}">
                Alumnos
            </a>

            <span>/</span>

            <span>Editar</span>

        </div>

        <h2 class="page-title">
            Editar alumno
        </h2>

        <p class="page-description">
            Actualiza la información de la cuenta del alumno.
        </p>

    </div>

</div>


<div class="form-layout">

    <section class="card">

        <div class="card-header">

            <div class="table-user">

                <div class="avatar">
                    {{ strtoupper(substr($alumno->nombre, 0, 1)) }}
                </div>

                <div>

                    <h3 class="card-title">
                        {{ $alumno->nombre }}
                    </h3>

                    <p class="card-subtitle">
                        Usuario: {{ $alumno->usuario }}
                    </p>

                </div>

            </div>

        </div>


        <form
            action="{{ route('docente.alumnos.update', $alumno) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-grid">

                    <div class="form-group form-group-full">

                        <label for="nombre">
                            Nombre completo
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', $alumno->nombre) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="matricula">
                            Matrícula
                        </label>

                        <input
                            type="text"
                            id="matricula"
                            name="matricula"
                            value="{{ old('matricula', $alumno->matricula) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label for="correo">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            value="{{ old('correo', $alumno->correo) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label for="usuario">
                            Usuario
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="usuario"
                            name="usuario"
                            value="{{ old('usuario', $alumno->usuario) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Nueva contraseña
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Dejar vacío para conservarla"
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

                        <span class="form-help">
                            Solo completa este campo si deseas cambiar la contraseña.
                        </span>

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Estado de la cuenta
                    </label>

                    <label class="checkbox-label">

                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            @checked(old('activo', $alumno->activo))
                        >

                        <span class="checkbox-custom"></span>

                        <span>
                            Cuenta activa
                        </span>

                    </label>

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

                    Guardar cambios

                </button>

            </div>

        </form>

    </section>

</div>

@endsection