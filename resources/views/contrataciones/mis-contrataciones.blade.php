<x-app-layout>
    <div class="requests-container">
        <h1 class="requests-title">Mis contrataciones</h1>

        @forelse($contrataciones as $contratacion)
            <div class="request-card">
                <div class="request-header">
                    <h2>{{ $contratacion->trabajador->name }} {{ $contratacion->trabajador->apellido }}</h2>
                    <span class="request-status">{{ ucfirst($contratacion->estado) }}</span>
                </div>
                <div class="request-body">
                    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $contratacion->fecha }}</p>
                    <p><strong>Dirección:</strong> {{ $contratacion->direccion }}</p>
                    <p><strong>Descripción:</strong> {{ $contratacion->descripcion }}</p>
                    @if($contratacion->estado == 'finalizado' && !$contratacion->calificacion)
                        <a href="{{ route('calificaciones.create', $contratacion->id) }}" class="finish-btn">
                            Calificar trabajador
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-requests">
                <h2>No tienes contrataciones.</h2>
            </div>
        @endforelse
    </div>
</x-app-layout>