<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12TramitesNotasBuenas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_tramites_notas_buenas', function (Blueprint $table) {
            $table->increments('tramite_nota_buena_id');
            $table->integer('tramite_incidencia_id');
            $table->enum('estatus', ['EN_PROCESO', 'COMPLETADO', 'RECHAZADO', 'CANCELADO']);
            $table->string("folio")->nullable();
            $table->integer('area_id');
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('tramite_incidencia_id')->references('tramite_incidencia_id')->on('p12_tramites_incidencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p12_tramites_notas_buenas');
    }
}
