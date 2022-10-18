<?php
// Es una práctica común querer documentar con phpDoc en la vista qué variables van a estar disponibles,
// siendo inyectadas desde el controller.
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
?>
@extends('layouts.main')

@section('title', 'Administrar Películas Eliminadas')

@section('main')
    <h1 class="mb-3">Administrar películas eliminadas</h1>

    <div class="mb-3">
        <a href="{{ route('admin.peliculas.index') }}">Volver al administrador</a>
    </div>

    @if($peliculas->isEmpty())
        <p>No hay películas eliminadas :D</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Precio</th>
                <th>País</th>
                <th>Géneros</th>
                <th>Categoría</th>
                <th>Fecha de estreno</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($peliculas as $pelicula)
                <tr>
                    <td>{{ $pelicula->pelicula_id }}</td>
                    <td>{{ $pelicula->titulo }}</td>
                    <td>$ {{ $pelicula->precio }}</td>
                    <td>{{ $pelicula->pais->abreviatura }}</td>
                    <td>
                        {{-- Usamos el método de las Collections de Laravel "isNotEmpty" para verificar que haya géneros. --}}
                        {{--@if($pelicula->generos->isNotEmpty())
                            @foreach($pelicula->generos as $genero)
                                <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                            @endforeach
                        @else
                            No especificado.
                        @endif--}}
                        {{-- Rescribiendo lo anterior con el bucle @forelse de Blade --}}
                        @forelse($pelicula->generos as $genero)
                            <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                        @empty
                            No especificado.
                        @endforelse
                    </td>
                    <td>{{ $pelicula->categoria->abreviatura }}</td>
                    <td>{{ $pelicula->fecha_estreno }}</td>
                    <td>
                        {{-- Los parámetros de las rutas se pasan con el segundo parámetro de route(). --}}
                        {{--<a href="{{ route('admin.peliculas.detalle', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary mb-2">Ver</a>--}}
                        <form action="{{ route('admin.peliculas.restablecer.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Restablecer</button>
                        </form>
                        <a href="{{ route('admin.peliculas.eliminar.confirmar', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-danger mb-2">Eliminar Permanentemente (TODO)</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
