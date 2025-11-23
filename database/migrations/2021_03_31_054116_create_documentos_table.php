<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('documento_id');
            $table->string('nombre_original', 500);
            $table->string('nombre', 500)->nullable();
            $table->string('descripcion')->nullable();
            $table->string('disco', 100);
            $table->string('ruta', 500);
            $table->datetime('fecha_subida');
            $table->unsignedInteger('tipo_documento_id');
            $table->morphs('model');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('tipo_documento_id')->references('tipo_documento_id')->on('tipos_documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
