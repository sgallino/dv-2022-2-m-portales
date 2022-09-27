<?php
/** @var \App\Models\Pelicula $pelicula */
?>
<div class="row mb-3">
    <div class="col-4">
{{--        @if($pelicula->portada != null && file_exists(public_path('imgs/' . $pelicula->portada)))--}}
        @if($pelicula->portada != null && Storage::disk('public')->has('imgs/' . $pelicula->portada))
            {{--<img src="{{ url('storage/imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">--}}
            <img src="{{ Storage::disk('public')->url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">
        @else
            Acá iría una imagen default.
        @endif
    </div>
    <div class="col-8">
        <dl>
            <dt>Precio</dt>
            <dd>$ {{ $pelicula->precio }}</dd>
            <dt>País de Origen</dt>
            <dd>{{ $pelicula->pais->nombre }} ({{ $pelicula->pais->abreviatura }})</dd>
            <dt>Fecha de Estreno</dt>
            <dd>{{ $pelicula->fecha_estreno }}</dd>
            <dt>Géneros</dt>
            <dd>
                @forelse($pelicula->generos as $genero)
                    <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                @empty
                    No especificado.
                @endforelse
            </dd>
        </dl>
    </div>
</div>

<h2 class="mb-3">Sinopsis</h2>

<p>{{ $pelicula->sinopsis }}</p>
