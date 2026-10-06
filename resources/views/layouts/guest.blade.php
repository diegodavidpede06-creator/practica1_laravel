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
        {{ $title ?? 'Acceso | Sistema de Tareas' }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>


<body class="auth-page">

    <div class="auth-background">

        {{-- Contenedor superior --}}
        <div class="auth-topbar">

            <a
                href="{{ route('login') }}"
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

        </div>


        {{-- Contenido de autenticación --}}
        <main class="auth-container">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div
                    class="alert alert-success"
                    data-auto-dismiss
                >
                    <span class="alert-icon">

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


            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="alert alert-error">

                    <span class="alert-icon">

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
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>
            @endif


            @yield('content')

            {{ $slot ?? '' }}

        </main>


        <footer class="auth-footer">

            <span>
                Sistema de gestión de tareas y evidencias
            </span>

        </footer>

    </div>


    @stack('scripts')

</body>
</html>