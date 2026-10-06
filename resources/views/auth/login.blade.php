@extends('layouts.guest')

@section('content')

<div class="auth-card">

    <div class="auth-header">

        <div class="auth-logo">

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

        </div>

        <h1>
            Bienvenido
        </h1>

        <p>
            Ingresa al sistema para administrar tus tareas y evidencias.
        </p>

    </div>


    <form
        action="{{ route('login') }}"
        method="POST"
        class="form"
    >

        @csrf


        {{-- Usuario --}}
        <div class="form-group">

            <label for="usuario">
                Usuario
            </label>

            <div class="input-wrapper">

                <span class="input-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle
                            cx="12"
                            cy="8"
                            r="3.5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M5 20c.8-3.4 3.1-5.2 7-5.2s6.2 1.8 7 5.2"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                </span>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    value="{{ old('usuario') }}"
                    placeholder="Ingresa tu usuario"
                    autocomplete="username"
                    required
                    autofocus
                >

            </div>

        </div>


        {{-- Contraseña --}}
        <div class="form-group">

            <label for="password">
                Contraseña
            </label>

            <div class="input-wrapper">

                <span class="input-icon">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <rect
                            x="5"
                            y="10"
                            width="14"
                            height="11"
                            rx="2"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />

                        <path
                            d="M8 10V7a4 4 0 0 1 8 0v3"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                </span>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ingresa tu contraseña"
                    autocomplete="current-password"
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
                            d="M10.6 6.2A9.5 9.5 0 0 1 12 6c5.5 0 9 6 9 6a16.5 16.5 0 0 1-3.1 3.7M6.1 6.9C4.1 8.2 3 10 3 12c0 0 3.5 6 9 6 1 0 2-.2 2.9-.5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                </button>

            </div>

        </div>


        {{-- Recordar --}}
        <div class="form-row form-row-between">

            <label class="checkbox-label">

                <input
                    type="checkbox"
                    name="recordar"
                    value="1"
                >

                <span class="checkbox-custom"></span>

                <span>
                    Recordar sesión
                </span>

            </label>

        </div>


        <button
            type="submit"
            class="btn btn-primary btn-lg btn-block"
        >

            <span>
                Iniciar sesión
            </span>

            <svg
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    d="M5 12h13M13 6l6 6-6 6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </button>

    </form>


    <div class="auth-help">

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
                d="M12 11v5M12 8h.01"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
            />
        </svg>

        <span>
            Si tienes problemas para ingresar, solicita apoyo al docente.
        </span>

    </div>

</div>

@endsection