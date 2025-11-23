<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNivelesSalarialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveles_salariales', function (Blueprint $table) {
            $table->increments('nivel_salarial_id');
            $table->string('nombre');
            $table->string('identificador');
            $table->string('tipo_personal');
            $table->string('sueldo_cotizable');
            $table->string('sueldo_sar');
            $table->string('sueldo_total');
            $table->string('tipo_nomina')->nullable();
            $table->string('reconocimiento_mensual_bruto')->nullable();
            $table->string('cantidad_adicional_bruto')->nullable();
            $table->string('asignacion_adicional_bruto')->nullable();
            $table->string('total_mensual_bruto')->nullable();
            $table->string('impuesto_mensual')->nullable();
            $table->string('sueldo_neto_mensual')->nullable();
            $table->string('issste_seguro_salud')->nullable();
            $table->string('issste_seguro_retiro')->nullable();
            $table->string('issste_seguro_invalides_vida')->nullable();
            $table->string('sueldo_liquido_mensual')->nullable();
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
        Schema::dropIfExists('niveles_salariales');
    }
}
