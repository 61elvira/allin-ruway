<x-app-layout>
    <div class="db-dashboard">
        <div class="db-welcome">
            <h1>{{ auth()->user()->name }}</h1>
            <p>{{ auth()->user()->isTrabajador() ? 'Gestiona tus trabajos y solicitudes desde aquí.' : 'Encuentra al profesional ideal para tu proyecto.' }}</p>
        </div>

        <div class="db-stats">
            @if(auth()->user()->isTrabajador())
                <div class="db-stat db-stat--gold">
                    <div class="db-stat__icon db-stat__icon--gold">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['total_solicitudes'] ?? 0 }}</div>
                    <div class="db-stat__label">Solicitudes</div>
                </div>
                <div class="db-stat db-stat--orange">
                    <div class="db-stat__icon db-stat__icon--orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['pendientes'] ?? 0 }}</div>
                    <div class="db-stat__label">Pendientes</div>
                </div>
                <div class="db-stat db-stat--blue">
                    <div class="db-stat__icon db-stat__icon--blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['activas'] ?? 0 }}</div>
                    <div class="db-stat__label">Activas</div>
                </div>
                <div class="db-stat db-stat--green">
                    <div class="db-stat__icon db-stat__icon--green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['finalizadas'] ?? 0 }}</div>
                    <div class="db-stat__label">Finalizadas</div>
                </div>
                <div class="db-stat db-stat--star">
                    <div class="db-stat__icon db-stat__icon--star">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div class="db-stat__value">{{ number_format($stats['promedio'] ?? 0, 1) }}</div>
                    <div class="db-stat__label">Calificación</div>
                </div>
            @else
                <div class="db-stat db-stat--gold">
                    <div class="db-stat__icon db-stat__icon--gold">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['total_contrataciones'] ?? 0 }}</div>
                    <div class="db-stat__label">Contrataciones</div>
                </div>
                <div class="db-stat db-stat--orange">
                    <div class="db-stat__icon db-stat__icon--orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['pendientes'] ?? 0 }}</div>
                    <div class="db-stat__label">Pendientes</div>
                </div>
                <div class="db-stat db-stat--blue">
                    <div class="db-stat__icon db-stat__icon--blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['activas'] ?? 0 }}</div>
                    <div class="db-stat__label">Activas</div>
                </div>
                <div class="db-stat db-stat--green">
                    <div class="db-stat__icon db-stat__icon--green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $stats['finalizadas'] ?? 0 }}</div>
                    <div class="db-stat__label">Finalizadas</div>
                </div>
                <div class="db-stat db-stat--info">
                    <div class="db-stat__icon db-stat__icon--info">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div class="db-stat__value">{{ $totalTrabajadores }}</div>
                    <div class="db-stat__label">Trabajadores</div>
                </div>
            @endif
        </div>

        <div class="db-grid">
            <div class="db-card">
                <h3 class="db-card__title">Contrataciones por mes</h3>
                <div class="db-card__body">
                    <canvas id="chartDashboard"></canvas>
                </div>
            </div>

            <div class="db-card">
                <h3 class="db-card__title">Acceso rápido</h3>
                <div class="db-card__body">
                    <div class="db-quick-links">
                        <a href="{{ route('servicios.index') }}" class="db-quick-link">
                            <div class="db-quick-link__icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                            </div>
                            <span>Ver servicios</span>
                        </a>
                        <a href="{{ route('usuarios.index') }}" class="db-quick-link">
                            <div class="db-quick-link__icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <span>Buscar trabajadores</span>
                        </a>
                        @if(auth()->user()->isTrabajador())
                            <a href="{{ route('contrataciones.index') }}" class="db-quick-link">
                                <div class="db-quick-link__icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <span>Ver solicitudes</span>
                            </a>
                        @else
                            <a href="{{ route('usuarios.index') }}" class="db-quick-link">
                                <div class="db-quick-link__icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <span>Contratar ahora</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="db-quick-link">
                            <div class="db-quick-link__icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <span>Mi perfil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="db-card" style="margin-top: 20px;">
            <div class="db-card__header">
                <h3 class="db-card__title">Servicios disponibles</h3>
                <a href="{{ route('servicios.index') }}" class="db-card__link">Ver todos →</a>
            </div>
            <div class="db-card__body">
                <div class="db-services-grid">
                    @foreach($servicios as $servicio)
                        <a href="{{ route('usuarios.index', ['servicio' => $servicio->id]) }}" class="db-service-chip">
                            @switch($servicio->nombre)
                                @case('Electricista') ⚡ @break
                                @case('Carpintero') 🪚 @break
                                @case('Gasfitero') 🚰 @break
                                @default 🛠️
                            @endswitch
                            {{ $servicio->nombre }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartDashboard');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($meses) !!},
                        datasets: [{
                            label: 'Contrataciones',
                            data: {!! json_encode($datosContratos) !!},
                            backgroundColor: 'rgba(217, 107, 43, 0.65)',
                            borderColor: '#d96b2b',
                            borderWidth: 2,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.04)' },
                                ticks: { stepSize: 1 }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
