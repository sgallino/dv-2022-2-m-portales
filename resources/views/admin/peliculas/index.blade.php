<?php
// Es una práctica común querer documentar con phpDoc en la vista qué variables van a estar disponibles,
// siendo inyectadas desde el controller.
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
?>
@extends('layouts.main')

@section('title', 'Administrar Películas')

@section('main')
    <h1 class="mb-3">Administrar películas</h1>

    <div class="mb-3">
        {{-- Incluimos la URL de la ruta a partir del nombre asociado a ella, con la función route(). --}}
        <a href="{{ route('admin.peliculas.nueva.form') }}">Crear una nueva película</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Precio</th>
            <th>País</th>
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
                <td>{{ $pelicula->fecha_estreno }}</td>
                <td>
                    {{-- Los parámetros de las rutas se pasan con el segundo parámetro de route(). --}}
                    <a href="{{ route('admin.peliculas.detalle', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-secondary">Editar</a>
                    <a href="{{ route('admin.peliculas.eliminar.confirmar', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
