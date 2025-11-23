<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaCalificacionesPsicometricos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_psicometricos', function (Blueprint $table) {
            $table->increments('calificacion_psicometrico_id');
            $table->string('lugar');
            $table->string('hora');
            $table->string('observaciones_calificacion')->nullable();
            $table->date('fecha');
            $table->timestamps();
            $table->integer('movimiento_personal_id');
            $table->integer('tipo_calificacion_psicometrico_id')->nullable();;

            $table->foreign('movimiento_personal_id')->references('movimiento_personal_id')->on('p01_movimientos_personal');
            $table->foreign('tipo_calificacion_psicometrico_id')->references('tipo_calificacion_psicometrico_id')->on('tipos_calificaciones_psicometricos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones_psicometricos');
    }
}
