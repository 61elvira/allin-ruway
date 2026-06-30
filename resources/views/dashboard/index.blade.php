<x-app-layout>
    <section class="dashboard-hero">
        <div class="hero-content">
            <h1>ALLIN RUWAY</h1>
            <p>Encuentra trabajadores confiables para cualquier proyecto.</p>
            <form id="filtroDashboard" action="{{ route('dashboard') }}" method="GET" class="hero-search">
                <input type="text" name="buscar" placeholder="¿Qué servicio buscas?" value="{{ request('buscar') }}">
                <button type="submit" class="search-btn">Buscar</button>
                <button type="button" id="toggleFilters" class="filter-btn">Filtros</button>
            </form>
            <div id="filtersPanel" class="filters-panel">
                <select name="especialidad" form="filtroDashboard">
                    <option value="">Especialidad</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->nombre }}" {{ request('especialidad') == $servicio->nombre ? 'selected' : '' }}>{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
                <select name="distrito" form="filtroDashboard">
                    <option value="">Distrito</option>
                    @foreach(config('allinruway.distritos') as $distrito)
                        <option value="{{ $distrito }}" {{ request('distrito') == $distrito ? 'selected' : '' }}>{{ $distrito }}</option>
                    @endforeach
                </select>
                <select name="experiencia" form="filtroDashboard">
                    <option value="">Experiencia</option>
                    @foreach(config('allinruway.experiencias') as $valor => $texto)
                        <option value="{{ $valor }}" {{ request('experiencia') == $valor ? 'selected' : '' }}>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    @if(!$filtrosActivos)
        <section class="categories-section">
            <h2>Categorías disponibles</h2>
            <div class="categories-grid">
                @foreach($servicios as $servicio)
                    <a href="{{ route('trabajadores.index', ['servicio' => $servicio->id]) }}" class="category-card">
                        <div class="category-icon">
                            @switch($servicio->nombre)
                                @case('Electricista') ⚡ @break
                                @case('Carpintero') 🪚 @break
                                @case('Gasfitero') 🚰 @break
                                @default 🛠️
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
        @if($filtrosActivos)
            <h3>Se encontraron {{ $trabajadores->total() }} resultado(s) para "{{ request('buscar') }}"</h3>
        @else
            <h3>Trabajadores destacados</h3>
        @endif
        <div class="workers-grid">
            @forelse($trabajadores as $trabajador)
                <div class="worker-card">
                    <div class="worker-avatar">
                        @if($trabajador->foto)
                            <img src="{{ asset('storage/' . $trabajador->foto) }}" alt="Foto de {{ $trabajador->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($trabajador->name) }}" alt="Avatar de {{ $trabajador->name }}">
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

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const boton = document.getElementById('toggleFilters');
        const panel = document.getElementById('filtersPanel');

        boton.addEventListener('click', () => {
            panel.classList.toggle('active');
        });

        @if($filtrosActivos)

        document.querySelector('.workers').scrollIntoView({
            behavior: 'smooth'
        });

        @endif

    });
    </script>
</x-app-layout>
