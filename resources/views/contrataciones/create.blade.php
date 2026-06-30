<x-app-layout>

    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Solicitar contratación
        </h1>

        <form method="POST" action="{{ route('contrataciones.store') }}" class="space-y-4">
            @csrf

            <!-- Trabajador -->
            <input type="hidden" name="trabajador_id" value="{{ $trabajador->id }}">

            <div>
                <label>Trabajador</label>
                <input type="text"
                       value="{{ $trabajador->name }} {{ $trabajador->apellido }}"
                       disabled
                       class="w-full border rounded p-2">
            </div>

            <!-- Servicio -->
            <div>
                <label>Servicio</label>
                <select name="servicio_id" class="w-full border rounded p-2" required>
                    <option value="">Selecciona un servicio</option>

                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Fecha -->
            <div>
                <label>Fecha del servicio</label>
                <input type="date" name="fecha" class="w-full border rounded p-2" required>
            </div>

            <!-- Dirección -->
            <div>
                <label>Dirección</label>
                <input type="text" name="direccion" class="w-full border rounded p-2" required>
            </div>

            <!-- Descripción -->
            <div>
                <label>Descripción (opcional)</label>
                <textarea name="descripcion" class="w-full border rounded p-2"></textarea>
            </div>

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Enviar solicitud
            </button>

        </form>

    </div>

</x-app-layout>