<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSolicitudesViaticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p31_solicitudes_viaticos', function (Blueprint $table) {
            $table->increments('solicitud_viatico_id');
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'AUTORIZADO', 'RECHAZADO', 'CANCELADO', 'COMPLETADO']);
            $table->string('folio')->nullable();
            $table->integer('area_id')->nullable();
            $table->integer('lugar_zona_tarifaria_id')->nullable();
            $table->integer('tipo_financiamiento_id')->nullable();
            $table->integer('porcentaje_financiamiento')->nullable();
            $table->decimal('tipo_cambio')->nullable();
            $table->float('dias')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->string('motivo_comision')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('lugar_zona_tarifaria_id')->references('lugar_zona_tarifaria_id')->on('lugar_zona_tarifaria');
            $table->foreign('tipo_financiamiento_id')->references('tipo_financiamiento_id')->on('tipos_financiamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p31_solicitudes_viaticos');
    }
}
