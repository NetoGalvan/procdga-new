<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->increments('municipio_id');
            $table->string('nombre');
            $table->integer('entidad_federativa_id');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('entidad_federativa_id')->references('entidad_federativa_id')->on('entidades_federativas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
}
