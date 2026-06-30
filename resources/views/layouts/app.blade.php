<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.dashboard-navigation')
        <div class="dashboard-layout">
            <button id="toggleSidebar" class="sidebar-toggle">➔</button>
            <aside id="sidebar" class="dashboard-sidebar">

                <div class="sidebar-logo">
                    <h2>MENÚ</h2>
                </div>
                <nav>
                    <a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                        Inicio
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="{{ request()->routeIs('profile.edit') ? 'active-menu' : '' }}">
                        Mi Perfil
                    </a>

                    @if(auth()->user()->rol == 'trabajador')
                        <a href="{{ route('contrataciones.index') }}"
                            class="{{ request()->routeIs('contrataciones.index') ? 'active-menu' : '' }}">
                            Solicitudes
                        </a>
                        <a href="#">Mis Trabajos</a>
                        <a href="#">Historial</a>
                    @endif

                    @if(auth()->user()->rol == 'cliente')
                        <a href="#">Mis Contrataciones</a>
                    @endif
                </nav>

            </aside>

            <main class="dashboard-content">
                @if (isset($header))
                    <header class="dashboard-header">{{ $header }}</header>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            boton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
</body>


</html>