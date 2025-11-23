<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP21PremioTable extends Migration
{
    public function up()
    {
        Schema::create('p21_premio', function (Blueprint $table) {

            $table->increments('p21_premio_id');
            $table->string('folio')->unique()->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('area_id')->nullable();

            $table->date('fecha_cierre_convocatoria')->nullable();
            $table->string('estatus')->nullable();
            $table->string('tarea_convocatoria')->nullable();
            $table->string('comite_previo')->nullable();
            $table->string('anio_convocatoria')->nullable();

            $table->string('comentarios_admin_pa_21')->nullable();
            $table->string('comentarios_autz_pa_21')->nullable();
            $table->string('firmas')->nullable();

            $table->date('fecha_inicio_evaluacion_pa')->nullable();
            $table->date('fecha_fin_evaluacion_pa')->nullable();

            $table->unsignedInteger('area_creadora_id')->nullable();

            $table->unsignedInteger('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_area_nombre')->nullable();
            $table->string('creado_por_titulo')->nullable();
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p21_premio');
    }
}
