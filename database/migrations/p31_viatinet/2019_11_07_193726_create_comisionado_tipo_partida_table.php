<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionadoTipoPartidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p31_comisionado_tipo_partida', function (Blueprint $table) {
            $table->increments('comisionado_partida_id');
            $table->integer('tipo_partida_id');
            $table->integer('comisionado_id');
            $table->decimal('importe', 13, 2);
            $table->string('origen_inicial')->nullable();
            $table->string('destino')->nullable();
            $table->string('origen_final')->nullable();
            $table->string('servicios')->nullable();
            $table->timestamps();

            $table->foreign('tipo_partida_id')->references('tipo_partida_id')->on('tipos_partidas');
            $table->foreign('comisionado_id')->references('comisionado_id')->on('p31_comisionados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p31_comisionado_tipo_partida');
    }
}
