<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSubprocesosPagoPrestaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p07_subprocesos', function (Blueprint $table) {
            $table->increments('subproceso_id')->unique();
            $table->integer('pago_prestacion_id');
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO']);
            $table->string('folio')->nullable();
            $table->date('ultima_modificacion')->nullable();
            $table->string('ultima_modificacion_por')->nullable();
            $table->string('tipo_prestacion_id')->nullable();
            $table->string('observaciones')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->string('estructura_concurrente', 1000)->nullable();
            $table->string('comentarios_rechazo')->nullable();
            $table->boolean('estatus_aprobacion')->nullable();
            $table->boolean('completado_a_tiempo')->default(false)->nullable();
            $table->timestamps();
            
            $table->foreign('pago_prestacion_id')->references('pago_prestacion_id')->on('p07_pago_prestaciones');
            
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
        Schema::drop('p07_subprocesos');
    }
}
