<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP19IncentivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p19_incentivos', function (Blueprint $table) {
            $table->bigIncrements('p19_incentivo_id');
            $table->string('folio')->unique()->nullable();
            $table->enum('estatus', ['EN_PROCESO', 'COMPLETADO', 'CANCELADO', 'SUBPROCESO_INICIO', 'SUBPROCESO_FINALIZO'])->nullable(); // work_status
            $table->string('nombre_quincena')->nullable();
            $table->date('fecha_inicio_pago')->nullable();
            $table->date('fecha_fin_pago')->nullable();
            $table->text('comentarios_opera_incen')->nullable();
            $table->string('numero_documento')->nullable();
            $table->integer('premios_aprobados')->nullable();
            $table->text('firmas')->nullable();
            $table->text('tabla_concurrente')->nullable(); // concurrent_table
            $table->text('estructura_concurrente')->nullable(); // concurrent_struct
            $table->dateTime('fecha_subproceso_inicio')->nullable(); // ts_subprocess_start
            $table->dateTime('fecha_subproceso_finalizo')->nullable(); // ts_subprocess_end
            $table->string('creado_por')->nullable(); // created_by
            $table->unsignedBigInteger('creado_por_area')->nullable(); // created_by_ou
            $table->string('creado_por_nombre_completo')->nullable(); // created_by_cn
            $table->string('creado_por_titulo')->nullable(); // created_by_title
            $table->string('nombre_mes_anio_evaluacion')->nullable();
            $table->date('fecha_inicio_evaluacion')->nullable();
            $table->date('fecha_fin_evaluacion')->nullable();

            $table->timestamps();

            // Relaciones
            $table->foreign('creado_por_area')->references('area_id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p19_incentivos');
    }
}
