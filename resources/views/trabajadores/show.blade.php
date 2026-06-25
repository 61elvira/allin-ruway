<x-app-layout>

    <div class="worker-profile">

        <h1>
            {{ $trabajador->name }}
            {{ $trabajador->apellido }}
        </h1>

        <p>
            {{ $trabajador->especialidad }}
        </p>

        <p>
            {{ $trabajador->distrito }}
        </p>

        <p>
            {{ $trabajador->experiencia }}
        </p>

        <p>
            {{ $trabajador->descripcion }}
        </p>

    </div>

</x-app-layout>