<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP23DigitalizacionTable extends Migration
{
    public function up()
    {
        Schema::create('p23_digitalizacion', function (Blueprint $table) {
            $table->increments('p23_digitalizacion_id');
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('area_creadora_id')->nullable();
            $table->unsignedInteger('p23_indice_id')->nullable();
            $table->string('folio')->unique()->nullable();
            $table->string('estatus')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            $table->string('numero_expediente')->nullable();
            $table->boolean('expediente_actual')->default(true);
            $table->string('ruta_archivo', 1000)->nullable();
            $table->string('nombre_archivo')->nullable();
            //$table->string('hash_archivo')->nullable();
            $table->date('fecha_carga')->nullable();
            //$table->string('anio_carga')->nullable();
            $table->integer('version')->nullable();
            $table->string('archivo_original')->nullable();
            $table->string('subido_por')->nullable();
            $table->string('subido_por_usuario')->nullable();
            $table->string('subido_por_ip')->nullable();
            //$table->string('uploaded_by')->nullable();
            //$table->string('uploaded_by_cn')->nullable();
            //$table->string('uploaded_by_ip')->nullable();
            $table->string('comentarios_eliminacion')->nullable();
            $table->string('creado_por')->nullable();
            $table->string('creado_por_nombre')->nullable();
            $table->string('creado_por_puesto')->nullable();
            //$table->string('created_by_bc')->nullable();
            //$table->string('nombre_area')->nullable();
            //$table->string('area_identificador')->nullable();
            //$table->string('created_by_ou_cn')->nullable();
            
            //$table->date('created_on')->nullable();

            $table->timestamps();

            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('p23_indice_id')->references('p23_indice_id')->on('p23_indice')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p23_digitalizacion');
    }
}
