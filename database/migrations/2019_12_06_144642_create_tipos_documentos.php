<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_documentos', function (Blueprint $table) {
            $table->increments('tipo_documento_id');
            $table->string('nombre', 500);
            $table->string('identificador')->nullable();
            $table->integer('proceso_id');
            $table->string('nombre_grupo');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('proceso_id')->references('proceso_id')->on('procesos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_documentos');
    }
}
