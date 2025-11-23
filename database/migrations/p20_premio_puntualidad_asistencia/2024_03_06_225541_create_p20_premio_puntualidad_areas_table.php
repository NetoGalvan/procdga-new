<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP20PremioPuntualidadAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p20_premio_puntualidad_areas', function (Blueprint $table) {
            $table->bigIncrements('premio_puntualidad_area_id');
            $table->unsignedBigInteger('premio_puntualidad_inscripcion_id');
            $table->string('estatus')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->text("motivo_rechazo")->nullable();
            $table->timestamps();

            $table->foreign('premio_puntualidad_inscripcion_id')->references('premio_puntualidad_inscripcion_id')->on('p20_premio_puntualidad_inscripcion')->onDelete('cascade');
            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p20_premio_puntualidad_areas');
    }
}
