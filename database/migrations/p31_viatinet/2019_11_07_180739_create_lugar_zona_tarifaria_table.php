<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLugarZonaTarifariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lugar_zona_tarifaria', function (Blueprint $table) {
            $table->increments("lugar_zona_tarifaria_id");
            $table->integer('tipo_zona_tarifaria_id');
            $table->integer('model_id');
            $table->string("model_type");
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('tipo_zona_tarifaria_id')->references('tipo_zona_tarifaria_id')->on('tipos_zonas_tarifarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lugar_zona_tarifaria');
    }
}
