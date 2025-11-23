<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasProcesosTable extends Migration
{
    public function up()
    {
        Schema::create('areas_procesos', function (Blueprint $table) {
            $table->bigIncrements('areas_procesos_id');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->integer('zona_pagadora');
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('proceso_id')->references('proceso_id')->on('procesos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('areas_procesos');
    }
}
