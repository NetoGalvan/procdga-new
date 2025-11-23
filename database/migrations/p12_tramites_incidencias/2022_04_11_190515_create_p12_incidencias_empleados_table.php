<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12IncidenciasEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_incidencias_empleados', function (Blueprint $table) {
            $table->increments("incidencia_empleado_id");
            $table->integer('tramite_incidencia_id');
            $table->integer('tramite_nota_buena_id')->nullable();
            $table->integer('tipo_captura_id');
            $table->enum('estatus', ["EN_PROCESO", "TRAMITE_SIN_COMPLETAR", "RECHAZADO_ENLACE", "RECHAZADO_ADMIN", "AUTORIZADO", "CANCELADO"]); 
            $table->string('folio_autorizacion')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('rfc');
            $table->integer('numero_empleado');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->enum('sexo', ["F", "M"]);
            $table->boolean('es_sindicalizado');
            $table->string('seccion_sindical');
            $table->integer('nomina');
            $table->integer('nivel_salarial');
            $table->string('puesto');
            $table->string('codigo_puesto');
            $table->string('codigo_universo');
            $table->string('zona_pagadora'); 
            $table->string('codigo_situacion_empleado');
            $table->string('turno'); 
            $table->string('tipo_empleado'); 
            $table->date('fecha_alta_empleado')->nullable();
            $table->string('unidad_administrativa');
            $table->string('unidad_administrativa_nombre');
            $table->integer('tipo_incidencia_id');
            $table->integer('horario_id')->nullable();
            $table->integer('horario_empleado_id')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->json('fechas')->nullable();
            $table->integer('total_dias')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('firmas')->nullable();
            $table->string('folio_cancelacion')->nullable();
            $table->string('numero_documento_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->text('firmas_cancelacion')->nullable();
            $table->timestamps();

            $table->foreign('tramite_incidencia_id')->references('tramite_incidencia_id')->on('p12_tramites_incidencias');
            $table->foreign('tramite_nota_buena_id')->references('tramite_nota_buena_id')->on('p12_tramites_notas_buenas');
            $table->foreign('tipo_captura_id')->references('tipo_captura_id')->on('p12_tipos_captura');
            $table->foreign('tipo_incidencia_id')->references('tipo_incidencia_id')->on('p12_tipos_incidencias');
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
        Schema::dropIfExists('p12_incidencias_empleados');
    }
}
