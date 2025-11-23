<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposPartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_partidas', function (Blueprint $table) {
            $table->increments('tipo_partida_id');
            $table->string('nombre');
            $table->string('identificador');
            $table->integer('numero');
            $table->text('descripcion');
            $table->integer('tipo_ambito_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('tipo_ambito_id')->references('tipo_ambito_id')->on('tipos_ambitos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_partidas');
    }
}
