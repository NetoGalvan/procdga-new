<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP20PremioPuntualidadEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p20_premio_puntualidad_empleados', function (Blueprint $table) {
            $table->bigIncrements('premio_puntualidad_empleado_id');
            $table->unsignedBigInteger('premio_puntualidad_area_id')->nullable();
            $table->unsignedBigInteger('premio_puntualidad_inscripcion_id')->nullable();
            $table->string('folio')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('seccion_sindical')->nullable();
            $table->string('fecha_inicio_evaluacion')->nullable();
            $table->string('fecha_fin_evaluacion')->nullable();
            $table->json('json_detalle_evaluacion')->nullable();
            $table->string('fecha_inicio_siden')->nullable();//timestamp
            $table->string('fecha_fin_siden')->nullable();
            $table->string('area_empleado')->nullable();
            $table->string('area_identificador_empleado')->nullable();
            $table->string('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_titulo')->nullable();

            $table->timestamps();

            $table->foreign('premio_puntualidad_inscripcion_id')->references('premio_puntualidad_inscripcion_id')->on('p20_premio_puntualidad_inscripcion')->onDelete('cascade');
            $table->foreign('premio_puntualidad_area_id')->references('premio_puntualidad_area_id')->on('p20_premio_puntualidad_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p20_premio_puntualidad_empleados');
    }
}
