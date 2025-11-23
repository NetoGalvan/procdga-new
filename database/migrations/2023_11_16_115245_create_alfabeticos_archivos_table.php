<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlfabeticosArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alfabeticos_archivos', function (Blueprint $table) {
            $table->increments('archivo_id');
            $table->unsignedInteger('alfabetico_id')->nullable();
            $table->json('empleados')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->integer('cantidad_empleados')->nullable();
            $table->date('fecha_carga')->nullable();
            $table->unsignedInteger('cargado_por_usuario')->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->timestamps();

            $table->foreign('cargado_por_usuario')->references('id')->on('users');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('alfabetico_id')->references('alfabetico_id')->on('alfabeticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alfabeticos_archivos');
    }
}
