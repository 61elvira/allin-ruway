<x-app-layout>
    <div class="requests-container">
        <h1 class="requests-title">Mis trabajos</h1>

        @forelse($contrataciones as $contratacion)
            <div class="request-card">
                <div class="request-header">
                    <h2>{{ $contratacion->cliente->name }} {{ $contratacion->cliente->apellido }}</h2>
                    <span class="request-status">Aceptado</span>
                </div>
                <div class="request-body">
                    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $contratacion->fecha }}</p>
                    <p><strong>Dirección:</strong> {{ $contratacion->direccion }}</p>
                    <p><strong>Descripción:</strong> {{ $contratacion->descripcion }}</p>
                    <div class="request-actions">
                        <form action="{{ route('contrataciones.finalizar', $contratacion->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="finish-btn">Marcar como terminado</button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="empty-requests">
                <h2>No tienes trabajos aceptados.</h2>
            </div>
        @endforelse
    </div>
</x-app-layout>