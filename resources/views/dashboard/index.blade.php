<x-app-layout>
    <div class="dashboard-page">

        {{-- Topbar: logo + CTA --}}
        <div class="dashboard-topbar">
            <a href="{{ route('dashboard') }}" class="dashboard-logo">
                <span class="logo-allin">Allin</span><span class="logo-ruway">Ruway</span>
            </a>

            @php
                $esCliente = auth()->user()->role === 'cliente';
            @endphp

            @if($esCliente)
                {{-- TODO: cambia este href por tu ruta real, ej: route('trabajador.registro') --}}
                <a href="#" class="btn-convertirte">
                    Convertirte en trabajador
                </a>
            @endif
        </div>

        <div class="greca-strip"></div>

        <div class="dashboard-wrapper">

            {{-- Saludo --}}
            <div class="dashboard-saludo">
                <span class="saludo-nombre">{{ auth()->user()->name }}</span>
                <span class="saludo-divisor">·</span>
                <span class="saludo-pregunta">¿Qué necesitas hoy?</span>
            </div>

            {{-- Buscador con dropdown de categorías --}}
            <div class="dashboard-buscador">
                <div class="buscador-input-wrapper">
                    <i class="icono-lupa" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </i>

                    <input
                        type="text"
                        id="buscadorTrabajadores"
                        class="buscador-input"
                        placeholder="Busca un servicio o tipo de trabajador..."
                        autocomplete="off"
                    >

                    <button type="button" class="buscador-toggle" id="buscadorToggle" aria-label="Mostrar categorías" aria-expanded="false">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <div class="buscador-dropdown" id="buscadorDropdown">
                        <button type="button" class="buscador-opcion" data-categoria="electricistas">
                            <span class="opcion-icono opcion-icono--electricidad">
    <img src="{{ asset('imagenes/electricidad.jpg') }}" alt="Electricistas">
</span>
                            Electricistas
                        </button>
                        <button type="button" class="buscador-opcion" data-categoria="gasfiteros">
                            <span class="opcion-icono opcion-icono--gasfiteria">
    <img src="{{ asset('imagenes/gasfiteria.jpg') }}" alt="Gasfiteros">
</span>
                            Gasfiteros
                        </button>
                        <button type="button" class="buscador-opcion" data-categoria="carpinteros">
                            <span class="opcion-icono opcion-icono--carpinteria">
    <img src="{{ asset('imagenes/carpinteria.jpg') }}" alt="Carpinteros">
</span>
                            Carpinteros
                        </button>
                    </div>
                </div>
            </div>

            {{-- Trabajadores destacados --}}
            <section class="destacados">
                <h2 class="destacados-titulo">Trabajadores destacados</h2>

                <div class="destacados-grid">
                    <button type="button" class="card-categoria" data-categoria="electricistas">
                        <span class="card-icono card-icono--electricidad">
    <img src="{{ asset('imagenes/electricidad.jpg') }}" alt="Electricistas">
</span>
                        <h3>Electricistas</h3>
                        <p>Instalaciones, mantenimiento y reparaciones eléctricas</p>
                    </button>

                    <button type="button" class="card-categoria" data-categoria="gasfiteros">
                        <span class="card-icono card-icono--gasfiteria">
    <img src="{{ asset('imagenes/gasfiteria.jpg') }}" alt="Gasfiteros">
</span>
                        <h3>Gasfiteros</h3>
                        <p>Tuberías, fugas e instalaciones sanitarias</p>
                    </button>

                    <button type="button" class="card-categoria" data-categoria="carpinteros">
                        <span class="card-icono card-icono--carpinteria">
    <img src="{{ asset('imagenes/carpinteria.webp') }}" alt="Carpinteros">
</span>
                        <h3>Carpinteros</h3>
                        <p>Muebles, estructuras de madera y acabados</p>
                    </button>
                </div>
            </section>
        </div>
    </div>

    {{-- Modal de trabajadores por categoría --}}
    <div class="modal-overlay" id="modalTrabajadores">
        <div class="modal-contenido" role="dialog" aria-modal="true" aria-labelledby="modalTitulo">
            <button type="button" class="modal-cerrar" id="modalCerrar" aria-label="Cerrar">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <h3 class="modal-titulo" id="modalTitulo">Electricistas</h3>
            <div class="modal-lista" id="modalLista"></div>
        </div>
    </div>
</x-app-layout>