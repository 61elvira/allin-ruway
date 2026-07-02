@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <div class="admin-header-row">
        <h1 class="page-title">Contrataciones</h1>
        <a href="{{ route('admin.contrataciones.exportar', request()->only(['estado'])) }}" class="btn btn--outline btn--sm">Exportar CSV</a>
    </div>

    @if(session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="admin-filters">
        <select name="estado" class="admin-filters__select">
            <option value="">Todos los estados</option>
            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="aceptado" {{ request('estado') == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
        </select>
        <input type="date" name="fecha_desde" class="admin-filters__input" style="flex:0 0 auto;min-width:auto" value="{{ request('fecha_desde') }}" placeholder="Desde">
        <input type="date" name="fecha_hasta" class="admin-filters__input" style="flex:0 0 auto;min-width:auto" value="{{ request('fecha_hasta') }}" placeholder="Hasta">
        <button type="submit" class="btn btn--primary">Filtrar</button>
        @if(request()->anyFilled(['estado', 'fecha_desde', 'fecha_hasta']))
            <a href="{{ route('admin.contrataciones') }}" class="btn btn--outline">Limpiar</a>
        @endif
    </form>

    <div class="admin-table-card">
        <div class="admin-table-card__body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Trabajador</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrataciones as $c)
                        <tr>
                            <td>#{{ $c->id }}</td>
                            <td>{{ $c->cliente->name ?? '—' }}</td>
                            <td>{{ $c->trabajador->name ?? '—' }}</td>
                            <td>{{ $c->servicio->nombre ?? '—' }}</td>
                            <td>{{ $c->fecha ? \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') : '—' }}</td>
                            <td>
                                <span class="admin-status admin-status--{{ $c->estado }}">
                                    {{ ucfirst($c->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.contrataciones.show', $c) }}" class="btn btn--outline btn--xs">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">No hay contrataciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-container">
        {{ $contrataciones->links() }}
    </div>
</div>
@endsection