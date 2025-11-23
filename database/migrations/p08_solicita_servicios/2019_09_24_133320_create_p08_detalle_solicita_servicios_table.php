<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP08DetalleSolicitaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p08_detalle_solicita_servicios', function (Blueprint $table) {
            $table->increments('p08_detalle_solicita_servicio_id');
            $table->unsignedInteger('p08_solicita_servicio_id');
            $table->enum('estatus_detalle', ['COMPLETADO', 'PARCIAL', 'RECHAZADO', 'EN_PROCESO']); //'COMPLETADO' = 'Servicio prestado', 'PARCIAL' = 'Resuelto parcialmente', 'RECHAZADO' = 'No se hará'

            $table->text('comentarios_servicio')->nullable();
            $table->text('descripcion_servicio')->nullable();
            $table->string('unidad')->nullable();
            $table->date('fecha_estimada')->nullable();
            $table->boolean('vobo_solicita')->default(true);
            $table->string('asignado_a')->nullable();
            $table->string('confirmado_por')->nullable();
            $table->boolean('vobo_entrega')->default(true);
            $table->date('fecha_entrega')->nullable();

            //campos servicios
            $table->unsignedInteger('servicio_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('p08_solicita_servicio_id')->references('p08_solicita_servicio_id')->on('p08_solicita_servicios');
            $table->foreign('servicio_id')->references('servicio_id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p08_detalle_solicita_servicios');
    }
}
