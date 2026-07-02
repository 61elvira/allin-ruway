@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <div class="admin-header-row">
        <h1 class="page-title">Servicios</h1>
        <div class="admin-header-actions">
            <a href="{{ route('admin.servicios.exportar') }}" class="btn btn--outline btn--sm">Exportar CSV</a>
            <button onclick="openModal()" class="btn btn--primary btn--sm">+ Nuevo Servicio</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    <div class="admin-table-card">
        <div class="admin-table-card__body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Contrataciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $s)
                        <tr>
                            <td>#{{ $s->id }}</td>
                            <td><strong>{{ $s->nombre }}</strong></td>
                            <td>{{ $s->descripcion }}</td>
                            <td><span class="admin-role-badge admin-role-badge--trabajador">{{ $s->contrataciones_count }}</span></td>
                            <td>
                                <div class="admin-actions">
                                    <button onclick="openModal({{ $s->id }}, '{{ $s->nombre }}', '{{ $s->descripcion }}')" class="btn btn--outline btn--xs">Editar</button>
                                    <form action="{{ route('admin.servicios.destroy', $s) }}" method="POST" onsubmit="return confirm('¿Eliminar servicio «{{ $s->nombre }}»? Se eliminarán también las contrataciones asociadas.')" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn--danger btn--xs">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Crear/Editar Servicio --}}
<div id="servicioModal" class="modal-overlay" style="display:none" onclick="if(event.target===this) closeModal()">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Nuevo Servicio</h3>
            <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="servicioForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="modalMethod" value="POST">
            <input type="hidden" name="servicio_id" id="inputId" value="">
            <div class="modal-field">
                <label for="inputNombre">Nombre</label>
                <input type="text" name="nombre" id="inputNombre" required placeholder="Ej: Jardinería">
            </div>
            <div class="modal-field">
                <label for="inputDescripcion">Descripción</label>
                <textarea name="descripcion" id="inputDescripcion" required rows="3" placeholder="Describe el servicio..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn--primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
var EDIT_URL_TEMPLATE = '{{ route('admin.servicios.update', ['servicio' => '__ID__']) }}';
var STORE_URL = '{{ route('admin.servicios.store') }}';

function openModal(id, nombre, descripcion) {
    var modal = document.getElementById('servicioModal');
    var form = document.getElementById('servicioForm');
    var title = document.getElementById('modalTitle');
    var method = document.getElementById('modalMethod');

    if (id) {
        title.textContent = 'Editar Servicio';
        method.value = 'PATCH';
        form.action = EDIT_URL_TEMPLATE.replace('__ID__', id);
        document.getElementById('inputNombre').value = nombre;
        document.getElementById('inputDescripcion').value = descripcion;
        document.getElementById('inputId').value = id;
    } else {
        title.textContent = 'Nuevo Servicio';
        method.value = 'POST';
        form.action = STORE_URL;
        document.getElementById('inputNombre').value = '';
        document.getElementById('inputDescripcion').value = '';
        document.getElementById('inputId').value = '';
    }

    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('servicioModal').style.display = 'none';
}
</script>
@endsection