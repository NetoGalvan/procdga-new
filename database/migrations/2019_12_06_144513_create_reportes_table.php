<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->increments('reporte_id');
            $table->integer('proceso_id')->unsigned();
            $table->string('nombre')->nullable();
            $table->string('identificador')->unsigned()->nullable();
            $table->string('descripcion');
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
        Schema::dropIfExists('reportes');
    }
}
