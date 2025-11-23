<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('area_id');
            $table->string('nombre');
            $table->string('identificador')->unique();
            $table->integer('area_principal_id')->nullable();
            $table->integer('unidad_administrativa_id');
            $table->enum('tipo', ["AREA_PRINCIPAL", "SUBAREA"]);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('area_principal_id')->references('area_id')->on('areas');
            $table->foreign('unidad_administrativa_id')->references('unidad_administrativa_id')->on('unidades_administrativas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}


