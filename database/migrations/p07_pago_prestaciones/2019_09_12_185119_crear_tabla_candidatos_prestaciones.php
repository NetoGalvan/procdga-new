<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCandidatosPrestaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('p07_candidatos_prestaciones', function (Blueprint $table) {
            $table->increments('candidato_prestacion_id')->unique();
            $table->integer('pago_prestacion_id')->nullable();
            $table->integer('subproceso_id')->nullable();
            $table->integer('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('identificador_unidad')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->string('unidad_administrativa')->nullable();
            $table->string('unidad_administrativa_nombre')->nullable();
            $table->integer('seccion_sindical')->nullable();
            $table->string('campos_adicionales', 1000)->nullable();
            $table->string('comentarios_instruccion')->nullable();
            $table->unsignedBigInteger('usuario_capturo_id')->nullable();
            $table->unsignedBigInteger('usuario_autorizo_id')->nullable();
            $table->timestamps();

            $table->foreign('pago_prestacion_id')->references('pago_prestacion_id')->on('p07_pago_prestaciones');
            $table->foreign('subproceso_id')->references('subproceso_id')->on('p07_subprocesos');
            $table->foreign('area_id')->references('area_id')->on('areas');
            $table->foreign('usuario_capturo_id')->references('id')->on('users');
            $table->foreign('usuario_autorizo_id')->references('id')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p07_candidatos_prestaciones');
    }
}
