<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15HorariosIntervalosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_horarios_intervalos', function (Blueprint $table) {
            $table->increments("horario_intervalo_id");
            $table->time('inicio');
            $table->time('final');
            $table->enum('tipo', ["ENTRADA", "RETARDO_LEVE", "RETARDO_GRAVE", "SALIDA"]);
            $table->integer("horario_id");
            $table->timestamps();

            $table->foreign('horario_id')->references('horario_id')->on('p15_horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p15_horarios_intervalos');
    }
}
