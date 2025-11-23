<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('empleado_id');
            $table->unsignedInteger('plaza_id')->nullable();
            $table->string('sector')->nullable();
            $table->integer('numero_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre')->nullable();
            $table->text('nombre_completo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->text('unidad_administrativa_nombre')->nullable();
            $table->string('subunidad')->nullable();
            $table->string('direccion_administrativa')->nullable();
            $table->string('subdireccion')->nullable();
            $table->string('jud')->nullable();
            $table->string('oficina')->nullable();
            $table->integer('nomina')->nullable();
            $table->string('codigo_universo')->nullable();
            $table->integer('nivel_salarial')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->text('puesto')->nullable();
            $table->string('seccion_sindical')->nullable();
            $table->string('codigo_situacion_empleado')->nullable();
            $table->string('numero_plaza')->nullable();
            $table->string('fecha_alta_empleado')->nullable();
            $table->string('fecha_antiguedad')->nullable();
            $table->string('codigo_turno')->nullable();
            $table->string('zona_pagadora')->nullable();
            $table->string('ssn')->nullable();
            $table->string('dias_trabajados')->nullable();
            $table->text('codigo_regimen_issste')->nullable();
            $table->string('acct_no')->nullable();
            $table->text('banco')->nullable();
            $table->string('sueldo_bruto')->nullable();
            $table->string('deducciones')->nullable();
            $table->string('sueldo_neto')->nullable();
            $table->string('hijos')->nullable();
            $table->boolean('activo')->default(false);
            $table->json("quincenas_activo")->nullable();
            $table->integer('area_id')->nullable();
            $table->timestamps();

            $table->foreign('plaza_id')->references('plaza_id')->on('plazas');
            $table->foreign('area_id')->references('area_id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
