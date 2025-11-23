<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('servicio_id');
            $table->string('nombre_servicio');
            $table->unsignedInteger('servicio_general_id')->nullable();
            $table->string('clave')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('servicio_general_id')->references('servicio_general_id')->on('servicios_generales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
