<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP32TramitesKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p32_tramites_kardex', function (Blueprint $table) {
            $table->increments('tramite_kardex_id');

            $table->enum('estatus', ['EN_PROCESO', 'COMPLETADO', 'CANCELADO', 'RECHAZADO'])->nullable();
            $table->string('folio')->unique()->nullable();
            $table->unsignedInteger('tipo_tramite_kardex_id')->nullable();
            $table->string('numero_empleado')->nullable($value = true);
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->string('unidad_administrativa_nombre')->nullable();
            $table->string('puesto')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('nivel_salarial')->nullable();

            $table->string('calle')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('municipio_alcaldia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('cp')->nullable();
            $table->unsignedInteger('entidad_id')->nullable();

            $table->unsignedInteger('area_id')->nullable();
            $table->date('fecha_alta_empleado')->nullable();
            $table->date('fecha_baja_empleado')->nullable();
            $table->date('fecha_elaboracion_tramite')->nullable();

            $table->unsignedInteger('revisado_por_usuario')->nullable();
            $table->unsignedInteger('autorizado_por_usuario')->nullable();
            $table->unsignedInteger('asignado_a_usuario')->nullable();

            $table->string('observaciones')->nullable();
            $table->string('solicitante')->nullable();
            $table->json('documentos')->nullable();
            $table->json('seguimientos')->nullable();
            $table->json('detalles')->nullable();
            $table->json('campos_extra')->nullable();
            $table->json('firmas')->nullable();

            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('tipo_tramite_kardex_id')->references('tipo_tramite_kardex_id')->on('p32_tipos_tramite_kardex');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('entidad_id')->references('entidad_federativa_id')->on('entidades_federativas');
            $table->foreign('revisado_por_usuario')->references('id')->on('users');
            $table->foreign('autorizado_por_usuario')->references('id')->on('users');
            $table->foreign('asignado_a_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p32_tramites_kardex');
    }
}
