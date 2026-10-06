@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <div class="breadcrumb">
            <span>Gestión</span>
            <span>/</span>
            <span>Alumnos</span>
        </div>

        <h1 class="page-title">
            Alumnos
        </h1>

        <p class="page-description">
            Administra los alumnos registrados en tu grupo.
        </p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('docente.alumnos.create') }}"
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

            <span>
                Nuevo alumno
            </span>
        </a>

    </div>

</div>


{{-- ==========================================================
    MENSAJES
=========================================================== --}}

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


{{-- ==========================================================
    ESTADÍSTICAS
=========================================================== --}}

<div class="stats-grid">

    {{-- Total --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-purple">

            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle
                    cx="9"
                    cy="8"
                    r="3"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M3.5 20c.6-3.3 2.4-5 5.5-5s4.9 1.7 5.5 5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M15 6a3 3 0 0 1 0 5.8M16 15c2.5.5 3.9 2.1 4.5 4.5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

        </div>

        <div class="stat-card-content">

            <span class="stat-label">
                Total de alumnos
            </span>

            <strong class="stat-value">
                {{ $total }}
            </strong>

            <span class="stat-description">
                Registros existentes
            </span>

        </div>

    </div>


    {{-- Activos --}}
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
                Activos
            </span>

            <strong class="stat-value">
                {{ $activos }}
            </strong>

            <span class="stat-description">
                Pueden ingresar al sistema
            </span>

        </div>

    </div>


    {{-- Inactivos --}}
    <div class="stat-card">

        <div class="stat-card-icon stat-icon-red">

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

        <div class="stat-card-content">

            <span class="stat-label">
                Inactivos
            </span>

            <strong class="stat-value">
                {{ $inactivos }}
            </strong>

            <span class="stat-description">
                Cuentas desactivadas
            </span>

        </div>

    </div>

</div>


{{-- ==========================================================
    DIRECTORIO
=========================================================== --}}

<section class="card">

    <div class="card-header">

        <div>

            <h2 class="card-title">
                Directorio de alumnos
            </h2>

            <p class="card-subtitle">
                Busca y administra las cuentas de tus alumnos.
            </p>

        </div>

        <div class="card-header-actions">

            <button
                type="button"
                class="btn btn-ghost"
                data-modal-open="modal-importar"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M12 16V4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <path
                        d="m8 8 4-4 4 4"
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
                        stroke-linejoin="round"
                    />
                </svg>

                Carga masiva
            </button>

        </div>

    </div>


    {{-- ======================================================
        FILTROS
    ======================================================= --}}

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('docente.alumnos.index') }}"
            class="filters-form"
        >

            <div class="form-group">

                <label for="buscar">
                    Buscar
                </label>

                <div class="input-with-icon">

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle
                            cx="11"
                            cy="11"
                            r="6.5"
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

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Nombre o usuario..."
                    >

                </div>

            </div>


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
                        value="activo"
                        @selected(request('estado') === 'activo')
                    >
                        Activos
                    </option>

                    <option
                        value="inactivo"
                        @selected(request('estado') === 'inactivo')
                    >
                        Inactivos
                    </option>
                </select>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Filtrar
                </button>

                <a
                    href="{{ route('docente.alumnos.index') }}"
                    class="btn btn-ghost"
                >
                    Limpiar
                </a>

            </div>

        </form>

    </div>


    {{-- ======================================================
        TABLA
    ======================================================= --}}

    <div class="card-body no-padding">

        @if($alumnos->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>Alumno</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($alumnos as $alumno)

                            <tr>

                                <td>

                                    <div class="table-primary">

                                        <strong>
                                            {{ $alumno->nombre }}
                                        </strong>

                                    </div>

                                </td>


                                <td>

                                    <span class="table-secondary">
                                        {{ $alumno->usuario }}
                                    </span>

                                </td>


                                <td>

                                    @if($alumno->activo)

                                        <span class="badge badge-success">
                                            Activo
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            Inactivo
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="table-secondary">
                                        {{ $alumno->created_at?->format('d/m/Y') }}
                                    </span>

                                </td>


                                <td>

                                    <div class="table-actions">

                                        <a
                                            href="{{ route('docente.alumnos.show', $alumno) }}"
                                            class="icon-button"
                                            title="Ver alumno"
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


                                        <a
                                            href="{{ route('docente.alumnos.edit', $alumno) }}"
                                            class="icon-button"
                                            title="Editar alumno"
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    d="m4 16 10-10 4 4L8 20H4v-4Z"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    stroke-linejoin="round"
                                                />

                                                <path
                                                    d="m13 7 4 4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                />
                                            </svg>
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('docente.alumnos.toggle', $alumno) }}"
                                            class="inline-form"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="icon-button"
                                                title="{{ $alumno->activo ? 'Desactivar alumno' : 'Activar alumno' }}"
                                                data-confirm="{{ $alumno->activo ? '¿Deseas desactivar este alumno?' : '¿Deseas activar este alumno?' }}"
                                            >

                                                @if($alumno->activo)

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                    >
                                                        <rect
                                                            x="4"
                                                            y="4"
                                                            width="16"
                                                            height="16"
                                                            rx="3"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                        />

                                                        <path
                                                            d="M9 9v6M15 9v6"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                            stroke-linecap="round"
                                                        />
                                                    </svg>

                                                @else

                                                    <svg
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                    >
                                                        <rect
                                                            x="4"
                                                            y="4"
                                                            width="16"
                                                            height="16"
                                                            rx="3"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                        />

                                                        <path
                                                            d="M10 8v8l6-4-6-4Z"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                            stroke-linejoin="round"
                                                        />
                                                    </svg>

                                                @endif

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Paginación --}}

            @if($alumnos->hasPages())

                <div class="pagination-wrapper">

                    {{ $alumnos->withQueryString()->links() }}

                </div>

            @endif

        @else

            <div class="empty-state">

                <div class="empty-state-icon">

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle
                            cx="11"
                            cy="11"
                            r="6.5"
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

                </div>

                <h3>
                    No se encontraron alumnos
                </h3>

                <p>
                    Intenta cambiar los filtros o registra un nuevo alumno.
                </p>

            </div>

        @endif

    </div>

</section>


{{-- ==========================================================
    MODAL CARGA MASIVA
=========================================================== --}}

<div
    class="modal"
    id="modal-importar"
    data-modal
    aria-hidden="true"
>

    <div
        class="modal-overlay"
        data-modal-close
    ></div>


    <div
        class="modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-importar-title"
    >

        <div class="modal-header">

            <div>

                <h2 id="modal-importar-title">
                    Carga masiva de alumnos
                </h2>

                <p>
                    Importa alumnos mediante un archivo CSV.
                </p>

            </div>

            <button
                type="button"
                class="icon-button"
                data-modal-close
                aria-label="Cerrar"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M6 6l12 12M18 6 6 18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    />
                </svg>
            </button>

        </div>


        <form
            method="POST"
            action="{{ route('docente.alumnos.importar') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="modal-body">

                <div class="form-group">

                    <label for="archivo">
                        Archivo CSV
                    </label>

                    <input
                        type="file"
                        id="archivo"
                        name="archivo"
                        accept=".csv,.txt"
                        required
                    >

                    <small class="form-help">
                        Formato: nombre,usuario,password
                    </small>

                </div>


                <div class="info-box">

                    <strong>
                        Ejemplo
                    </strong>

                    <code>
                        Ana García,alumno16,Alumno123
                    </code>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-ghost"
                    data-modal-close
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Importar alumnos
                </button>

            </div>

        </form>

    </div>

</div>

@endsection