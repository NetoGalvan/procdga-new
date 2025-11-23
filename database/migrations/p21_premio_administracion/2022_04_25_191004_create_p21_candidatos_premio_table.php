<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP21CandidatosPremioTable extends Migration
{
    public function up()
    {
        Schema::create('p21_candidatos_premio', function (Blueprint $table) {
            $table->increments('p21_candidatos_premio_id');
            $table->boolean('activo')->default(true);
            $table->string('estatus_tiempo')->nullable();
            $table->string('estatus_origen')->nullable();

            //Estos son del p21_premio (17)
            $table->unsignedInteger('p21_premio_id')->nullable();
            $table->string('folio_premio')->nullable();
            $table->string('estatus_convocatoria')->nullable();
            $table->string('tarea_convocatoria')->nullable();
            $table->string('anio_convocatoria')->nullable();

            $table->unsignedInteger('area_premio_id')->nullable();
            $table->string('area_premio_nombre')->nullable();

            $table->string('comentarios_admin_pa_21')->nullable();
            $table->date('fecha_inicio_evaluacion_pa')->nullable();
            $table->date('fecha_fin_evaluacion_pa')->nullable();

            $table->unsignedInteger('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_area_nombre')->nullable();
            $table->string('creado_por_titulo')->nullable();
            $table->unsignedInteger('area_creadora_id')->nullable();

            //Estos son de p21_inscripcion (50)
            $table->unsignedInteger('p21_inscripcion_id')->nullable();
            $table->string('folio_inscripcion')->nullable();
            $table->string('estatus_inscripcion')->nullable();
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
            $table->unsignedInteger('area_inscripcion_id')->nullable();
            $table->unsignedInteger('area_inscripcion_nombre')->nullable();
            $table->string('unidad_administrativa_id')->nullable();
            $table->string('unidad_administrativa')->nullable();
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

            $table->string('comentarios_desempenio')->nullable();
            $table->string('comentarios_cursos')->nullable();
            $table->string('estatus_declinacion')->nullable();
            $table->string('comentarios_declinacion')->nullable();
            $table->bigInteger('puntaje_total_inicial')->nullable();
            $table->string('premio_inicial')->nullable();
            $table->string('estatus_inconformidad')->nullable();
            $table->string('comentarios_inconformidad')->nullable();
            $table->bigInteger('puntaje_total_final')->nullable();
            $table->string('premio_final')->nullable();
            $table->string('observaciones')->nullable();

            $table->timestamps();

            $table->foreign('p21_premio_id')->references('p21_premio_id')->on('p21_premio')->onDelete('cascade');
            $table->foreign('p21_inscripcion_id')->references('p21_inscripcion_id')->on('p21_inscripcion')->onDelete('cascade');
            $table->foreign('area_premio_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('area_inscripcion_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('evaluado_por')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('validado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p21_candidatos_premio');
    }
}
