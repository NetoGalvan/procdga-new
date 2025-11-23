<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP22ReporteDetalleTable extends Migration
{
    public function up()
    {
        Schema::create('p22_reporte_detalle', function (Blueprint $table) {
            $table->increments('p22_reporte_detalle_id');
            $table->boolean('activo')->default(true);
            $table->string('folio')->nullable();
            $table->unsignedInteger('p22_reporte_id')->nullable();
            $table->string('clave_adscripcion')->nullable();
            $table->unsignedInteger('area_creadora_id')->nullable();
            $table->integer('empleado_id')->nullable();
            $table->string('rfc')->nullable();
            $table->integer('numero_empleado')->nullable();
            $table->json('json_evaluacion_mf')->nullable();
            $table->json('json_evaluacion_esc_nb')->nullable();
            $table->json('json_evaluacion_esc')->nullable();
            $table->integer('total_dias_laborables')->nullable();
            $table->integer('total_dias_no_laborados')->nullable();
            $table->integer('total_dias_laborados')->nullable();
            $table->integer('elaboro_id')->nullable();
            $table->date('created_on')->nullable();
            $table->timestamps();

            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('p22_reporte_id')->references('p22_reporte_id')->on('p22_reporte')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('p22_reporte_detalle');
    }
}
