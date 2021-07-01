<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique()->collation('utf8mb4_bin');
            $table->string('imagen_dni')->unique()->nullable();
            $table->string('nombre_usuario')->unique()->collation('utf8mb4_bin');
            $table->string('clave')->collation('utf8mb4_bin');
            $table->string('nombre_apellido');
            $table->string('email');
            $table->string('telefono');
            $table->string('api_token')->unique()->nullable()->collation('utf8mb4_bin');
            $table->string('curriculum_vitae')->unique()->nullable();
            $table->boolean('verificado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
