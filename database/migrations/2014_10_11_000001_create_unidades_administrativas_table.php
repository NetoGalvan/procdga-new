<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesAdministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades_administrativas', function (Blueprint $table) {
            $table->increments('unidad_administrativa_id');
            $table->string('nombre');
            $table->integer('identificador')->unique();
            $table->integer('dependencia_id');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('dependencia_id')->references('dependencia_id')->on('dependencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades_administrativas');
    }
}
