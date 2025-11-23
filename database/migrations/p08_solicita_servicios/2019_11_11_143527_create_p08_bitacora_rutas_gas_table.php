<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP08BitacoraRutasGasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p08_bitacora_rutas_gas', function (Blueprint $table) {
            $table->increments('p08_bitacora_ruta_gas_id');
            $table->unsignedInteger('p08_vehiculo_id')->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->integer('anio_bitacora')->nullable();
            $table->integer('mes_bitacora')->nullable();
            $table->date('fecha_ruta')->nullable();
            $table->date('fecha_carga')->nullable();
            $table->integer('kilometros_inicial')->nullable();
            $table->integer('kilometros_final')->nullable();
            $table->integer('kilometros_total')->nullable();
            $table->float('litros_combustible')->nullable();
            $table->float('importe_combustible', 8, 2)->nullable();
            $table->string('tipo_combustible')->nullable();
            $table->float('litros_lubricante')->nullable();
            $table->float('importe_lubricante', 8, 2)->nullable();
            $table->string('partida')->nullable();
            $table->string('rendimiento')->nullable();
            $table->string('ticket')->nullable();
            $table->string('nombre_elabora')->nullable();
            $table->string('nombre_revisa')->nullable();
            $table->string('observaciones_ruta')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            //Relaciones
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('p08_vehiculo_id')->references('p08_vehiculo_id')->on('p08_vehiculos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p08_bitacora_rutas_gas');
    }
}
