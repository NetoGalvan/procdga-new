<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPagoPrestaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p07_pago_prestaciones', function (Blueprint $table) {
            $table->increments('pago_prestacion_id')->unique();
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO']);
            $table->string('folio')->nullable();
            $table->string('nombre')->nullable();
            $table->string('observaciones')->nullable();
            $table->datetime('fecha_limite')->nullable();
            $table->string('estructura_concurrente', 1000)->nullable();
            $table->integer('tipo_prestacion_id')->nullable();
            $table->timestamps();

            $table->foreign('tipo_prestacion_id')->references('tipo_prestacion_id')->on('tipos_prestaciones');
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
        Schema::drop('p07_pago_prestaciones');
    }
}
