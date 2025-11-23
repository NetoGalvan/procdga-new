<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanciaTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instancia_tarea', function (Blueprint $table) {
            $table->increments('instancia_tarea_id');
            $table->integer('instancia_tarea_principal_id')->nullable();
            $table->integer('tarea_id');
            $table->integer('instancia_id');
            $table->string('nombre')->nullable();
            $table->boolean('es_primer_tarea')->default(false);
            $table->integer('pertenece_al_area');
            $table->integer('pertenece_unidad_administrativa');
            $table->integer('pertenece_dependencia');
            $table->integer('asignado_al_rol');
            $table->integer('asignado_al_usuario')->nullable();
            $table->integer('creado_por_area');
            $table->integer('creado_por_usuario');
            $table->integer('autorizado_por_usuario')->nullable();
            $table->integer('autorizado_por_area')->nullable();
            $table->text("motivo_rechazo")->nullable();
            $table->enum('estatus', [
                'NUEVO', 
                'EN_CORRECCION',
                'COMPLETADO', 
                'RECHAZADO', 
                'CANCELADO', 
                'NOTIFICACION_NO_LEIDO', 
                'NOTIFICACION_LEIDO', 
                'NOTIFICACION_ELIMINADA'
            ]);
            $table->timestamps();

            $table->foreign('instancia_tarea_principal_id')->references('instancia_tarea_id')->on('instancia_tarea')->onDelete('cascade');
            $table->foreign('tarea_id')->references('tarea_id')->on('tareas')->onDelete('cascade');
            $table->foreign('instancia_id')->references('instancia_id')->on('instancias')->onDelete('cascade');
            $table->foreign('pertenece_al_area')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('asignado_al_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('asignado_al_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creado_por_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creado_por_area')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('autorizado_por_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('autorizado_por_area')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instancia_tarea');
    }
}
