<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16SubprocesoPagoTiempoExtraExcedenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p16_subproceso_pago_tiempo_extra_excedente', function (Blueprint $table) {
            $table->bigIncrements('subproceso_pago_tiempo_extra_excedente_id');
            $table->integer('pago_tiempo_extra_excedente_id');
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO']);
            $table->integer('area_id');
            $table->string('folio')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->timestamps();
            
            $table->foreign('pago_tiempo_extra_excedente_id')->references('pago_tiempo_extra_excedente_id')->on('p16_pago_tiempo_extra_excedente');
            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p16_subproceso_pago_tiempo_extra_excedente');
    }
}
