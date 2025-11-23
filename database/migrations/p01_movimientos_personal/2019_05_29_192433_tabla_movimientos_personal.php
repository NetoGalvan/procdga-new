<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaMovimientosPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p01_movimientos_personal', function (Blueprint $table) {
            $table->increments('movimiento_personal_id');            
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO']);
            $table->enum('estatus_issste', ['SIN_PROCESAR', 'LISTO', 'EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO'])->default('SIN_PROCESAR');
            $table->enum('estatus_sun', ['SIN_PROCESAR', 'LISTO', 'EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO'])->default('SIN_PROCESAR');
            $table->string('folio')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('calle')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('colonia')->nullable();
            $table->string('cp')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('municipio_alcaldia')->nullable();
            $table->enum('nacionalidad', ['MEXICANA', 'EXTRANJERA'])->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->bigInteger('telefono_celular')->nullable();
            $table->string('email')->nullable();
            $table->string('numero_cuenta_bancaria')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('numero_seguridad_social')->nullable();
            $table->enum('tipo_plaza', ['TECNICO_OPERATIVO', 'ESTRUCTURA'])->nullable();
            $table->enum('asistencia', ['SI', 'NO'])->nullable();
            $table->string('contrato_interno')->nullable();
            $table->string('contrato_sar')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->date('fecha_propuesta_inicio')->nullable();
            $table->date('fecha_fin_contrato')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('centro_trabajo')->nullable()->default('1096');
            $table->string('grado')->nullable();
            $table->string('firmas')->nullable();
            $table->enum('sociedad_id', [1])->nullable()->default(1);
            $table->string('seccion_sindical')->nullable();
            $table->string('documentacion_alta')->nullable();
            $table->enum('empresa', [1])->nullable()->default(1);
            $table->string('numero_expediente')->nullable();
            $table->string('motivo_rechazo')->nullable();
            $table->integer('entidad_federativa_domicilio_id')->nullable();
            $table->integer('entidad_federativa_nacimiento_id')->nullable();
            $table->integer('estado_civil_id')->nullable();
            $table->integer('sexo_id')->nullable();
            $table->integer('nivel_estudio_id')->nullable();
            $table->integer('banco_id')->nullable();
            $table->integer('tipo_movimiento_id')->nullable();
            $table->integer('area_id')->nullable();
            $table->integer('regimen_issste_id')->nullable();
            $table->integer('turno_id')->nullable();
            $table->integer('zona_pagadora_id')->nullable();
            $table->integer('tipo_pago_id')->nullable();
            $table->integer('numero_plaza')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('puesto')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('codigo_universo')->nullable();
            $table->string('codigo_situacion_empleado')->nullable();
            $table->text('observaciones_plaza')->nullable();
            $table->text('funciones_plaza')->nullable();
            $table->enum('tipo_salario', ['4 QUINCENAL'])->nullable()->default('4 QUINCENAL');
            $table->enum('pagaduria', [1]) ->nullable()->default(1);
            $table->string('agencia')->nullable();
            $table->string('modo_deposito')->nullable();
            $table->date('fecha_elaboracion')->nullable();
            $table->integer('anio_procesado')->nullable();
            $table->string('qna_procesado')->nullable();
            $table->integer('autorizador')->nullable();
            $table->integer('titular')->nullable();
            $table->string('aceptacion_dga')->nullable();
            $table->string('folio_aprobacion')->nullable();
            $table->string('alfa_loaded')->nullable();
            $table->string('tipo_nomina_propuesta')->nullable();
            $table->string('situacion_posterior_empleado')->nullable();
            $table->string('observaciones_promociones')->nullable();
            $table->integer('plaza_inactiva_id')->nullable();
            $table->date('fecha_inicio_inactiva')->nullable();
            $table->date('fecha_fin_inactiva')->nullable();
            $table->string('situacion_empleado_inactiva')->nullable();
            $table->integer('categoria_de_negocio_id')->nullable();
            $table->string('categoria_de_negocio')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            /* Relaciones */
            $table->foreign('entidad_federativa_domicilio_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('entidad_federativa_nacimiento_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('estado_civil_id')->references('estado_civil_id')->on('estados_civiles');
            $table->foreign('sexo_id')->references('sexo_id')->on('sexos');
            $table->foreign('nivel_estudio_id')->references('nivel_estudio_id')->on('niveles_estudios');
            $table->foreign('banco_id')->references('banco_id')->on('bancos');
            $table->foreign('tipo_movimiento_id')->references('tipo_movimiento_id')->on('tipos_movimientos');
            $table->foreign('regimen_issste_id')->references('regimen_issste_id')->on('regimenes_issste');
            $table->foreign('turno_id')->references('turno_id')->on('turnos');
            $table->foreign('zona_pagadora_id')->references('zona_pagadora_id')->on('zonas_pagadoras');
            $table->foreign('tipo_pago_id')->references('tipo_pago_id')->on('tipos_pagos');
            $table->foreign('autorizador')->references('id')->on('users');
            $table->foreign('titular')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p01_movimientos_personal');
    }
}
