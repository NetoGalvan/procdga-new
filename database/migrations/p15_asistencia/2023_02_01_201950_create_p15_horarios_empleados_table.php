<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15HorariosEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_horarios_empleados', function (Blueprint $table) {
            $table->increments("horario_empleado_id");
            $table->integer("horario_id");
            $table->string("rfc");
            $table->integer("numero_empleado");
            $table->date('fecha_inicio');
            $table->date('fecha_final')->nullable();
            $table->timestamps();

            $table->foreign('horario_id')->references('horario_id')->on('p15_horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p15_horarios_empleados');
    }
}
