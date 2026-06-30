<x-app-layout>
    <div class="requests-container">
        <h1 class="requests-title">Historial de trabajos</h1>

        @forelse($contrataciones as $contratacion)
            <div class="request-card">
                <div class="request-header">
                    <h2>{{ $contratacion->cliente->name }} {{ $contratacion->cliente->apellido }}</h2>
                    <span class="request-status">Finalizado</span>
                </div>
                <div class="request-body">
                    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $contratacion->fecha }}</p>
                    <p><strong>Dirección:</strong> {{ $contratacion->direccion }}</p>
                    <p><strong>Descripción:</strong> {{ $contratacion->descripcion }}</p>
                </div>
            </div>
        @empty
            <div class="empty-requests">
                <h2>No tienes trabajos finalizados.</h2>
            </div>
        @endforelse
    </div>
</x-app-layout>