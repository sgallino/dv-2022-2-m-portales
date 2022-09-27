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
        Schema::create('paises', function (Blueprint $table) {
            // Para la PK vamos a usar un SMALLINT en vez de un BIGINT.
            $table->smallIncrements('pais_id');
            $table->string('nombre', 125);
            $table->char('abreviatura', 3)->comment('El código alpha-3 del país según el ISO-3166. Ej: ARG, BRA.');
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
        Schema::dropIfExists('paises');
    }
};
