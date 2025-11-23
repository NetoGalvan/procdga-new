<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P06DetalleArchivosTable extends Migration
{
    public function up()
    {
        Schema::create('p06_detalle_archivos', function (Blueprint $table) {
            $table->increments('detalle_archivo_id');
            $table->unsignedInteger('servicio_social_id');
            $table->string('tipo_archivo', 100)->nullable();
            $table->string('descripcion', 50000)->nullable();
            $table->string('fecha_detalle')->nullable();
            $table->string('ruta_archivo', 50000)->nullable();
            $table->string('nombre_archivo', 1000)->nullable();
            $table->integer('horas_asistencia')->nullable();
            
            $table->timestamps();

            $table->foreign('servicio_social_id')->references('servicio_social_id')->on('p06_servicio_social');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_detalle_archivos');
    }
}
