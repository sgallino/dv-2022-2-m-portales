<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Para interactuar con los contenidos de las tablas en la base de datos, Laravel utiliza lo que
        // se llama el "Query Builder".
        // Para acceder al Query Builder, usamos la "fachada" DB.
        // El método "table" nos permite definir para qué tabla queremos armar el query.
        DB::table('peliculas')->insert([
            [
                'pelicula_id' => 1,
                'titulo' => 'El Señor de la Anillos: La Comunidad del Anillo',
                'precio' => 1999,
                'fecha_estreno' => '2000-01-11',
                'sinopsis' => '"Throw it into the fire, Mr. Frodo!"',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'titulo' => 'El Discurso del Rey',
                'precio' => 1799,
                'fecha_estreno' => '2015-11-20',
                'sinopsis' => '"I have a voice!"',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'titulo' => 'La Matrix',
                'precio' => 2099,
                'fecha_estreno' => '1998-06-04',
                'sinopsis' => '"I know kung fu!"',
                'portada' => null,
                'portada_descripcion' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
