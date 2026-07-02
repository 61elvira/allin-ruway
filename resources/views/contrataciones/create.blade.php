<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6" style="color: var(--text);">Solicitar contratación</h1>

        <form method="POST" action="{{ route('contrataciones.store') }}" class="request-card" style="padding: 32px;">
            @csrf

            <input type="hidden" name="trabajador_id" value="{{ $trabajador->id }}">

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: var(--text);">Trabajador</label>
                <input type="text"
                       value="{{ $trabajador->name }} {{ $trabajador->apellido }}"
                       disabled
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 0.9rem; color: var(--text-muted); background: var(--bg-alt);">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: var(--text);">Servicio</label>
                <select name="servicio_id" required
                    style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 0.9rem; color: var(--text); background: var(--surface); transition: var(--transition);">
                    <option value="">Selecciona un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: var(--text);">Fecha del servicio</label>
                <input type="date" name="fecha" required
                    style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 0.9rem; color: var(--text); background: var(--surface); transition: var(--transition);">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: var(--text);">Dirección</label>
                <input type="text" name="direccion" required
                    style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 0.9rem; color: var(--text); background: var(--surface); transition: var(--transition);">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: var(--text);">Descripción (opcional)</label>
                <textarea name="descripcion"
                    style="width: 100%; min-height: 100px; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius); font-size: 0.9rem; color: var(--text); background: var(--surface); transition: var(--transition); resize: vertical;"></textarea>
            </div>

            <button style="width: 100%; padding: 14px; background: var(--accent); color: white; border: none; border-radius: var(--radius); font-weight: 600; font-size: 1rem; cursor: pointer; transition: var(--transition);">
                Enviar solicitud
            </button>
        </form>
    </div>
</x-app-layout>
