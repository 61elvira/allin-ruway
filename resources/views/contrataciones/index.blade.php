<x-app-layout>
    <div class="requests-container">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="requests-title">Solicitudes recibidas</h1>

        @forelse($contrataciones as $contratacion)
            <div class="request-card">
                <div class="request-header">
                    <h2>{{ $contratacion->cliente->name }} {{ $contratacion->cliente->apellido }}</h2>
                    <span class="request-status">{{ ucfirst($contratacion->estado) }}</span>
                </div>
                <div class="request-body">
                    <p><strong>Servicio:</strong> {{ $contratacion->servicio->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $contratacion->fecha }}</p>
                    <p><strong>Dirección:</strong> {{ $contratacion->direccion }}</p>
                    <p><strong>Descripción:</strong> {{ $contratacion->descripcion }}</p>
                </div>
                <div class="request-actions">
                    <form action="{{ route('contrataciones.aceptar', $contratacion->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="accept-btn">Aceptar</button>
                    </form>
                    <form action="{{ route('contrataciones.rechazar', $contratacion->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="reject-btn">Rechazar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-requests">
                <h2>No tienes solicitudes por el momento.</h2>
            </div>
        @endforelse
    </div>
</x-app-layout>