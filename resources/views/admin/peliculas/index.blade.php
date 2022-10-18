<?php
// Es una práctica común querer documentar con phpDoc en la vista qué variables van a estar disponibles,
// siendo inyectadas desde el controller.
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
/** @var array $searchParams */
?>
@extends('layouts.main')

@section('title', 'Administrar Películas')

@section('main')
    <h1 class="mb-3">Administrar películas</h1>

    <div class="mb-3">
        {{-- Incluimos la URL de la ruta a partir del nombre asociado a ella, con la función route(). --}}
        <a href="{{ route('admin.peliculas.nueva.form') }}">Crear una nueva película</a>
        <a href="{{ route('admin.peliculas.papelera') }}">Ver películas eliminadas</a>
    </div>

    <section class="mb-5">
        <h2 class="mb-2">Buscar</h2>

        <form action="{{ route('admin.peliculas.index') }}" method="get">
            <div class="mb-2">
                <label for="b-titulo" class="form-label">Título</label>
                <input type="search" id="b-titulo" name="titulo" class="form-control" value="{{ $searchParams['titulo'] ?? '' }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </section>

    @if($searchParams['titulo'])
        <p class="mb-3">Mostrando las películas con títulos que contengan el término '<b>{{ $searchParams['titulo'] }}</b>'</p>
    @endif

    <table class="table table-bordered table-striped mb-3">
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
                    <a href="{{ route('admin.peliculas.detalle', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary mb-2">Ver</a>
                    <a href="{{ route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-secondary mb-2">Editar</a>
                    <a href="{{ route('admin.peliculas.eliminar.confirmar', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-danger mb-2">Eliminar</a>
                    <form action="{{ route('peliculas.reservar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-warning">Reservar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $peliculas->links() }}
@endsection
