<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaTiposMovimientosHonorarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_movimientos_honorarios', function (Blueprint $table) {
            $table->increments('tipo_movimiento_honorarios_id');
            $table->string('codigo');
            $table->string('contrato')->nullable();
            $table->string('descripcion');
            $table->string('tipo');
            $table->string('identificador');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('tipos_movimientos_honorarios');
    }
}
