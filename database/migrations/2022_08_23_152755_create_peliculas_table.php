<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Este método contiene las instrucciones de lo que queremos hacer (ej: crear una tabla, agregar un
     * campo).
     *
     * @return void
     */
    public function up()
    {
        // Para el manejo del schema de la base de datos, Laravel nos ofrece la "fachada" "Schema".
        // Schema tiene entre sus métodos el método "create" que sirve para crear una tabla.
        // Recibe 2 parámetros:
        // 1. String. Nombre de la tabla.
        // 2. Closure. Función con las instrucciones para crear la tabla. A esta función le es inyectada
        //  una instancia de Blueprint por parámetro.
        //  Blueprint ("plano de construcción") es la clase que permite indicar los detalles de la tabla a
        //  crear.
        Schema::create('peliculas', function (Blueprint $table) {
            /*
             * Nuestra tabla de películas queremos que tenga los siguientes campos:
             *  pelicula_id             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PK
             *  titulo                  VARCHAR(50) NOT NULL
             *  precio                  INT UNSIGNED NOT NULL
             *  fecha_estreno           DATE NOT NULL
             *  sinopsis                TEXT NOT NULL
             *  portada                 VARCHAR(255) NULL
             *  portada_descripcion     VARCHAR(255) NULL
             */
            // Para crear una PK de tipo id, Laravel ofrece un método "shortcut" llamado "id()".
            // Ese método crea una columna de tipo "BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PK".
            // Por defecto, le pone el nombre "id". Si queremos cambiarlo, podemos pasar el nombre por
            // parámetro.
            $table->id('pelicula_id');
            // Para crear un campo VARCHAR, tenemos el método string(). Por defecto, todos los campos
            // son NOT NULL.
            $table->string('titulo', 50);
            // Para el resto de los tipos de dato, los métodos se llaman igual que los tiops correspondientes
            // en MySQL.
            // Por ejemplo, para crear un campo INT/INTEGER tenemos el método "integer" o "unsignedInteger".
            // Para un "SMALLINT", tenemos "smallInteger" o "unsignedSmallInteger", etc.
            // Van a notar que le estamos poniendo "int" (entero) al precio, lo cual puede parecer extraño.
            // Después de todo, los precios muy comúnmente pueden tener decimales.
            // El motivo por el que usamos INT (o alguna de sus variantes) en vez de DECIMAL, es para tener
            // una mayor precisión a la hora de operar aritméticamente con los valores. Las operaciones con
            // enteros son mucho más precisas que las operaciones con números flotantes (con decimales).
            // Por eso, guardamos como entero el precio, y lo guardamos en "centavos".
            $table->unsignedInteger('precio');
            $table->date('fecha_estreno');
            $table->text('sinopsis');
            // Si un campo queremos que permita el valor NULL, lo indicamos llamando al método "nullable()"
            // después del tipo de dato.
            $table->string('portada', 255)->nullable();
            $table->string('portada_descripcion', 255)->nullable();

            // Por último, vamos a ver que Laravel nos puso desde el vamos una llamada al método
            // "timestamps()".
            // Este método lo que hace es crear dos columnas de tipo TIMESTAMP llamadas "created_at" y
            // "updated_at".
            // Esas columnas son usadas por el ORM de Laravel llamado "Eloquent" (más adelante hablamos de
            // él) automáticamente, para llevar un registro de la fecha de creación de un registro, y la
            // fecha de última actualización.
            // No es obligatorio tenerlas, se pueden desactivar, pero son datos útiles de tener.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Este método contiene las instrucciones para deshacer lo que hicimos en el método "up()" (ej: borrar
     * una tabla, eliminar un campo).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
};
