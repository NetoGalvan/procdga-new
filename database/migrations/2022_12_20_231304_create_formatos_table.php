<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formatos', function (Blueprint $table) {
            $table->increments("formato_id");
            $table->string("identificador");
            $table->boolean("es_principal")->default(false);
            $table->string("logo_principal");
            $table->string("logo_secundario")->nullable();
            $table->string("logo_pie")->nullable();
            $table->string("texto_encabezado");
            $table->string("texto_pie");
            $table->boolean("activo");
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
        Schema::dropIfExists('formatos');
    }
}
