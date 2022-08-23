{{-- "Heredamos/extendemos" el layout que definimos en [layouts/main.blade.php] con ayuda de la directiva
@extends().
Noten que para indicar el layout pasamos como parámetro al @extends un string con la ruta, pero reemplazando
las "/" con ".", y omitiendo las extensiones (".blade.php").
--}}
@extends('layouts.main')

{{--@section('title') Página principal @endsection--}}
@section('title', 'Página principal')

{{-- Por defecto, cualquier contenido que este archivo tenga luego de un @extends va a imprimirse _antes_
del contenido del archivo extendido. Por ejemplo, antes de lo que sería el <!doctype html>.
Ahí es donde entra en juego la directiva @yield que pusimos en el template.
Como dijimos en el layout, @yield define un espacio que es cedido para que las vistas que hereden el
template puedan usar para imprimir su contenido.
Para usarlo, debemos ayudarnos con las directivas
    @section(name)
        ...
    @endsection
Donde "name" sería el nombre que definió el @yield().
--}}
@section('main')
    <h1>Hola</h1>
@endsection
