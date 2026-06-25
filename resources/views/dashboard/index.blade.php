<x-app-layout>
    <header class="dashboard-header">
        <div class="logo">
            <h1>ALLIN RUWAY</h1>
        </div>

        <div class="profile-menu">
            <a href="{{ route('profile.edit') }}">
                Mi Perfil
            </a>
        </div>
    </header>
    <section class="dashboard-hero">

        <div class="hero-content">

            <h1>ALLIN RUWAY</h1>

            <p>
                Encuentra trabajadores confiables para cualquier proyecto.
            </p>

            <form class="hero-search">

                <input type="text" placeholder="¿Qué servicio buscas?">

                <button type="submit">
                    Buscar
                </button>

            </form>

        </div>

    </section>
    <section class="categories-section">

        <h2>
            Categorías disponibles
        </h2>

        <div class="categories-grid">

            @foreach($servicios as $servicio)

                <div class="category-card">

                    {{ $servicio->nombre }}

                </div>

            @endforeach

        </div>

    </section>
    <section class="workers">

        <h3>Trabajadores destacados</h3>

        <div class="workers-grid">

            @forelse($trabajadores as $trabajador)

                <div class="worker-card">

                    <div class="worker-avatar">

                        @if($trabajador->foto)

                            <img src="{{ asset('storage/' . $trabajador->foto) }}" alt="Foto">

                        @else

                            <img src="https://ui-avatars.com/api/?name={{ urlencode($trabajador->name) }}" alt="Foto">

                        @endif

                    </div>

                    <h4>
                        {{ $trabajador->name }}
                        {{ $trabajador->apellido }}
                    </h4>

                    <p>
                        {{ $trabajador->especialidad ?? 'Sin especialidad' }}
                    </p>

                    <p>
                        {{ $trabajador->distrito ?? 'Distrito no registrado' }}
                    </p>

                    <a href="{{ route('trabajadores.show', $trabajador->id) }}">
                        Ver perfil
                    </a>

                </div>

            @empty

                <p>
                    No hay trabajadores registrados todavía.
                </p>

            @endforelse

        </div>

    </section>
</x-app-layout>