<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', "Confirmar la eliminación de " . $pelicula->titulo)

@section('main')
    <h1>Eliminar {{ $pelicula->titulo }}</h1>

    @include('admin.peliculas._detalle-data')

    <hr>

    <p>Estás por eliminar la siguiente película. Esta acción es (por ahora) irreversible. ¿Estás seguro/a que querés continuar?</p>

    <form action="{{ route('admin.peliculas.eliminar.accion', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <button class="btn btn-danger">Eliminar</button>
    </form>
@endsection
