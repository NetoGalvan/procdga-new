<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16PagoTiempoExtraExcedenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p16_pago_tiempo_extra_excedente', function (Blueprint $table) {
            $table->bigIncrements('pago_tiempo_extra_excedente_id');
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO'])->nullable();
            $table->string('tipo')->nullable();
            $table->integer('area_id');
            $table->string('folio')->nullable();
            $table->string('quincena')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
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
        Schema::dropIfExists('p16_pago_tiempo_extra_excedente');
    }
}
