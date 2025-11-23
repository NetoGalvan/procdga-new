<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->increments('tarea_id');
            $table->string('nombre');
            $table->string('identificador')->unsigned()->nullable();
            $table->string('descripcion');
            $table->enum('tipo', ["TAREA", "NOTIFICACION"]);
            $table->integer('proceso_id')->unsigned();
            $table->string('ruta');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('proceso_id')->references('proceso_id')->on('procesos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
