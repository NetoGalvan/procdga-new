<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06InstitucionTable extends Migration
{

    public function up()
    {
        Schema::create('p06_instituciones', function (Blueprint $table) {
            $table->increments('institucion_id');
            $table->string('nombre_institucion')->nullable();
            $table->string('acronimo_institucion')->nullable();
            $table->string('clave_institucion')->nullable();
            $table->boolean('activo')->default(true)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_instituciones');
    }
}
