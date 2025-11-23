<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15HorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_horarios', function (Blueprint $table) {
            $table->increments('horario_id');
            $table->time('entrada');
            $table->time('salida')->nullable();
            $table->string('dias');
            $table->boolean('es_horario_base');
            $table->boolean('aplica_retardos');
            $table->boolean('dias_festivos_son_laborales');
            $table->enum('tipo_empleado', ["SINDICALIZADO", "NO_SINDICALIZADO", "ESTRUCTURA", "NOMINA_8"]);
            $table->enum('tipo_asignacion', ["SISTEMA", "EMPLEADO"])->default("SISTEMA");
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
        Schema::dropIfExists('p15_horarios');
    }
}
