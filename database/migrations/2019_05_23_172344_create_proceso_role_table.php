<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_role', function (Blueprint $table) {
            $table->increments('proceso_role_id');
            $table->integer('proceso_id');
            $table->integer('role_id');
            $table->boolean('inicializa_proceso')->default(false);
            $table->timestamps();

            $table->foreign('proceso_id')->references('proceso_id')->on('procesos')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proceso_role');
    }
}
