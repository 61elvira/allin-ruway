<x-app-layout>
    <div class="rating-container">
        <div class="rating-card">
            <h1>Calificar trabajador</h1>
            <h2>{{ $contratacion->trabajador->name }} {{ $contratacion->trabajador->apellido }}</h2>

            <form action="{{ route('calificaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="contratacion_id" value="{{ $contratacion->id }}">
                <input type="hidden" name="trabajador_id" value="{{ $contratacion->trabajador_id }}">

                <div class="stars">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="puntuacion" value="{{ $i }}" required>
                        <label for="star{{ $i }}">★</label>
                    @endfor
                </div>

                <textarea name="comentario" rows="5" placeholder="Cuéntanos cómo fue el servicio..."></textarea>
                <button class="rating-btn">Enviar calificación</button>
            </form>
        </div>
    </div>
</x-app-layout>