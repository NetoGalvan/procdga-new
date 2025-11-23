<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposZonasTarifariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_zonas_tarifarias', function (Blueprint $table) {
            $table->increments("tipo_zona_tarifaria_id");
            $table->string("nombre");
            $table->string("identificador");
            $table->string('tarifa_a')->nullable();
            $table->string('tarifa_b')->nullable();
            $table->string('tarifa_c')->nullable();
            $table->string('tarifa_d')->nullable();
            $table->string('tarifa_e')->nullable();
            $table->integer('tipo_ambito_id');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('tipo_ambito_id')->references('tipo_ambito_id')->on('tipos_ambitos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_zonas_tarifarias');
    }
}
