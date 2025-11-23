<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P06AreasAdscripcionTable extends Migration
{
    public function up()
    {
        Schema::create('p06_areas_adscripcion', function (Blueprint $table) {
            $table->increments('area_adscripcion_id');
            $table->string('nombre_area_adscripcion')->nullable();
            $table->string('direccion_area_adscripcion')->nullable();
            $table->boolean('activo')->default(true)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_areas_adscripcion');
    }
}
