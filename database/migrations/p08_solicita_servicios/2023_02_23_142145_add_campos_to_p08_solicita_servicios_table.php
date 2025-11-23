<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToP08SolicitaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p08_solicita_servicios', function (Blueprint $table) {
            $table->string('contacto_correo')->nullable();
            $table->string('ext_servicio')->nullable();
            $table->unsignedInteger('creado_por_usuario')->nullable();
            $table->string('creado_por_nombre_completo')->nullable();
            $table->boolean('urgente')->default(false);

            $table->foreign('creado_por_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p08_solicita_servicios', function (Blueprint $table) {
            //
        });
    }
}
