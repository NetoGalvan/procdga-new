<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15BiometricosArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_biometricos_archivos', function (Blueprint $table) {
            $table->increments("biometrico_archivo_id");
            $table->integer("biometrico_id");
            $table->date("fecha");
            $table->integer("total_eventos")->nullable();
            $table->json("eventos")->nullable();
            $table->string("nombre");
            $table->string("ruta");
            $table->string("disco");
            $table->timestamps();

            $table->foreign("biometrico_id")->references("biometrico_id")->on("p15_biometricos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p15_biometricos_archivos');
    }
}
