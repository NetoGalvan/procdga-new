<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12NotasBuenas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_notas_buenas', function (Blueprint $table) {
            $table->increments("nota_buena_id");
            $table->string("periodo");
            $table->enum("tipo", ["PUNTUALIDAD 1RA. QUINCENA", "PUNTUALIDAD 2DA. QUINCENA", "ASISTENCIA"])->nullable();
            $table->integer('incidencia_empleado_id');
            $table->timestamps();

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
        Schema::dropIfExists('p12_notas_buenas');
    }
}
