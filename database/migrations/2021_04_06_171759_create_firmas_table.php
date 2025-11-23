<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmas', function (Blueprint $table) {
            $table->increments('firma_id');
            $table->text('cadena_original')->nullable();
            $table->string('folio_consulta', 50)->nullable();
            $table->string('nombre_completo', 50)->nullable();
            $table->string('rfc', 15)->nullable();
            $table->text('sello')->nullable();
            $table->date('fecha_firma')->nullable();
            $table->string('ruta_firma')->nullable();
            $table->unsignedInteger('tipo_firma_id')->nullable();
            $table->unsignedInteger('rol_id')->nullable();
            $table->morphs('usuario');
            $table->morphs('model');
            $table->timestamps();

            $table->foreign('tipo_firma_id')->references('tipo_firma_id')->on('tipos_firmas')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('public.roles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firmas');
    }
}
