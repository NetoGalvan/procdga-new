<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP08SolicitaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p08_solicita_servicios', function (Blueprint $table) {
            $table->increments('p08_solicita_servicio_id');
            $table->string('folio')->unique()->nullable();
            $table->string('tipo_tramite')->nullable();
            $table->enum('estatus', ['EN_PROCESO', 'RECHAZADO', 'COMPLETADO', 'CANCELADO'])->nullable();
            //campo del area
            $table->unsignedInteger('area_id')->nullable();
            $table->string('sub_area')->nullable();
            //campos servicios generales y tipo de servicio
            $table->unsignedInteger('servicio_general_id')->nullable();
            $table->unsignedInteger('servicio_id')->nullable();
            //campos generales
            $table->text('texto_solicitud')->nullable();
            $table->string('contacto_servicio')->nullable();
            $table->text('direccion_servicio')->nullable();
            $table->string('telefono_servicio')->nullable();
            $table->integer('cantidad_solicitud')->nullable();
            $table->boolean('aceptado')->nullable();
            $table->date('fecha_acepta')->nullable();
            $table->date('fecha_ejecuta')->nullable();
            $table->date('fecha_terminado')->nullable();
            $table->boolean('satisfecho')->nullable();
            $table->text('comentario_satisfecho')->nullable();
            $table->text('comentarios_rechazo')->nullable();
            $table->json('imagenes')->nullable();
            $table->text('comentario_privado')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('servicio_general_id')->references('servicio_general_id')->on('servicios_generales');
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
        Schema::dropIfExists('p08_solicita_servicios');
    }
}
