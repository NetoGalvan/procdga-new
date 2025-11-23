<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP32TiposTramiteKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p32_tipos_tramite_kardex', function (Blueprint $table) {
            $table->increments('tipo_tramite_kardex_id');
            $table->string('nombre');
            $table->string('clave');
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
        Schema::dropIfExists('p32_tipos_tramite_kardex');
    }
}
