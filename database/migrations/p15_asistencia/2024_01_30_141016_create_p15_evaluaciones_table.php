<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15EvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("p15_evaluaciones", function (Blueprint $table) {
            $table->increments("evaluacion_id");
            $table->string("rfc");
            $table->integer("numero_empleado");
            $table->date("fecha");
            $table->integer("horario_id");
            $table->string("estado_eventos_original");
            $table->string("estado_eventos_final")->nullable();
            $table->string("evaluacion_original");
            $table->string("evaluacion_final");
            $table->integer("horas_extra")->default(0);
            $table->json("incidencias")->nullable();
            $table->json("eventos")->nullable();
            $table->json("eventos_validos")->nullable();
            $table->timestamps();

            $table->foreign("horario_id")->references("horario_id")->on("p15_horarios");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("p15_evaluaciones");
    }
}
