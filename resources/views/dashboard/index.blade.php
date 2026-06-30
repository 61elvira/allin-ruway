<x-app-layout>
    <section class="dashboard-hero">
        <div class="hero-content">
            <h1>ALLIN RUWAY</h1>
            <p>Encuentra trabajadores confiables para cualquier proyecto.</p>
            <form action="{{ route('dashboard') }}" method="get" class="hero-search">
                <input type="text" name="buscar" placeholder="¿Qué servicio buscas?" value="{{ request('buscar') }}">
                <button type="submit">Buscar</button>
            </form>
        </div>
    </section>

    @if (!request()->filled('buscar'))
        <section class="categories-section">

        <h2>Categorías disponibles</h2>

        <div class="categories-grid">

            @foreach($servicios as $servicio)

                <a href="{{ route('trabajadores.index', ['servicio' => $servicio->id]) }}"class="category-card">

                    <div class="category-icon">

                        @switch($servicio->nombre)

                            @case('Electricista')
                                ⚡
                                @break

                            @case('Carpintero')
                                🪚
                                @break

                            @case('Gasfitero')
                                🚰
                                @break

                            @default
                                🛠️

                        @endswitch

                    </div>

                    <h3>{{ $servicio->nombre }}</h3>

                    <p>{{ $servicio->descripcion }}</p>

                </a>

            @endforeach

        </div>

        </section>
    @endif

    <section class="workers">
        @if(request()->filled('buscar'))

        <h3>
            Se encontraron {{ $trabajadores->total() }}
            resultado(s) para "{{ request('buscar') }}"
        </h3>

        @else

        <h3>
            Trabajadores destacados
        </h3>
        @endif
        <div class="workers-grid">
            @forelse($trabajadores as $trabajador)
                <div class="worker-card">
                    <div class="worker-avatar">
                        @if($trabajador->foto)
                            <img src="{{ asset('storage/' . $trabajador->foto) }}" alt="Foto de {{ $trabajador->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($trabajador->name) }}"
                                alt="Avatar de {{ $trabajador->name }}">
                        @endif
                    </div>
                    <h4>{{ $trabajador->name }} {{ $trabajador->apellido }}</h4>
                    <p>{{ $trabajador->especialidad ?? 'Sin especialidad' }}</p>
                    <p>{{ $trabajador->distrito ?? 'Distrito no registrado' }}</p>
                    <a href="{{ route('trabajadores.show', $trabajador->id) }}">Ver perfil</a>
                </div>
            @empty
                <p>No hay trabajadores registrados todavía.</p>
            @endforelse
        </div>
        <div class="pagination-container">

            {{ $trabajadores->links() }}

        </div>
    </section>
    @if(request()->filled('buscar'))

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.workers').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>

    @endif
</x-app-layout>