<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    // HasFactory sirve si definimos una clase "Factory" asociada, que son útiles para fines de testing.
    // Como no vamos a estar usando testing por ahora, la podemos comentar.
//    use HasFactory;

    // Por defecto, Laravel supone que el nombre de la tabla asociada al modelo es el mismo nombre que la
    // clase, en minúsculas y en plural (del inglés).
    // Si queremos indicar a mano el nombre de la tabla, solamente tenemos que definir la propiedad
    // $table.
    protected $table = 'peliculas';

    // Por defecto, Laravel supone que la PK de la tabla se llama "id". De no ser así, lo podemos indicar
    // con la propiedad $primaryKey.
    protected $primaryKey = 'pelicula_id';

    // Definimos la lista "blanca" de las propiedades que aceptamos nos cargue de manera masiva cuando hacemos
    // un create/update con Eloquent.
    protected $fillable = ['titulo', 'precio', 'fecha_estreno', 'sinopsis', 'portada', 'portada_descripcion'];
}
