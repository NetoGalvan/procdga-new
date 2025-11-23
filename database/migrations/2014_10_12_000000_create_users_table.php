<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('email')->unique();
            $table->string('nombre_usuario')->unique();
            $table->bigInteger('numero_empleado');
            $table->string('rfc')->unique();
            $table->string('curp')->unique();
            $table->string('puesto');
            $table->integer('area_id');
            $table->string('password');
            $table->boolean('change_password')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('empleado_id')->nullable();
            $table->enum('tipo_registro', ["MANUAL", "EXISTENTE"])->default("MANUAL");
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('empleado_id')->references('empleado_id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
