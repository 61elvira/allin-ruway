@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <div class="admin-header-row">
        <h1 class="page-title">Usuarios</h1>
        <a href="{{ route('admin.usuarios.exportar', request()->only(['buscar', 'rol'])) }}" class="btn btn--outline btn--sm">Exportar CSV</a>
    </div>

    @if(session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert--error">{{ session('error') }}</div>
    @endif

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
                        <th>Acciones</th>
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
                            <td>
                                <div class="admin-actions">
                                    <button onclick="openRolModal({{ $u->id }}, '{{ $u->name }}', '{{ $u->rol }}')" class="btn btn--outline btn--xs">Rol</button>
                                    @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" onsubmit="return confirm('¿Eliminar a {{ $u->name }} {{ $u->apellido }}?')" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn--danger btn--xs">Eliminar</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">No se encontraron usuarios.</td>
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

{{-- Modal Cambiar Rol --}}
<div id="rolModal" class="modal-overlay" style="display:none" onclick="if(event.target===this) closeRolModal()">
    <div class="modal-content modal-content--sm">
        <div class="modal-header">
            <h3 id="rolModalTitle">Cambiar Rol</h3>
            <button type="button" class="modal-close" onclick="closeRolModal()">&times;</button>
        </div>
        <form id="rolForm" method="POST">
            @csrf @method('PATCH')
            <p style="margin-bottom:16px;color:var(--text-muted);font-size:0.9rem;" id="rolModalDesc">Usuario:</p>
            <div class="modal-field">
                <label for="rolSelect">Nuevo rol</label>
                <select name="rol" id="rolSelect" class="admin-filters__select" style="width:100%">
                    <option value="admin">Admin</option>
                    <option value="trabajador">Trabajador</option>
                    <option value="cliente">Cliente</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn" onclick="closeRolModal()">Cancelar</button>
                <button type="submit" class="btn btn--primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
var ROL_UPDATE_TEMPLATE = '{{ route('admin.usuarios.update', ['user' => '__ID__']) }}';

function openRolModal(id, name, currentRol) {
    const modal = document.getElementById('rolModal');
    const form = document.getElementById('rolForm');
    const desc = document.getElementById('rolModalDesc');
    const select = document.getElementById('rolSelect');

    form.action = ROL_UPDATE_TEMPLATE.replace('__ID__', id);
    desc.textContent = 'Usuario: ' + name;
    select.value = currentRol;
    modal.style.display = 'flex';
}

function closeRolModal() {
    document.getElementById('rolModal').style.display = 'none';
}
</script>
@endsection