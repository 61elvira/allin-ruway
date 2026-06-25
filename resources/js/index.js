document.addEventListener('DOMContentLoaded', () => {
    // Datos de ejemplo — reemplazar por una consulta real (ej: Trabajador::where('categoria', ...)->get())
    const trabajadoresPorCategoria = {
        electricistas: [
            { nombre: 'Marcelino Quispe', distrito: 'San Sebastián', calificacion: 4.8 },
            { nombre: 'Rosa Huillca', distrito: 'Wanchaq', calificacion: 4.6 },
            { nombre: 'Edwin Mamani', distrito: 'San Jerónimo', calificacion: 4.9 },
        ],
        gasfiteros: [
            { nombre: 'Juana Ccoyo', distrito: 'Cusco', calificacion: 4.7 },
            { nombre: 'Walter Sutta', distrito: 'Santiago', calificacion: 4.5 },
            { nombre: 'Lucio Apaza', distrito: 'San Sebastián', calificacion: 4.8 },
        ],
        carpinteros: [
            { nombre: 'Flor Quispe', distrito: 'Wanchaq', calificacion: 4.9 },
            { nombre: 'Hernán Vargas', distrito: 'Cusco', calificacion: 4.6 },
            { nombre: 'Inés Choque', distrito: 'San Jerónimo', calificacion: 4.7 },
        ],
    };

    const etiquetas = {
        electricistas: 'Electricistas',
        gasfiteros: 'Gasfiteros',
        carpinteros: 'Carpinteros',
    };

    const buscadorInput = document.getElementById('buscadorTrabajadores');
    const buscadorToggle = document.getElementById('buscadorToggle');
    const buscadorDropdown = document.getElementById('buscadorDropdown');
    const buscadorWrapper = document.querySelector('.buscador-input-wrapper');

    const abrirDropdown = () => {
        buscadorDropdown.classList.add('is-open');
        buscadorToggle.setAttribute('aria-expanded', 'true');
    };

    const cerrarDropdown = () => {
        buscadorDropdown.classList.remove('is-open');
        buscadorToggle.setAttribute('aria-expanded', 'false');
    };

    buscadorInput?.addEventListener('focus', abrirDropdown);

    buscadorToggle?.addEventListener('click', () => {
        buscadorDropdown.classList.contains('is-open') ? cerrarDropdown() : abrirDropdown();
    });

    document.addEventListener('click', (evento) => {
        if (buscadorWrapper && !buscadorWrapper.contains(evento.target)) {
            cerrarDropdown();
        }
    });

    document.querySelectorAll('.buscador-opcion').forEach((opcion) => {
        opcion.addEventListener('click', () => {
            const categoria = opcion.dataset.categoria;
            buscadorInput.value = etiquetas[categoria] ?? '';
            cerrarDropdown();
            abrirModalCategoria(categoria);
        });
    });

    document.querySelectorAll('.card-categoria').forEach((card) => {
        card.addEventListener('click', () => {
            abrirModalCategoria(card.dataset.categoria);
        });
    });

    const modal = document.getElementById('modalTrabajadores');
    const modalTitulo = document.getElementById('modalTitulo');
    const modalLista = document.getElementById('modalLista');
    const modalCerrar = document.getElementById('modalCerrar');

    function abrirModalCategoria(categoria) {
        const lista = trabajadoresPorCategoria[categoria] ?? [];
        modalTitulo.textContent = etiquetas[categoria] ?? 'Trabajadores';

        modalLista.innerHTML = lista.map((trabajador) => {
            const iniciales = trabajador.nombre
                .split(' ')
                .map((palabra) => palabra[0])
                .slice(0, 2)
                .join('')
                .toUpperCase();

            return `
                <div class="trabajador-item">
                    <div class="trabajador-avatar">${iniciales}</div>
                    <div class="trabajador-info">
                        <span class="trabajador-nombre">${trabajador.nombre}</span>
                        <span class="trabajador-distrito">${trabajador.distrito}</span>
                    </div>
                    <span class="trabajador-calificacion">★ ${trabajador.calificacion}</span>
                </div>
            `;
        }).join('');

        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModal() {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    modalCerrar?.addEventListener('click', cerrarModal);
    modal?.addEventListener('click', (evento) => {
        if (evento.target === modal) cerrarModal();
    });
    document.addEventListener('keydown', (evento) => {
        if (evento.key === 'Escape') cerrarModal();
    });
});