<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP20PremioPuntualidadInscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p20_premio_puntualidad_inscripcion', function (Blueprint $table) {
            $table->bigIncrements('premio_puntualidad_inscripcion_id');
            $table->unsignedBigInteger('premio_puntualidad_id')->nullable();
            $table->string('folio')->unique()->nullable();
            $table->enum('estatus', ['EN_PROCESO', 'RECHAZADO', 'COMPLETADO', 'CANCELADO'])->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('quincena')->nullable();
            $table->text('instrucciones')->nullable();
            $table->string('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_titulo')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('premio_puntualidad_id')->references('premio_puntualidad_id')->on('p20_premio_puntualidad')->onDelete('cascade');
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
        Schema::dropIfExists('p20_premio_puntualidad_inscripcion');
    }
}
