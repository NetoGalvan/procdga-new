<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06NominaDetalleTable extends Migration
{
    public function up()
    {
        Schema::create('p06_nomina_detalle', function (Blueprint $table) {
            $table->increments('nomina_detalle_id');
            $table->unsignedInteger('nomina_id');
            $table->unsignedInteger('servicio_social_id');
            $table->string('tipo_pago')->nullable();
            $table->integer('meses_pagar')->nullable();
            $table->date('fecha_cerrado')->nullable();
            $table->timestamps();

            $table->foreign('nomina_id')->references('nomina_id')->on('p06_nomina');
            $table->foreign('servicio_social_id')->references('servicio_social_id')->on('p06_servicio_social');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_nomina_detalle');
    }
}
