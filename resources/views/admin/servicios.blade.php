@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <h1 class="page-title">Servicios</h1>
    <div class="admin-table-card">
        <div class="admin-table-card__body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Contrataciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $s)
                        <tr>
                            <td>#{{ $s->id }}</td>
                            <td><strong>{{ $s->nombre }}</strong></td>
                            <td>{{ $s->descripcion }}</td>
                            <td><span class="admin-role-badge admin-role-badge--trabajador">{{ $s->contrataciones_count }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted);">No hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
