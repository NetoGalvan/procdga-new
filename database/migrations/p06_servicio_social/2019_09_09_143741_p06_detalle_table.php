<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06DetalleTable extends Migration
{
    public function up()
    {
        Schema::create('p06_detalle', function (Blueprint $table) {
            $table->increments('detalle_id');
            $table->unsignedInteger('servicio_social_id');
            $table->string('fecha_comentario')->nullable();
            $table->string('comentario', 50000)->nullable();
            $table->string('informe', 500)->nullable();
            $table->timestamps();

            $table->foreign('servicio_social_id')->references('servicio_social_id')->on('p06_servicio_social');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_detalle');
    }
}
