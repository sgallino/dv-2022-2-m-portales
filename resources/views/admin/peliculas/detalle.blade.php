<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.main')

@section('title', $pelicula->titulo)

@section('main')
    <h1 class="mb-3">{{ $pelicula->titulo }}</h1>

    @include('admin.peliculas._detalle-data')
@endsection
