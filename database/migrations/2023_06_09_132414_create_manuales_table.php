<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuales', function (Blueprint $table) {
            $table->increments("manual_id");
            $table->integer('proceso_id')->unsigned();
            $table->string('nombre');
            $table->string('identificador');
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
        Schema::dropIfExists('manuales');
    }
}
