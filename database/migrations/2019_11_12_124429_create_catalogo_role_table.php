<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogoRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_role', function (Blueprint $table) {
            $table->increments('catalogo_role_id');
            $table->unsignedInteger('catalogo_id')->index();
            $table->unsignedInteger('role_id')->index();
            $table->timestamps();

            $table->foreign('catalogo_id')->references('catalogo_id')->on('catalogos')->onDelete('cascade');
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
        Schema::dropIfExists('catalogo_role');
    }
}
