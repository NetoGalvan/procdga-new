<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instancias', function (Blueprint $table) {
            $table->increments('instancia_id');
            $table->integer('instancia_padre_id')->nullable();
            $table->integer('proceso_id')->unsigned();
            $table->string('folio')->unique()->nullable();
            $table->morphs('model');
            $table->integer('area_id')->nullable();
            $table->boolean('es_historico')->default(false);
            $table->timestamps();

            $table->foreign('proceso_id')->references('proceso_id')->on('procesos');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('instancia_padre_id')->references('instancia_id')->on('instancias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instancias');
    }
}
