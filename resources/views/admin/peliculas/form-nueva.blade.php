@extends('layouts.main')

@section('title', 'Agregar una nueva película')

@section('main')
    <h1 class="mb-3">Agregar una nueva película</h1>

    <p class="mb-3">Completá los datos del formulario con la información de la película, y dale a "Publicar".</p>

    <form action="{{ route('admin.peliculas.nueva.grabar') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control">
        </div>
        <div class="mb-3">
            <label for="fecha_estreno" class="form-label">Fecha de estreno</label>
            <input type="date" id="fecha_estreno" name="fecha_estreno" class="form-control">
        </div>
        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada <span class="small">(opcional)</span></label>
            <input type="file" id="portada" name="portada" class="form-control">
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada <span class="small">(opcional)</span></label>
            <input type="text" id="portada_descripcion" name="portada_descripcion" class="form-control">
        </div>
        <button class="btn btn-primary" type="submit">Publicar</button>
    </form>
@endsection
