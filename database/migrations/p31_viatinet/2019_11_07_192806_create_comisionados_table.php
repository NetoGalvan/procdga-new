<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p31_comisionados', function (Blueprint $table) {
            $table->increments('comisionado_id');
            $table->unsignedInteger('solicitud_viatico_id');
            $table->Integer('numero_empleado');
            $table->string('rfc');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('puesto');
            $table->string('nivel_salarial');
            $table->decimal('total_autorizado')->nullable();
            $table->timestamps();

            $table->foreign('solicitud_viatico_id')->references('solicitud_viatico_id')->on('p31_solicitudes_viaticos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p31_comisionados');
    }
}
