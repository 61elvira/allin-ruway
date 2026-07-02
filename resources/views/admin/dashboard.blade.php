@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <h1 class="page-title">Dashboard</h1>

    {{-- Stats Cards --}}
    <div class="admin-stats">
        <div class="stat-card stat-card--users">
            <div class="stat-card__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-card__info">
                <span class="stat-card__value">{{ $totalUsuarios }}</span>
                <span class="stat-card__label">Usuarios totales</span>
            </div>
            <div class="stat-card__breakdown">
                <span>{{ $totalClientes }} clientes</span>
                <span>{{ $totalTrabajadores }} trabajadores</span>
            </div>
        </div>

        <div class="stat-card stat-card--contracts">
            <div class="stat-card__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <div class="stat-card__info">
                <span class="stat-card__value">{{ $totalContrataciones }}</span>
                <span class="stat-card__label">Contrataciones</span>
            </div>
            <div class="stat-card__breakdown">
                <span>{{ $contratacionesPendientes }} pendientes</span>
                <span>{{ $contratacionesActivas }} activas</span>
                <span>{{ $contratacionesFinalizadas }} finalizadas</span>
            </div>
        </div>

        <div class="stat-card stat-card--ratings">
            <div class="stat-card__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div class="stat-card__info">
                <span class="stat-card__value">{{ number_format($promedioGeneral, 1) }}</span>
                <span class="stat-card__label">Calificación promedio</span>
            </div>
            <div class="stat-card__breakdown">
                <span>{{ $totalResenas }} reseñas</span>
            </div>
        </div>

        <div class="stat-card stat-card--services">
            <div class="stat-card__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
            </div>
            <div class="stat-card__info">
                <span class="stat-card__value">{{ $totalServicios }}</span>
                <span class="stat-card__label">Servicios</span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="admin-charts">
        <div class="admin-chart-card">
            <h3 class="admin-chart-card__title">Contrataciones por mes ({{ date('Y') }})</h3>
            <div class="admin-chart-card__body">
                <canvas id="chartContratos"></canvas>
            </div>
        </div>
        <div class="admin-chart-card">
            <h3 class="admin-chart-card__title">Usuarios por rol</h3>
            <div class="admin-chart-card__body">
                <canvas id="chartUsuarios"></canvas>
            </div>
        </div>
    </div>

    {{-- Tables Row --}}
    <div class="admin-tables">
        <div class="admin-table-card">
            <h3 class="admin-table-card__title">Últimos usuarios registrados</h3>
            <div class="admin-table-card__body">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimosUsuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }} {{ $usuario->apellido }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <span class="admin-role-badge admin-role-badge--{{ $usuario->rol }}">
                                        {{ ucfirst($usuario->rol) }}
                                    </span>
                                </td>
                                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-table-card">
            <h3 class="admin-table-card__title">Últimas contrataciones</h3>
            <div class="admin-table-card__body">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Trabajador</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimasContrataciones as $c)
                            <tr>
                                <td>{{ $c->cliente->name }}</td>
                                <td>{{ $c->trabajador->name ?? '—' }}</td>
                                <td>{{ $c->servicio->nombre ?? '—' }}</td>
                                <td>
                                    <span class="admin-status admin-status--{{ $c->estado }}">
                                        {{ ucfirst($c->estado) }}
                                    </span>
                                </td>
                                <td>{{ $c->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(!empty($distritosPopulares))
    <div class="admin-table-card">
        <h3 class="admin-table-card__title">Distritos con más trabajadores</h3>
        <div class="admin-table-card__body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Distrito</th>
                        <th>Trabajadores</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($distritosPopulares as $distrito => $total)
                        <tr>
                            <td>{{ $distrito }}</td>
                            <td><strong>{{ $total }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart !== 'undefined') {
                new Chart(document.getElementById('chartContratos'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($meses) !!},
                        datasets: [{
                            label: 'Contrataciones',
                            data: {!! json_encode($datosContratos) !!},
                            backgroundColor: 'rgba(217, 107, 43, 0.7)',
                            borderColor: '#d96b2b',
                            borderWidth: 2,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                new Chart(document.getElementById('chartUsuarios'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Clientes', 'Trabajadores', 'Admins'],
                        datasets: [{
                            data: [{{ $totalClientes }}, {{ $totalTrabajadores }}, {{ $totalAdmins }}],
                            backgroundColor: ['#5a1212', '#d96b2b', '#D4AF37'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 16, usePointStyle: true }
                            }
                        }
                    }
                });
            }
        });
    </script>
</div>
@endsection
