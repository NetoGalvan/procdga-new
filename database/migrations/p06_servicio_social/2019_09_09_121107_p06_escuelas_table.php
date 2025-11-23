<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06EscuelasTable extends Migration
{

    public function up()
    {
        Schema::create('p06_escuelas', function (Blueprint $table) {
            $table->increments('escuela_id');
            $table->unsignedInteger('institucion_id')->nullable();
            $table->string('nombre_escuela')->nullable();
            $table->string('acronimo_escuela')->nullable();
            $table->string('direccion_escuela')->nullable();
            $table->boolean('activo')->default(true)->nullable();
            $table->timestamps();

            $table->foreign('institucion_id')->references('institucion_id')->on('p06_instituciones');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_escuelas');
    }
}
