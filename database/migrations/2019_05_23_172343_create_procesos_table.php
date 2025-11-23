<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->increments('proceso_id');
            $table->integer('proceso_padre_id')->nullable();
            $table->float('numero_proceso')->nullable();
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('identificador')->nullable();
            $table->string('icono')->nullable();
            $table->enum('tipo', ["SUPERPROCESO", "CONVOCATORIA", "PROCESO", "SUBPROCESO", "AUTOPROCESO"]);
            $table->string('ruta_descripcion');
            $table->string('ruta_lista_tramites')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('proceso_padre_id')->references('proceso_id')->on('procesos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procesos');
    }
}
