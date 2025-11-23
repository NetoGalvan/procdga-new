<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06ProgramasInstitucionesTable extends Migration
{
    public function up()
    {
        Schema::create('p06_programas_instituciones', function (Blueprint $table) {
            $table->increments('programa_id');
            $table->unsignedInteger('institucion_id')->nullable();
            $table->string('nombre_programa')->nullable();
            $table->string('clave_programa')->nullable();
            $table->boolean('activo')->default(true)->nullable();
            $table->timestamps();

            $table->foreign('institucion_id')->references('institucion_id')->on('p06_instituciones');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_programas_instituciones');
    }
}
