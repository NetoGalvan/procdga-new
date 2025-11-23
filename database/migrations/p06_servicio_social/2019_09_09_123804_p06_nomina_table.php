<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class P06NominaTable extends Migration
{
    public function up()
    {
        Schema::create('p06_nomina', function (Blueprint $table) {
            $table->increments('nomina_id');
            $table->string('folio')->unique()->nullable();
            $table->string('tipo_validacion')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('observaciones')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('p06_nomina');
    }
}
