<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15AsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_asistencias', function (Blueprint $table) {
            $table->increments("asistencia_id");
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'CANCELADO', 'COMPLETADO']);
            $table->string('folio')->nullable();
            $table->date("fecha");
            $table->integer("numero_evaluacion");
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p15_asistencias');
    }
}
