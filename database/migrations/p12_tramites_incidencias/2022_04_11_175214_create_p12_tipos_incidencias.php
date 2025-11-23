<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12TiposIncidencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_tipos_incidencias', function (Blueprint $table) {
            $table->increments('tipo_incidencia_id'); 
            $table->integer('tipo_justificacion_id');
            $table->text('ley');
            $table->string('articulo')->nullable();
            $table->string('subarticulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->enum('tipo_empleado', ["SINDICALIZADO", "NO_SINDICALIZADO", "TODOS"]);
            $table->enum('tipo_dias', ["HABILES", "NATURALES"]);
            $table->enum('sexo', ["M", "F", "TODOS"])->nullable();
            $table->enum('intervalo_evaluacion', ["TODO_EL_DIA", "ENTRADA", "SALIDA", "RETARDO_GRAVE", "RETARDO_LEVE"])->nullable();
            $table->boolean('aplica_autoincidencia')->default(false);
            $table->integer('dias')->nullable();
            $table->integer('anio')->nullable();
            $table->integer('cada_cuantos_dias')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->date('fecha_prescribe')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('antiguedad')->nullable();
            $table->boolean('gasta')->nullable();
            $table->boolean('unica_vez')->nullable();
            $table->text('json_fechas_inhabiles')->nullable(); 
            $table->boolean('activo')->default(true); 
            $table->timestamps();

            $table->foreign('tipo_justificacion_id')->references('tipo_justificacion_id')->on('p12_tipos_justificaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p12_tipos_incidencias');
    }
}
