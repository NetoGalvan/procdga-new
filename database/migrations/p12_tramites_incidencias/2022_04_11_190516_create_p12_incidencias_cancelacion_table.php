<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12IncidenciasCancelacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_incidencias_cancelacion', function (Blueprint $table) {
            $table->increments("incidencia_cancelacion_id");
            $table->integer("tramite_incidencia_id");
            $table->integer("incidencia_empleado_id");
            $table->timestamps();

            $table->foreign('tramite_incidencia_id')->references('tramite_incidencia_id')->on('p12_tramites_incidencias');
            $table->foreign('incidencia_empleado_id')->references('incidencia_empleado_id')->on('p12_incidencias_empleados');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p12_incidencias_cancelacion');
    }
}
