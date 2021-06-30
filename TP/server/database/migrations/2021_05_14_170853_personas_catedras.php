<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonasCatedras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas_catedras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_catedra');

            $table->unique(['id_persona', 'id_catedra']);

            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_catedra')->references('id')->on('catedras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas_catedras');
    }
}
