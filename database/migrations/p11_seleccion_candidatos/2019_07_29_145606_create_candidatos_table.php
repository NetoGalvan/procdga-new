<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        Schema::create('p11_candidatos', function (Blueprint $table) {
            $table->increments('candidato_id')->unique();
            $table->integer('seleccion_candidato_id')->unique();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->integer('numero_empleado')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('sexo_id')->nullable();
            $table->integer('estado_civil_id')->nullable();
            $table->integer('nivel_estudio_id')->nullable();
            $table->timestamps();

            $table->foreign('seleccion_candidato_id')->references('seleccion_candidato_id')->on('p11_seleccion_candidatos');
            $table->foreign('sexo_id')->references('sexo_id')->on('sexos');
            $table->foreign('estado_civil_id')->references('estado_civil_id')->on('estados_civiles');
            $table->foreign('nivel_estudio_id')->references('nivel_estudio_id')->on('niveles_estudios');
            
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
        Schema::dropIfExists('p11_candidatos');
    }
}
