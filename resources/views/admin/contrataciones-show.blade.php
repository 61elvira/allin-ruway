@extends('layouts.app')

@section('content')
<div class="admin-content-wrapper">
    <div class="admin-header-row">
        <h1 class="page-title">Contratación #{{ $contratacion->id }}</h1>
        <a href="{{ route('admin.contrataciones') }}" class="btn btn--outline btn--sm">&larr; Volver</a>
    </div>

    @if(session('success'))
        <div class="alert alert--success">{{ session('success') }}</div>
    @endif

    <div class="admin-detail-grid">
        <div class="admin-table-card">
            <h3 class="admin-table-card__title">Información general</h3>
            <div class="admin-table-card__body">
                <table class="admin-table admin-table--detail">
                    <tr><th>ID</th><td>#{{ $contratacion->id }}</td></tr>
                    <tr><th>Estado</th>
                        <td>
                            <span class="admin-status admin-status--{{ $contratacion->estado }}">
                                {{ ucfirst($contratacion->estado) }}
                            </span>
                        </td>
                    </tr>
                    <tr><th>Cliente</th><td>{{ $contratacion->cliente->name }} {{ $contratacion->cliente->apellido }} ({{ $contratacion->cliente->email }})</td></tr>
                    <tr><th>Trabajador</th><td>{{ $contratacion->trabajador->name ?? '—' }} {{ $contratacion->trabajador->apellido ?? '' }}</td></tr>
                    <tr><th>Servicio</th><td>{{ $contratacion->servicio->nombre ?? '—' }}</td></tr>
                    <tr><th>Fecha del servicio</th><td>{{ $contratacion->fecha ? \Carbon\Carbon::parse($contratacion->fecha)->format('d/m/Y') : '—' }}</td></tr>
                    <tr><th>Dirección</th><td>{{ $contratacion->direccion ?? '—' }}</td></tr>
                    <tr><th>Descripción</th><td>{{ $contratacion->descripcion ?? '—' }}</td></tr>
                    <tr><th>Creado</th><td>{{ $contratacion->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>
            </div>
        </div>

        <div class="admin-table-card">
            <h3 class="admin-table-card__title">Acciones</h3>
            <div class="admin-table-card__body" style="padding:24px">
                <form method="POST" action="{{ route('admin.contrataciones.update-estado', $contratacion) }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
                    @csrf @method('PATCH')
                    <select name="estado" class="admin-filters__select">
                        <option value="pendiente" {{ $contratacion->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aceptado" {{ $contratacion->estado == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                        <option value="rechazado" {{ $contratacion->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        <option value="finalizado" {{ $contratacion->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                    <button type="submit" class="btn btn--primary">Cambiar estado</button>
                </form>

                @if($contratacion->calificacion)
                    <hr style="margin:24px 0;border-color:var(--border)">
                    <h4 style="margin-bottom:12px">Calificación</h4>
                    <p><strong>Puntuación:</strong>
                        @for($i=1;$i<=5;$i++)
                            <span style="color:{{ $i <= $contratacion->calificacion->puntuacion ? '#D4AF37' : '#ddd' }};font-size:1.2rem">★</span>
                        @endfor
                    </p>
                    <p><strong>Comentario:</strong> {{ $contratacion->calificacion->comentario ?? 'Sin comentario' }}</p>
                    <p style="font-size:0.85rem;color:var(--text-muted)">De {{ $contratacion->calificacion->cliente->name ?? '—' }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection