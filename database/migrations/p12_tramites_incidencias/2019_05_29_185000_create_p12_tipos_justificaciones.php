<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP12TiposJustificaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_tipos_justificaciones', function (Blueprint $table) {
            $table->increments('tipo_justificacion_id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('identificador');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p12_tipos_justificaciones');
    }
}
