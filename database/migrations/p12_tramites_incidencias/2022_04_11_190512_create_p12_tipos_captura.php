<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP12TiposCaptura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12_tipos_captura', function (Blueprint $table) {
            $table->increments('tipo_captura_id');
            $table->string('nombre')->nullable();
            $table->string('identificador')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true)->nullable();
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
        Schema::dropIfExists('p12_tipos_captura');
    }
}
