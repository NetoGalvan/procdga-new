<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaLugaresCitasPsicometricos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lugares_citas_psicometricos', function (Blueprint $table) {
            $table->increments('lugar_cita_psicometrico_id');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->string('extension')->nullable();
            $table->integer('dependencia_id');
            $table->timestamps();

            $table->foreign('dependencia_id')->references('dependencia_id')->on('dependencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('lugares_citas_psicometricos');
    }
}
