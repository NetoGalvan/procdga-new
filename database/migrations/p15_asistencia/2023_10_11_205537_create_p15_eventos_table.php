<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateP15EventosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_eventos', function (Blueprint $table) {
            $table->bigIncrements("evento_id");
            $table->integer("biometrico_id");
            $table->string("rfc")->nullable();
            $table->integer("numero_empleado");
            $table->datetime("fecha");
            $table->integer("biometrico_archivo_id")->nullable();
            $table->timestamps();

            $table->foreign('biometrico_id')->references('biometrico_id')->on('p15_biometricos');
            $table->foreign('biometrico_archivo_id')->references('biometrico_archivo_id')->on('p15_biometricos_archivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p15_eventos');
    }


}
