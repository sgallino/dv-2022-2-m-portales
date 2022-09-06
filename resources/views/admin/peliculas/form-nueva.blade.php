<?php
// Todas las vistas de Blade en Laravel reciben automáticamente una variable "$errors" que contiene los
// mensajes de error de validación, si es que hubo alguno.
// Al existir siempre, no necesitamos estar preguntando si la variable existe a la hora de usarla.
/** @var \Illuminate\Support\ViewErrorBag $errors */
?>
@extends('layouts.main')

@section('title', 'Agregar una nueva película')

@section('main')
    <h1 class="mb-3">Agregar una nueva película</h1>

    <p class="mb-3">Completá los datos del formulario con la información de la película, y dale a "Publicar".</p>

    @if($errors->any())
        <p class="mb-3 text-danger">Hay errores de validación en el formulario. Por favor, revisá los datos e intentá de nuevo.</p>
    @endif

    <form action="{{ route('admin.peliculas.nueva.grabar') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                class="form-control"
                value="{{ old('titulo') }}"
                @if($errors->has('titulo')) aria-describedby="error-titulo" @endif
            >
            {{-- Preguntamos si existe errores para esta key, en cuyo caso lo imprimimos. --}}
            @if($errors->has('titulo'))
                <p class="text-danger" id="error-titulo">{{ $errors->first('titulo') }}</p>
            @endif
        </div>
        <div class="mb-3">
            {{-- Como usar esas condiciones para los errores es algo muy común, Blade tiene una directiva
             para facilitar ese chequeo: @error --}}
            <label for="precio" class="form-label">Precio</label>
            <input
                type="text"
                id="precio"
                name="precio"
                class="form-control"
                value="{{ old('precio') }}"
                @error('precio') aria-describedby="error-precio" @enderror
            >
            @error('precio')
                {{-- Dentro de la directiva error, Laravel provee de una varible "$message" con el primer
                 mensaje de error. --}}
                <p class="text-danger" id="error-precio">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fecha_estreno" class="form-label">Fecha de estreno</label>
            <input
                type="date"
                id="fecha_estreno"
                name="fecha_estreno"
                class="form-control"
                value="{{ old('fecha_estreno') }}"
                @error('fecha_estreno') aria-describedby="error-fecha_estreno" @enderror
            >
            @error('fecha_estreno')
            <p class="text-danger" id="error-fecha_estreno">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea
                id="sinopsis"
                name="sinopsis"
                class="form-control"
            >{{ old('sinopsis') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada <span class="small">(opcional)</span></label>
            <input
                type="file"
                id="portada"
                name="portada"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada <span class="small">(opcional)</span></label>
            <input
                type="text"
                id="portada_descripcion"
                name="portada_descripcion"
                class="form-control"
                value="{{ old('portada_descripcion') }}"
            >
        </div>
        <button class="btn btn-primary" type="submit">Publicar</button>
    </form>
@endsection
