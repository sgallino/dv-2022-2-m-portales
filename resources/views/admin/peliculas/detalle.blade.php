<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', $pelicula->titulo)

@section('main')
    <h1 class="mb-3">{{ $pelicula->titulo }}</h1>

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
@endsection
