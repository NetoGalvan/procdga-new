<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP23IndiceTable extends Migration
{
    public function up()
    {
        Schema::create('p23_indice', function (Blueprint $table) {
            $table->increments('p23_indice_id');
            $table->unsignedInteger('area_creadora_id')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('folio')->unique()->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            $table->string('numero_expediente')->unique()->nullable();
            $table->boolean('disponible')->default(true);
            $table->string('estatus_devolucion')->nullable();
            //$table->string('ubicacion_archivo')->nullable();
            $table->json('notas')->nullable();
            $table->string('creado_por')->nullable();
            $table->string('creado_por_nombre')->nullable();
            //$table->string('created_by_bc')->nullable();
            //$table->string('created_by_bc_cn')->nullable();
            //$table->string('created_by_ou')->nullable();
            //$table->string('created_by_ou_cn')->nullable();
            $table->string('creado_por_puesto')->nullable();


            //$table->date('created_on')->nullable();

            $table->timestamps();
            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p23_indice');
    }
}
