<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeliculasTienenGenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('peliculas_tienen_generos')->insert([
            [
                'pelicula_id' => 1,
                'genero_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 1,
                'genero_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 1,
                'genero_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 2,
                'genero_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'genero_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pelicula_id' => 3,
                'genero_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
