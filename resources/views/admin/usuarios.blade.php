@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <h1 class="page-title">Usuarios</h1>
    <form method="GET" class="admin-filters">
        <input type="text" name="buscar" placeholder="Buscar por nombre o email..." value="{{ request('buscar') }}" class="admin-filters__input">
        <select name="rol" class="admin-filters__select">
            <option value="">Todos los roles</option>
            <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="trabajador" {{ request('rol') == 'trabajador' ? 'selected' : '' }}>Trabajador</option>
            <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
        </select>
        <button type="submit" class="btn btn--primary">Filtrar</button>
    </form>

    <div class="admin-table-card">
        <div class="admin-table-card__body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Distrito</th>
                        <th>Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $u)
                        <tr>
                            <td>#{{ $u->id }}</td>
                            <td>{{ $u->name }} {{ $u->apellido }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <span class="admin-role-badge admin-role-badge--{{ $u->rol }}">
                                    {{ ucfirst($u->rol) }}
                                </span>
                            </td>
                            <td>{{ $u->distrito ?? '—' }}</td>
                            <td>{{ $u->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">No se encontraron usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-container">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
