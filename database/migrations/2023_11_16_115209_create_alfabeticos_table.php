<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlfabeticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alfabeticos', function (Blueprint $table) {
            $table->increments('alfabetico_id');
            $table->enum('estatus', ['EN_PROCESO', 'COMPLETADO', 'CANCELADO'])->nullable();
            $table->string('folio')->unique()->nullable();
            $table->string('quincena')->nullable();
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('alfabeticos');
    }
}
