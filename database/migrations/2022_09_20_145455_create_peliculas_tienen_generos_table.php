<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas_tienen_generos', function (Blueprint $table) {
            // Vamos a crear las FKs a las tablas de películas y genéros, usando las dos formas de
            // hacerlo con Laravel: La abreviada, y la común.
            // Creamos la FK a "peliculas" con la forma abreviada.
            // Nota: Solo sirve si la PK referenciada es un UNSIGNED BIGINT.
            // El método foreignId crea el campo y la FK.
            $table->foreignId('pelicula_id')->constrained('peliculas', 'pelicula_id');

            // Creamos la FK "generos", no podemos usar esa manera abreviada porque la PK en este caso es
            // un UNSGINED TINYINT.
            $table->unsignedTinyInteger('genero_id');
            $table->foreign('genero_id')->references('genero_id')->on('generos');

            // Definimos la PK compuesta por las dos FKs.
            $table->primary(['pelicula_id', 'genero_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas_tienen_generos');
    }
};
