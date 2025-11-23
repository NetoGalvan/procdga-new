<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP22ReporteTable extends Migration
{
    public function up()
    {
        Schema::create('p22_reporte', function (Blueprint $table) {
            $table->increments('p22_reporte_id');
            $table->boolean('activo')->default(true);
            $table->string('folio')->unique()->nullable();
            $table->unsignedInteger('area_creadora_id')->nullable();
            $table->string('estatus')->nullable();
            $table->string('tipo_reporte')->nullable();
            $table->date('fecha_inicio_evaluacion')->nullable();
            $table->date('fecha_fin_evaluacion')->nullable();
            $table->string('nombre_periodo_evaluacion')->nullable();
            $table->string('firmas')->nullable();
            $table->integer('elaboro_id')->nullable();
            $table->date('created_on')->nullable();

            $table->timestamps();

            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p22_reporte');
    }
}
