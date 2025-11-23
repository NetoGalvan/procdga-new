<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP19NominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p19_nominas', function (Blueprint $table) {
            $table->bigIncrements('p19_nomina_id');
            $table->string('folio')->nullable();
            $table->unsignedBigInteger('p19_incentivo_id');
            $table->unsignedBigInteger('p19_subproceso_id');
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('id_sindicato')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->unsignedBigInteger('area_id')->nullable(); // id_business_category, business_category
            $table->string('area')->nullable();
            $table->unsignedBigInteger('sub_area_id')->nullable(); // id_business_category, business_category
            $table->string('sub_area')->nullable();
            $table->date('fecha_inicio_evaluacion')->nullable();
            $table->date('fecha_fin_evaluacion')->nullable();
            $table->text('comentarios_admin_incen')->nullable();
            $table->string('nombre_mes')->nullable();
            $table->date('fecha_inicio_siden')->nullable();
            $table->date('fecha_fin_siden')->nullable();
            $table->string('creado_por')->nullable(); // created_by
            $table->unsignedBigInteger('creado_por_area')->nullable(); // created_by_ou
            $table->string('creado_por_nombre_completo')->nullable(); // created_by_cn
            $table->string('creado_por_titulo')->nullable(); // created_by_title
            $table->timestamps();

            $table->foreign('p19_incentivo_id')->references('p19_incentivo_id')->on('p19_incentivos');
            $table->foreign('p19_subproceso_id')->references('p19_subproceso_id')->on('p19_subprocesos');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('sub_area_id')->references('area_id')->on('areas');
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
        Schema::dropIfExists('p19_nominas');
    }
}
