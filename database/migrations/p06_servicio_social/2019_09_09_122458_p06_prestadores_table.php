<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06PrestadoresTable extends Migration
{
    public function up()
    {
        Schema::create('p06_prestadores', function (Blueprint $table) {
            $table->increments('prestador_id');
            // Relación con escuela
            $table->unsignedInteger('escuela_id');
            // Relación con programa
            $table->unsignedInteger('programa_id')->nullable();
            // Relación con Entidad Federativa
            //$table->unsignedInteger('entidad_federativa_id')->nullable();

            $table->string('tipo_prestador')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('nombre_prestador')->nullable();
            $table->boolean('activo')->default(true);
            $table->bigInteger('telefono')->nullable();
            $table->string('email')->nullable();

            $table->string('carrera')->nullable();
            $table->string('matricula')->nullable();

            $table->string('calle')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('cp')->nullable();
            $table->unsignedInteger('municipio_id')->nullable();
            //$table->string('municipio_alcaldia')->nullable();
            
            //$table->string('estatus_aceptado')->nullable();
            $table->enum('estatus_prestador', [
                'EN_PROCESO', 
                'PROCESO_CANCELADO', 
                'ACEPTADO',  
                'RECHAZADO',
                'EN_CURSO', 
                'LIBERADO', 
                'BAJA', 
                'ABANDONO'
            ])->nullable();
            //$table->string('estatus_prestador')->nullable(); 
            $table->string('horario_tentativo')->nullable();     
            $table->integer('total_horas')->nullable();
            $table->string('observaciones', 50000)->nullable();
            
            $table->boolean('actualizo_funcionario_carta_termino')->default(false);
            $table->string('nombre_funcionario')->nullable();
            $table->string('puesto_funcionario')->nullable();
            $table->bigInteger('telefono_funcionario')->nullable();
            $table->timestamps();

            $table->foreign('escuela_id')->references('escuela_id')->on('p06_escuelas');
            //$table->foreign('entidad_federativa_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('programa_id')->references('programa_id')->on('p06_programas_instituciones');
            $table->foreign('municipio_id')->references('municipio_id')->on('municipios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_prestadores');
    }
}
