<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title ?? 'Sistema de Tareas y Evidencias' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>


<body>

    @php
        /*
        |--------------------------------------------------------------------------
        | Sesión actual
        |--------------------------------------------------------------------------
        | AuthController utiliza "tipo_usuario".
        */
        $usuarioTipo = session('tipo_usuario');
        $usuarioNombre = session('usuario_nombre', 'Usuario');
    @endphp


    <div class="app-shell">


        {{-- =========================================================
            OVERLAY MOBILE
        ========================================================== --}}

        <div
            class="sidebar-overlay"
            data-sidebar-overlay
        ></div>


        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}

        <aside
            class="sidebar"
            data-sidebar
        >

            {{-- Marca --}}
            <div class="sidebar-brand">

                <a
                    href="{{ $usuarioTipo === 'alumno'
                        ? route('alumno.dashboard')
                        : route('docente.dashboard') }}"
                    class="brand"
                >

                    <span class="brand-mark">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v16H7.5A2.5 2.5 0 0 0 5 20.5v-16Z"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M5 20.5A2.5 2.5 0 0 1 7.5 18H20"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M9 6h7M9 10h7M9 14h4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                        </svg>

                    </span>


                    <span class="brand-text">

                        <strong>Tareas</strong>

                        <small>Evidencias</small>

                    </span>

                </a>


                {{-- Cerrar sidebar móvil --}}
                <button
                    type="button"
                    class="sidebar-close"
                    data-sidebar-close
                    aria-label="Cerrar menú"
                >

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

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


            {{-- =====================================================
                NAVEGACIÓN DOCENTE
            ====================================================== --}}

            @if($usuarioTipo === 'docente')

                <nav class="sidebar-nav">


                    {{-- Principal --}}
                    <div class="nav-section">

                        <span class="nav-section-title">
                            Principal
                        </span>


                        <a
                            href="{{ route('docente.dashboard') }}"
                            class="nav-item {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

                                    <rect
                                        x="3"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="14"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="3"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="14"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                </svg>

                            </span>

                            <span>Dashboard</span>

                        </a>

                    </div>


                    {{-- Gestión --}}
                    <div class="nav-section">

                        <span class="nav-section-title">
                            Gestión
                        </span>


                        {{-- Alumnos --}}
                        <a
                            href="{{ route('docente.alumnos.index') }}"
                            class="nav-item {{ request()->routeIs('docente.alumnos.*') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

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
                                        d="M15 5.5a3 3 0 0 1 0 5.8M16 15c2.5.5 3.9 2.1 4.5 4.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                </svg>

                            </span>

                            <span>Alumnos</span>

                        </a>


                        {{-- Tareas --}}
                        <a
                            href="{{ route('tareas.index') }}"
                            class="nav-item {{ request()->routeIs('tareas.*') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

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

                            <span>Tareas</span>

                        </a>


                        {{-- Calificaciones --}}
                        <a
                            href="{{ route('tareas.index') }}"
                            class="nav-item {{ request()->routeIs('tareas.*') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

                                    <path
                                        d="M4 19V5M4 19h17"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="m7 15 4-4 3 2 5-6"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />

                                </svg>

                            </span>

                            <span>Calificaciones</span>

                        </a>

                    </div>


                    {{-- Acciones rápidas --}}
                    <div class="nav-section">

                        <span class="nav-section-title">
                            Acciones rápidas
                        </span>


                        <a
                            href="{{ route('tareas.create') }}"
                            class="nav-item nav-item-action"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

                                    <path
                                        d="M12 5v14M5 12h14"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />

                                </svg>

                            </span>

                            <span>Nueva tarea</span>

                        </a>

                    </div>

                </nav>


            @else


                {{-- =================================================
                    NAVEGACIÓN ALUMNO
                ================================================== --}}

                <nav class="sidebar-nav">


                    {{-- Principal --}}
                    <div class="nav-section">

                        <span class="nav-section-title">
                            Principal
                        </span>


                        <a
                            href="{{ route('alumno.dashboard') }}"
                            class="nav-item {{ request()->routeIs('alumno.dashboard') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

                                    <rect
                                        x="3"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="14"
                                        y="3"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="3"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                    <rect
                                        x="14"
                                        y="14"
                                        width="7"
                                        height="7"
                                        rx="1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    />

                                </svg>

                            </span>

                            <span>Inicio</span>

                        </a>

                    </div>


                    {{-- Mi actividad --}}
                    <div class="nav-section">

                        <span class="nav-section-title">
                            Mi actividad
                        </span>


                        {{-- Tareas --}}
                        <a
                            href="{{ route('alumno.tareas') }}"
                            class="nav-item {{ request()->routeIs('alumno.tareas') || request()->routeIs('alumno.tarea') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

                                    <path
                                        d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="M14 3v5h5M8 12h8M8 16h5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                    />

                                </svg>

                            </span>

                            <span>Tareas</span>

                        </a>


                        {{-- Historial / Calificaciones --}}
                        <a
                            href="{{ route('alumno.historial') }}"
                            class="nav-item {{ request()->routeIs('alumno.historial') ? 'active' : '' }}"
                        >

                            <span class="nav-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >

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

                            </span>

                            <span>Calificaciones</span>

                        </a>

                    </div>

                </nav>

            @endif


            {{-- =====================================================
                USUARIO
            ====================================================== --}}

            <div class="sidebar-footer">

                <div class="sidebar-user">

                    <div class="avatar avatar-sm">
                        {{ strtoupper(substr($usuarioNombre, 0, 1)) }}
                    </div>

                    <div class="sidebar-user-info">

                        <strong>
                            {{ $usuarioNombre }}
                        </strong>

                        <span>
                            {{ $usuarioTipo === 'docente' ? 'Docente' : 'Alumno' }}
                        </span>

                    </div>

                </div>

            </div>

        </aside>


        {{-- =========================================================
            CONTENIDO PRINCIPAL
        ========================================================== --}}

        <div class="main-wrapper">


            {{-- =====================================================
                TOPBAR
            ====================================================== --}}

            <header class="topbar">

                <div class="topbar-left">

                    <button
                        type="button"
                        class="mobile-menu-button"
                        data-mobile-menu
                        aria-label="Abrir menú"
                    >

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                d="M4 7h16M4 12h16M4 17h16"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                        </svg>

                    </button>


                    <div class="topbar-heading">

                        @if(isset($pageTitle))

                            <h1>
                                {{ $pageTitle }}
                            </h1>

                        @endif


                        @if(isset($pageSubtitle))

                            <p>
                                {{ $pageSubtitle }}
                            </p>

                        @endif

                    </div>

                </div>


                <div class="topbar-actions">


                    {{-- Tema --}}
                    <button
                        type="button"
                        class="icon-button"
                        data-theme-toggle
                        aria-label="Cambiar tema"
                        title="Cambiar tema"
                    >

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                            data-theme-icon="sun"
                        >

                            <circle
                                cx="12"
                                cy="12"
                                r="4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            />

                            <path
                                d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                        </svg>


                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                            data-theme-icon="moon"
                            hidden
                        >

                            <path
                                d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 8.5 8.5 0 1 0 20.5 15.2Z"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />

                        </svg>

                    </button>


                    {{-- Perfil --}}
                    <div class="topbar-profile">

                        <div class="avatar">
                            {{ strtoupper(substr($usuarioNombre, 0, 1)) }}
                        </div>

                        <div class="topbar-profile-info">

                            <strong>
                                {{ $usuarioNombre }}
                            </strong>

                            <span>
                                {{ $usuarioTipo === 'docente' ? 'Docente' : 'Alumno' }}
                            </span>

                        </div>

                    </div>


                    {{-- Cerrar sesión --}}
                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="icon-button"
                            title="Cerrar sesión"
                            aria-label="Cerrar sesión"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <path
                                    d="M10 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M14 8l4 4-4 4M9 12h9"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            </svg>

                        </button>

                    </form>

                </div>

            </header>


            {{-- =====================================================
                CONTENIDO
            ====================================================== --}}

            <main class="main-content">


                {{-- Mensaje de éxito --}}
                @if(session('success'))

                    <div
                        class="alert alert-success"
                        data-auto-dismiss
                    >

                        <span class="alert-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

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

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                {{-- Mensaje de error --}}
                @if(session('error'))

                    <div
                        class="alert alert-error"
                        data-auto-dismiss
                    >

                        <span class="alert-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M12 8v5M12 16h.01"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </span>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                @endif


                {{-- Mensaje de advertencia --}}
                @if(session('warning'))

                    <div
                        class="alert alert-warning"
                        data-auto-dismiss
                    >

                        <span class="alert-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <path
                                    d="M12 3 2.8 19h18.4L12 3Z"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M12 9v4M12 16h.01"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </span>

                        <span>
                            {{ session('warning') }}
                        </span>

                    </div>

                @endif


                {{-- Errores de validación --}}
                @if($errors->any())

                    <div class="alert alert-error">

                        <span class="alert-icon">

                            <svg
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M12 8v5M12 16h.01"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </span>


                        <div>

                            <strong>
                                Revisa la información ingresada.
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


                {{-- Contenido de cada página --}}
                {{ $slot ?? '' }}

                @yield('content')

            </main>

        </div>

    </div>


    @stack('scripts')

</body>

</html>