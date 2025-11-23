<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP15BiometricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p15_biometricos', function (Blueprint $table) {
            $table->increments("biometrico_id");
            $table->string("nombre");
            $table->string("acceso")->nullable();
            $table->string("ip")->nullable();
            $table->enum("tipo", ["DACTILAR", "FACIAL"]);
            $table->string("ubicacion")->nullable();
            $table->boolean("activo")->default(true);
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
        Schema::dropIfExists('p15_biometricos');
    }
}
