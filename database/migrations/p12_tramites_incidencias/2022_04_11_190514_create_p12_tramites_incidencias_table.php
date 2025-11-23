<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12TramitesIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_tramites_incidencias', function (Blueprint $table) {
            $table->increments('tramite_incidencia_id');
            $table->integer('tramite_incidencia_asociado_id')->nullable();
            $table->json('tramite_incidencia_asociado_historico')->nullable();
            $table->string('tramite_incidencia_asociado_historico_folio')->nullable();
            $table->enum('tipo_tramite', ["AUTOINCIDENCIA", "INCIDENCIA_INDIVIDUAL", "INCIDENCIA_INDIVIDUAL_ADMIN", "INCIDENCIA_GRUPAL"]);
            $table->integer('tipo_captura_id')->nullable();
            $table->enum('tipo_cancelacion', ["TOTAL", "PARCIAL"])->nullable();
            $table->string('folio')->nullable();
            $table->enum('estatus', ["EN_PROCESO", "COMPLETADO", "CANCELADO", "RECHAZADO"])->nullable(); 
            $table->integer('area_id')->nullable();
            $table->string('numero_documento')->nullable();
            $table->json('empleados')->nullable();
            $table->string('rfc')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->enum('sexo', ["F", "M"])->nullable();
            $table->boolean('es_sindicalizado')->nullable();
            $table->string('seccion_sindical')->nullable();
            $table->integer('nomina')->nullable();
            $table->integer('nivel_salarial')->nullable();
            $table->string('puesto')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('zona_pagadora')->nullable(); 
            $table->string('codigo_universo')->nullable();
            $table->string('codigo_situacion_empleado')->nullable();
            $table->string('turno')->nullable(); 
            $table->string('tipo_empleado')->nullable(); 
            $table->date('fecha_alta_empleado')->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->string('unidad_administrativa_nombre')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->text('firmas')->nullable();
            $table->integer("rechazado_por")->nullable();
            $table->datetime("rechazado_at")->nullable();
            $table->integer("creado_por")->nullable();
            $table->integer("aprobado_por")->nullable();
            $table->datetime("aprobado_at")->nullable();
            $table->integer("autorizado_por")->nullable();
            $table->datetime("autorizado_at")->nullable();
            $table->timestamps(); 
        
            // Relaciones
            $table->foreign('tramite_incidencia_asociado_id')->references('tramite_incidencia_id')->on('p12_tramites_incidencias');
            $table->foreign('tipo_captura_id')->references('tipo_captura_id')->on('p12_tipos_captura');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('rechazado_por')->references('id')->on('users');
            $table->foreign('aprobado_por')->references('id')->on('users');
            $table->foreign('autorizado_por')->references('id')->on('users');
            $table->foreign('creado_por')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p12_tramites_incidencias');
    }
}
