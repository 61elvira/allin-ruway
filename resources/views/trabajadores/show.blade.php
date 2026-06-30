<x-app-layout>
    <section class="worker-profile">
        <div class="profile-container">
            <!-- TARJETA IZQUIERDA -->
            <aside class="profile-card">
                <div class="worker-photo">
                    @if($trabajador->foto)
                        <img src="{{ asset('storage/' . $trabajador->foto) }}" alt="Foto">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($trabajador->name) }}" alt="Foto">
                    @endif
                </div>
                <h1>{{ $trabajador->name }} {{ $trabajador->apellido }}</h1>
                <span class="worker-specialty">{{ $trabajador->especialidad }}</span>
                <div class="profile-data">
                    <div>
                        <strong>Distrito</strong>
                        <p>{{ $trabajador->distrito }}</p>
                    </div>
                    <div>
                        <strong>Experiencia</strong>
                        <p>{{ config('allinruway.experiencias')[$trabajador->experiencia] ?? 'No especificado' }}</p>
                    </div>
                </div>
                <a href="{{ route('contrataciones.create', $trabajador->id) }}" class="hire-btn">Solicitar servicio</a>
            </aside>

            <!-- CONTENIDO DERECHO -->
            <div class="profile-content">
                <div class="content-card">
                    <h2>Sobre el trabajador</h2>
                    <p>{{ $trabajador->descripcion ?: 'Este trabajador aún no ha agregado una descripción.' }}</p>
                </div>
                <div class="content-card">
                    <h2>
                        Servicios que realiza
                    </h2>
                    <div class="services-list">
                        <span>{{ $trabajador->especialidad }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>