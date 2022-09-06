<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', $pelicula->titulo)

@section('main')
    <h1>Eliminar {{ $pelicula->titulo }}</h1>

    <div class="row mb-3">
        <div class="col-4">Acá va a ir a la imagen</div>
        <div class="col-8">
            <dl>
                <dt>Precio</dt>
                <dd>$ {{ $pelicula->precio }}</dd>
                <dt>Fecha de Estreno</dt>
                <dd>{{ $pelicula->fecha_estreno }}</dd>
            </dl>
        </div>
    </div>

    <h2 class="mb-3">Sinopsis</h2>

    <p>{{ $pelicula->sinopsis }}</p>

    <hr>

    <p>Estás por eliminar la siguiente película. Esta acción es (por ahora) irreversible. ¿Estás seguro/a que querés continuar?</p>

    <form action="{{ route('admin.peliculas.eliminar.accion', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <button class="btn btn-danger">Eliminar</button>
    </form>
@endsection
