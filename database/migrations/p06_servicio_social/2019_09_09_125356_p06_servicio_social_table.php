<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06ServicioSocialTable extends Migration
{
    public function up()
    {
        Schema::create('p06_servicio_social', function (Blueprint $table) {
            $table->increments('servicio_social_id');
            $table->boolean('activo')->default(true);
            $table->string('folio')->unique()->nullable();
            $table->enum('estatus', ['EN_PROCESO', 'CANCELADO', 'RECHAZADO', 'EN_CORRECCION', 'COMPLETADO'])->nullable();
            //$table->string('estatus');
            // Relación con Prestador
            $table->unsignedInteger('prestador_id')->nullable();
            $table->enum('validacion', ['LIBERADO', 'BAJA', 'ABANDONO'])->nullable();

            
            // Relación con Entidad
            //$table->unsignedInteger('entidad_federativa_id')->nullable();
            // Relación con Escuela
            //$table->unsignedInteger('escuela_id')->nullable();
            // Relación con Programa
            //$table->unsignedInteger('programa_id')->nullable();
            //$table->string('programas')->nullable();
            // Relación con Nómina
            $table->unsignedInteger('nomina_id')->nullable();
            $table->string('payment_estatus')->nullable();
            //Relación con Área creadora
            $table->unsignedInteger('area_id')->nullable();
            $table->string('nombre_area')->nullable();
            //Relación con Área de adscripción
            $table->unsignedInteger('area_adscripcion_id')->nullable();
            $table->string('expediente')->nullable();
            $table->string('folio_directorio')->nullable();
            $table->string('folio_asistencia')->nullable();

            $table->date('fecha_cita')->nullable();
            $table->string('hora_cita')->nullable();
            $table->string('lugar_cita')->nullable();
            
            $table->string('horario')->nullable();
            $table->string('actividades', 50000)->nullable();
            $table->string('jefe')->nullable();
            $table->string('puesto_jefe')->nullable();
            $table->bigInteger('telefono_jefe')->nullable();
            $table->string("telefono_ext_jefe")->nullable();
            
            $table->integer('horas_acumuladas')->nullable()->default(0);

            $table->date('fecha_inicio_monitoreo')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_carta_inicio')->nullable();
            $table->date('fecha_carta_fin')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->date('fecha_pago_parcial')->nullable();
            
            $table->string('nombre_drh')->nullable();
            $table->dateTime('fecha_firma_drh_inicio')->nullable(); //firma_drh_inicio
            $table->dateTime('fecha_firma_drh_fin')->nullable(); //firma_drh_fin

            $table->string('subdireccion_ua')->nullable();
            $table->string('unidad_departamental_ua')->nullable();
            $table->string('dnss')->nullable();

            //$table->string('rechazo_som', 50000)->nullable();
            $table->string('correcciones')->nullable(); //estatus_rechazo_som
            $table->string('observaciones_carta_inicio', 50000)->nullable(); //observaciones_som
            $table->string('observaciones_carta_fin', 50000)->nullable(); //comentario
            //$table->string('comentario_horas')->nullable();
            
            $table->double('monto_pago')->nullable();
            $table->double('monto_pago_parcial')->nullable();
            $table->string('periodo_pagar')->nullable();
            $table->double('total_pagado')->nullable();
            
            $table->boolean('es_historico')->default(false);
            $table->timestamps();

            $table->foreign('prestador_id')->references('prestador_id')->on('p06_prestadores');
            //$table->foreign('entidad_federativa_id')->references('entidad_federativa_id')->on('entidades_federativas');
            //$table->foreign('escuela_id')->references('escuela_id')->on('p06_escuelas');
            //$table->foreign('programa_id')->references('programa_id')->on('p06_programas');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('area_adscripcion_id')->references('area_adscripcion_id')->on('p06_areas_adscripcion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_servicio_social');
    }
}
