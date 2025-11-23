<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeleccionCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p11_seleccion_candidatos', function (Blueprint $table) {
            $table->increments('seleccion_candidato_id');
            $table->integer('numero_plaza')->nullable();
            $table->string('observaciones_plaza')->nullable();
            $table->string('tipo_plaza')->nullable();
            $table->string('funciones_plaza')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('puesto')->nullable();
            $table->string('descripcion_puesto')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('tipo_personal')->nullable();
            $table->string('codigo_situacion_empleado')->nullable();
            $table->string("codigo_universo")->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->string('unidad_administrativa_nombre')->nullable();
            $table->string('sueldo_cotizable')->nullable();
            $table->string('sueldo_sar')->nullable();
            $table->string('sueldo_total')->nullable();
            $table->string('aceptacion_srio')->nullable($value = true);
            $table->string('comentarios_titular')->nullable($value = true);
            $table->string('comentarios_dga')->nullable($value = true);
            $table->string('titulares')->nullable($value = true);

            $table->timestamps();
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
        Schema::dropIfExists('p11_seleccion_candidatos');
    }
}
