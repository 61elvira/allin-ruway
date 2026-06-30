<x-app-layout>

    <section class="worker-profile">

        <div class="worker-profile-card">

            <div class="worker-photo">

                @if($trabajador->foto)

                    <img src="{{ asset('storage/' . $trabajador->foto) }}" alt="Foto">

                @else

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($trabajador->name) }}" alt="Foto">

                @endif

            </div>

            <div class="worker-info">

                <h1>
                    {{ $trabajador->name }}
                    {{ $trabajador->apellido }}
                </h1>

                <span class="worker-specialty">
                    {{ $trabajador->especialidad }}
                </span>

                <p>
                    📍 {{ $trabajador->distrito }}
                </p>

                <p>
                    💼 {{ $trabajador->experiencia }}
                </p>

                <div class="worker-description">

                    <h3>Sobre mí</h3>

                    <p>
                        {{ $trabajador->descripcion }}
                    </p>

                </div>

                <a href="{{ route('contrataciones.create', $trabajador->id) }}" class="hire-btn">
                    Contratar trabajador
                </a>

            </div>

        </div>

    </section>

</x-app-layout>