<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P16HorasPorEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p16_horas_por_empleado', function (Blueprint $table) {
            $table->increments('horas_empleado_id');
            $table->unsignedBigInteger('subproceso_pago_tiempo_extra_excedente_id')->nullable();
            $table->unsignedBigInteger('p16_presupuesto_quincenal_subareas_id')->nullable();
            $table->integer('unidad_administrativa_id')->nullable();
            $table->string('unidad_administrativa_nombre')->nullable();
            $table->string('folio', 20)->nullable();
            $table->string('rfc')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('sindicalizado')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->integer('horas')->nullable();
            $table->decimal('monto_bruto', $precision = 8, $scale = 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('tipo')->nullable();
            $table->timestamps();
            
            $table->foreign('subproceso_pago_tiempo_extra_excedente_id')->references('subproceso_pago_tiempo_extra_excedente_id')->on('p16_subproceso_pago_tiempo_extra_excedente');
            $table->foreign('p16_presupuesto_quincenal_subareas_id')->references('p16_presupuesto_quincenal_subareas_id')->on('p16_presupuesto_quincenal_subareas');
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
        Schema::dropIfExists('p16_horas_por_empleado');
    }
}
