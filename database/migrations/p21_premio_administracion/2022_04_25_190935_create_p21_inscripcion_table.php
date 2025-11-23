<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP21InscripcionTable extends Migration
{
    public function up()
    {
        Schema::create('p21_inscripcion', function (Blueprint $table) {
            $table->increments('p21_inscripcion_id');
            $table->string('folio')->unique()->nullable();
            $table->boolean('activo')->default(true);
            $table->string('estatus')->nullable();

            // Estos son de p21_premio (16)
            $table->unsignedInteger('p21_premio_id')->nullable();
            $table->string('folio_premio')->nullable();
            $table->string('tarea_convocatoria')->nullable();
            $table->string('anio_convocatoria')->nullable();
            $table->string('comentarios_admin_pa_21')->nullable();
            $table->date('fecha_inicio_evaluacion_pa')->nullable();
            $table->date('fecha_fin_evaluacion_pa')->nullable();

            $table->unsignedInteger('area_id')->nullable();

            $table->string('unidad_administrativa_id')->nullable();
            $table->string('unidad_administrativa')->nullable();

            $table->string('comentarios_oper_pa_21')->nullable();
            $table->string('comentarios_oper_cap_21')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            $table->string('seccion_sindical')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('fecha_ingreso')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('puesto')->nullable();

            $table->string('subunidad_id')->nullable();
            $table->string('antiguedad_puesto_actual')->nullable();
            $table->string('domicilio_laboral')->nullable();
            $table->string('telefono_laboral')->nullable();
            $table->string('ext_telefono_laboral')->nullable();
            $table->string('denominacion_puesto')->nullable();
            $table->string('descripcion_actividades')->nullable();
            $table->string('nombre_jefe')->nullable();
            $table->string('cargo_jefe')->nullable();
            $table->string('tipo_nombramiento')->nullable();
            $table->string('propuesto_por')->nullable();
            $table->string('grupo')->nullable();
            $table->date('fecha_evaluacion_desempenio')->nullable();
            $table->json('json_desempenio')->nullable();
            $table->json('json_cursos')->nullable();
            $table->json('json_puntualidad_asistencia')->nullable();

            $table->unsignedInteger('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_area_nombre')->nullable();
            $table->string('creado_por_titulo')->nullable();
            $table->unsignedInteger('area_creadora_id')->nullable();

            $table->unsignedInteger('evaluado_por')->nullable();
            $table->string('evaluado_por_area')->nullable();
            $table->string('evaluado_por_area_nombre')->nullable();
            $table->string('evaluado_por_titulo')->nullable();
            $table->date('evaluado_fecha')->nullable();

            $table->unsignedInteger('validado_por')->nullable();
            $table->string('validado_por_area')->nullable();
            $table->string('validado_por_area_nombre')->nullable();
            $table->string('validado_por_titulo')->nullable();
            $table->date('validado_fecha')->nullable();

            $table->string('total_art_87')->nullable();

            $table->timestamps();

            $table->foreign('p21_premio_id')->references('p21_premio_id')->on('p21_premio')->onDelete('cascade');
            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('evaluado_por')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('validado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p21_inscripcion');
    }
}
