<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16TabuladorCalcularTiempoExtraTable extends Migration
{
    public function up()
    {
        Schema::create('p16_tabulador_calcular_tiempo_extra', function (Blueprint $table) {
            $table->bigIncrements('tabulador_calcular_tiempo_extra_id');
            $table->boolean('activo')->default(true)->nullable();
            $table->integer('anio');
            $table->enum('tipo', [
                'BASE_SINDICALIZADO',
                'BASE_NO_SINDICALIZADO',
                'CONFIANZA'
            ]);
            $table->string('nivel_salarial', 8);
            $table->decimal('tabulador_autorizado_bruto', $precision = 8, $scale = 2);
            $table->decimal('reconocimiento_mensual_bruto', $precision = 8, $scale = 2);
            $table->decimal('cantidad_adicional_bruto', $precision = 8, $scale = 2);
            $table->decimal('asignacion_adicional_bruto', $precision = 8, $scale = 2);
            $table->decimal('total_mensual_bruto', $precision = 8, $scale = 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p16_tabulador_calcular_tiempo_extra');
    }
}
