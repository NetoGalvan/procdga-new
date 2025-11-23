<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReporteRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_role', function (Blueprint $table) {
            $table->increments('reporte_role_id');
            $table->unsignedInteger('reporte_id')->index();
            $table->unsignedInteger('role_id')->index();
            $table->timestamps();

            $table->foreign('reporte_id')->references('reporte_id')->on('reportes')->onDelete('cascade');
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
        Schema::dropIfExists('reporte_role');
    }
}
