<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP19SubprocesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p19_subprocesos', function (Blueprint $table) {
            $table->bigIncrements('p19_subproceso_id');
            $table->string('folio')->nullable();
            $table->unsignedBigInteger('p19_incentivo_id');
            $table->enum('estatus', ['EN_PROCESO', 'COMPLETADO', 'CANCELADO', 'SUBPROCESO_INICIO', 'SUBPROCESO_FINALIZO'])->nullable(); // work_status
            $table->unsignedBigInteger('area_id');
            $table->text('comentarios_sub_ea')->nullable();
            $table->text('tabla_concurrente')->nullable(); // concurrent_table
            $table->text('estructura_concurrente')->nullable(); // concurrent_struct
            $table->unsignedBigInteger('instancia_padre_id'); // parent_id_instance
            $table->string('folio_padre')->nullable(); // parent_folio
            $table->string('nombre_quincena')->nullable();
            $table->date('fecha_inicio_pago')->nullable();
            $table->date('fecha_fin_pago')->nullable();
            $table->text('comentarios_opera_incen')->nullable();
            $table->integer('premios_aprobados')->nullable();
            $table->string('creado_por')->nullable(); // created_by
            $table->unsignedBigInteger('creado_por_area')->nullable(); // created_by_ou
            $table->string('creado_por_nombre_completo')->nullable(); // created_by_cn
            $table->string('creado_por_titulo')->nullable(); // created_by_title
            $table->string('nombre_mes_anio_evaluacion')->nullable();
            $table->date('fecha_inicio_evaluacion')->nullable();
            $table->date('fecha_fin_evaluacion')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('p19_incentivo_id')->references('p19_incentivo_id')->on('p19_incentivos');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('instancia_padre_id')->references('instancia_id')->on('instancias');
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
        Schema::dropIfExists('p19_subprocesos');
    }
}
