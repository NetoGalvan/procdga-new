<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToP06ServicioSocial extends Migration
{
    public function up()
    {
        Schema::table('p06_servicio_social', function (Blueprint $table) {
            $table->string("direccion_ejecutiva")->nullable();
            $table->string("coordinacion")->nullable();
        });
    }
}
