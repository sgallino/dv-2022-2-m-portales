<?php
/** @var \App\Models\Pelicula $pelicula */
?>

@extends('layouts.main')

@section('title', 'Confirmar Mayoría de Edad')

@section('main')
    <h1 class="mb-3">Confirmar Mayoría de Edad</h1>

    <p class="mb-3">La película <b>{{ $pelicula->titulo }}</b> está marcada como solo para mayores de 18 años. Para poder verla, tenés que confirmar que cumplís con la edad mínima.</p>

    <form action="{{ route('peliculas.confirmar-edad.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <a href="{{ route('admin.peliculas.index') }}" class="btn btn-danger me-2">No soy mayor de edad, ¡sacame de acá!</a>
        <button type="submit" class="btn btn-primary">Sí, soy mayor de edad</button>
    </form>
@endsection
