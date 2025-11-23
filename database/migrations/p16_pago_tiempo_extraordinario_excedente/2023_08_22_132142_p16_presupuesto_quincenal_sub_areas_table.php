<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16PresupuestoQuincenalSubAreasTable extends Migration
{
    public function up()
    {
        Schema::create('p16_presupuesto_quincenal_subareas', function (Blueprint $table) {
            $table->bigIncrements('p16_presupuesto_quincenal_subareas_id');
            $table->unsignedBigInteger('subproceso_pago_tiempo_extra_excedente_id');
            $table->unsignedBigInteger('area_id');
            $table->decimal('presupuesto_sub_area', $precision = 12, $scale= 2);
            $table->text("motivo_rechazo")->nullable();
            $table->timestamps();

            $table->foreign('subproceso_pago_tiempo_extra_excedente_id')->references('subproceso_pago_tiempo_extra_excedente_id')->on('p16_subproceso_pago_tiempo_extra_excedente')->onDelete('cascade');
            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p16_presupuesto_quincenal_subareas');
    }
}
