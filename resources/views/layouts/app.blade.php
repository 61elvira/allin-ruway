<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Allin Ruway</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.dashboard-navigation')

        <div class="dashboard-layout">
            <button id="toggleSidebar" class="sidebar-toggle" aria-label="Menú">☰</button>
            <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

            <aside id="sidebar" class="dashboard-sidebar">
                <div class="sidebar-brand">
                    <a href="{{ route('dashboard') }}"><span class="sidebar-brand-full">ALLIN RUWAY</span><span class="sidebar-brand-short">AR</span></a>
                    <span class="sidebar-brand-full">Marketplace de servicios</span>
                </div>
                <nav>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.usuarios') }}"
                            class="{{ request()->routeIs('admin.usuarios') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <span>Usuarios</span>
                        </a>
                        <a href="{{ route('admin.contrataciones') }}"
                            class="{{ request()->routeIs('admin.contrataciones*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span>Contrataciones</span>
                            @php $pendientesCount = \App\Models\Contratacion::where('estado', 'pendiente')->count(); @endphp
                            @if($pendientesCount > 0)
                                <span class="sidebar-badge">{{ $pendientesCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.servicios') }}"
                            class="{{ request()->routeIs('admin.servicios*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                            <span>Servicios</span>
                        </a>
                        <div class="sidebar-divider"></div>
                    @endif

                    <a href="{{ route('profile.edit') }}"
                        class="{{ request()->routeIs('profile.edit') ? 'active-menu' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>Mi Perfil</span>
                    </a>

                    @if(auth()->user()->rol == 'trabajador')
                        <div class="sidebar-divider"></div>
                        <a href="{{ route('trabajador.mis-servicios') }}"
                            class="{{ request()->routeIs('trabajador.mis-servicios*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                            <span>Mis Servicios</span>
                        </a>
                        <a href="{{ route('trabajador.disponibilidad') }}"
                            class="{{ request()->routeIs('trabajador.disponibilidad*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Disponibilidad</span>
                        </a>
                        <a href="{{ route('contrataciones.index') }}"
                            class="{{ request()->routeIs('contrataciones.index') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span>Solicitudes</span>
                        </a>
                        <a href="{{ route('contrataciones.misTrabajos') }}"
                            class="{{ request()->routeIs('contrataciones.misTrabajos') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            <span>Mis Trabajos</span>
                        </a>
                        <a href="{{ route('trabajador.ganancias') }}"
                            class="{{ request()->routeIs('trabajador.ganancias*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            <span>Ganancias</span>
                        </a>
                        <a href="{{ route('trabajador.resenas') }}"
                            class="{{ request()->routeIs('trabajador.resenas*') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span>Reseñas</span>
                        </a>
                        <a href="{{ route('contrataciones.historial') }}"
                            class="{{ request()->routeIs('contrataciones.historial') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Historial</span>
                        </a>
                    @endif

                    @if(auth()->user()->rol == 'cliente')
                        <div class="sidebar-divider"></div>
                        <a href="{{ route('contrataciones.misContrataciones') }}"
                            class="{{ request()->routeIs('contrataciones.misContrataciones') ? 'active-menu' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span>Mis Contrataciones</span>
                        </a>
                    @endif
                </nav>
                <button id="collapseSidebar" class="sidebar-collapse-btn" title="Colapsar sidebar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
            </aside>

            <main class="dashboard-content">
                @if (isset($header))
                    <header class="dashboard-header">{{ $header }}</header>
                @endif
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const collapseBtn = document.getElementById('collapseSidebar');

            function openSidebar() {
                sidebar.classList.add('open');
                if (backdrop) backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                if (backdrop) backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }

            boton.addEventListener('click', () => {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            if (backdrop) {
                backdrop.addEventListener('click', closeSidebar);
            }

            // Close sidebar on link click (mobile)
            sidebar.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 900) {
                        closeSidebar();
                    }
                });
            });

            // Handle resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 900) {
                    closeSidebar();
                }
            });

            // Sidebar collapse toggle (desktop)
            if (collapseBtn) {
                const stored = localStorage.getItem('sidebarCollapsed');
                if (stored === 'true') sidebar.classList.add('collapsed');

                collapseBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                });
            }
        });
    </script>
</body>

</html>
