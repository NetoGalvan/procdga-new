<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlazasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plazas', function (Blueprint $table) {
            $table->bigIncrements('plaza_id');
            $table->string('numero_plaza')->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->string('subunidad')->nullable();
            $table->string('direccion_administrativa')->nullable();
            $table->string('subdireccion')->nullable();
            $table->string('jud')->nullable();
            $table->string('oficina')->nullable();
            $table->string('codigo_puesto')->nullable();
            $table->string('nivel_salarial')->nullable();
            $table->string('codigo_universo')->nullable();
            $table->text('puesto')->nullable();
            $table->text('desc_puesto')->nullable();
            $table->string('codigo_situacion_empleado')->nullable();
            $table->string('last_modified')->nullable();
            $table->boolean('activo')->default(false);
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
        Schema::dropIfExists('plazas');
    }
}
