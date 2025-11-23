<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigosPostalesTable extends Migration
{

    public function up()
    {
        Schema::create('codigos_postales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estado_id')->nullable();
            $table->string('estado')->nullable();
            $table->integer('municipio_id')->nullable();
            $table->string('municipio')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('zona')->nullable();
            $table->string('cp')->default(true);
            $table->string('asentamiento')->default(true);
            $table->string('tipo')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigos_postales');
    }
}


