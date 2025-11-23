<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP02TramitesIsssteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p02_tramites_issste', function (Blueprint $table) {
            $table->increments('tramite_issste_id');
            $table->enum('estatus', ['EN_PROCESO', 'EN_PAUSA', 'COMPLETADO', 'RECHAZADO', 'CANCELADO'])->nullable();
            $table->string('folio')->nullable();
            $table->string('quincena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p02_tramites_issste');
    }
}
