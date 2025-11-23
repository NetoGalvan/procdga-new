<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16PresupuestoQuincenalAreasTable extends Migration
{
    public function up()
    {
        Schema::create('p16_presupuesto_quincenal_areas', function (Blueprint $table) {
            $table->bigIncrements('p16_presupuesto_quincenal_area_id');
            $table->unsignedBigInteger('pago_tiempo_extra_excedente_id');
            $table->unsignedBigInteger('subproceso_pago_tiempo_extra_excedente_id');
            $table->unsignedBigInteger('area_id');
            $table->decimal('presupuesto', $precision = 12, $scale= 2);
            $table->timestamps();

            $table->foreign('pago_tiempo_extra_excedente_id')->references('pago_tiempo_extra_excedente_id')->on('p16_pago_tiempo_extra_excedente')->onDelete('cascade');
            $table->foreign('subproceso_pago_tiempo_extra_excedente_id')->references('subproceso_pago_tiempo_extra_excedente_id')->on('p16_subproceso_pago_tiempo_extra_excedente')->onDelete('cascade');
            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p16_presupuesto_quincenal_areas');
    }
}
