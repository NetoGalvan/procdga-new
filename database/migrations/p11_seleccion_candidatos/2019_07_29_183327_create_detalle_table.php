<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p11_detalles', function (Blueprint $table) {
            $table->increments('detalle_id');
            $table->integer('candidato_id');
            $table->string('puesto_actual')->nullable();
            $table->date('fecha_cita')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->string('hora_cita')->nullable();
            $table->string('lugar_cita')->nullable();
            $table->date('fecha_evaluacion')->nullable();
            $table->string('motivo_evaluacion')->nullable();
            $table->string('tipo_movimiento')->nullable();
            $table->string('aceptacion_eval')->nullable();
            $table->string('aceptacion_titular')->nullable();
            $table->string('aceptacion_srio')->nullable();
            $table->string('observaciones_titular')->nullable();
            $table->string('folio_aceptacion')->nullable();
            $table->string('folio_contraloria')->nullable();
            $table->text('resultados_eval_personalidad')->nullable();
            $table->text('resultados_eval_capacidades')->nullable();
            $table->text('resultados_eval_habilidades')->nullable();
            $table->text('resultados_eval_integridad')->nullable();
            $table->text('resultados_eval_grafica')->nullable();
            $table->text('sintesis_evaluacion')->nullable();
            $table->text('nombre_elabora')->nullable();
            $table->timestamps();

            $table->foreign('candidato_id')->references('candidato_id')->on('p11_candidatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        
        Schema::dropIfExists('p11_detalles');
    }
}
