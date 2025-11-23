<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP23DetalleDigitalizacionTable extends Migration
{
    public function up()
    {
        Schema::create('p23_detalle_digitalizacion', function (Blueprint $table) {
            $table->increments('p23_detalle_digitalizacion_id');
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('p23_digitalizacion_id')->nullable();
            $table->string('folio')->nullable();
            $table->string('documento')->nullable();
            $table->string('hojas')->nullable();
            //$table->string('folio_prestamo_fisico')->unique()->nullable();
            $table->string('creado_por')->nullable();
            $table->string('creado_por_nombre')->nullable();
            $table->string('creado_por_puesto')->nullable();
            $table->unsignedInteger('area_creadora_id')->nullable();
            /*
            $table->string('created_by')->nullable();
            $table->string('created_by_cn')->nullable();
            $table->string('created_by_bc')->nullable();
            $table->string('created_by_bc_cn')->nullable();
            $table->string('created_by_ou')->nullable();
            $table->string('created_by_ou_cn')->nullable();
            $table->string('created_by_title')->nullable();
            */
            //$table->date('created_on')->nullable();

            $table->timestamps();

            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('p23_digitalizacion_id')->references('p23_digitalizacion_id')->on('p23_digitalizacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p23_detalle_digitalizacion');
    }
}
