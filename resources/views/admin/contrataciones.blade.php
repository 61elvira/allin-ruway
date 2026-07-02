@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <h1 class="page-title">Contrataciones</h1>
    <form method="GET" class="admin-filters">
        <select name="estado" class="admin-filters__select">
            <option value="">Todos los estados</option>
            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="aceptado" {{ request('estado') == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
        </select>
        <button type="submit" class="btn btn--primary">Filtrar</button>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">No hay contrataciones.</td>
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
