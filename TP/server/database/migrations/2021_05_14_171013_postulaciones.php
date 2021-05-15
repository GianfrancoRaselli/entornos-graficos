<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Postulaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->string('curriculum_vitae');
            $table->string('estado');
            $table->integer('puntaje')->nullable();
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_llamado');
            
            $table->unique(['id_persona', 'id_llamado']);

            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_llamado')->references('id')->on('llamados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulaciones');
    }
}
