<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP02DetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p02_detalles', function (Blueprint $table) {
            $table->increments('detalle_id');
            $table->unsignedInteger('tramite_issste_id');
            $table->string('folio_p01')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('calle')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('cp')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('municipio_alcaldia')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('numero_seguridad_social')->nullable();
            $table->enum('pagaduria', [1])->default(1);
            $table->string('qna_procesado')->nullable();
            $table->enum('estatus_issste', ['EN_PROCESO', 'LISTO', 'COMPLETADO', 'RECHAZADO'])->nullable();

            /* Entidad domicilio */
            $table->unsignedInteger('entidad_federativa_domicilio_id')->nullable();
            /* Entidad nacimiento */
            $table->unsignedInteger('entidad_federativa_nacimiento_id')->nullable();
            /* Sexo */
            $table->unsignedInteger('sexo_id')->nullable();
            /* Tipo de nombramiento */
            $table->unsignedInteger('tipo_nombramiento_id')->nullable();
            /* Tipo de movimiento */
            $table->unsignedInteger('tipo_movimiento_id')->nullable();
            /* Tipo de movimiento Issste */
            $table->unsignedInteger('tipo_movimiento_issste_id')->nullable();

            $table->string('sueldo_cotizable')->nullable();
            $table->string('sueldo_sar')->nullable();
            $table->string('sueldo_total')->nullable();
            $table->string('motivo_rechazo')->nullable();
            $table->string('clave_cobro')->nullable();
            $table->integer('clave_ramo')->nullable();
            $table->string('guia')->nullable();
            $table->date('fecha_modificacion')->nullable();
            $table->date('fecha_recepcion')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('qna_issste')->nullable();
            $table->boolean('listo')->default(false);
            $table->timestamps();

            $table->foreign('tramite_issste_id')->references('tramite_issste_id')->on('p02_tramites_issste');
            $table->foreign('tipo_nombramiento_id')->references('tipo_nombramiento_id')->on('tipos_nombramientos_issste');
            $table->foreign('entidad_federativa_nacimiento_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('sexo_id')->references('sexo_id')->on('sexos');
            $table->foreign('entidad_federativa_domicilio_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('tipo_movimiento_id')->references('tipo_movimiento_id')->on('tipos_movimientos');
            $table->foreign('tipo_movimiento_issste_id')->references('tipo_movimiento_issste_id')->on('tipos_movimientos_issste');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p02_detalles');
    }
}
