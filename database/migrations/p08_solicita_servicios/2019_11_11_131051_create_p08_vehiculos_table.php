<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP08VehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p08_vehiculos', function (Blueprint $table) {
            $table->increments('p08_vehiculo_id');
            $table->unsignedInteger('area_id')->nullable();
            $table->enum('estatus_vehiculo', ['ASIGNADO', 'LIBRE', 'DESHABILITADO'])->nullable(); //'ASIGNADO' = 'Asignado a una unidad', 'LIBRE' = 'Disponible', 'DESHABILITADO' = 'Dado de alta pero aún sin asignación'.
            $table->string('placa')->unique()->nullable();
            $table->string('marca')->nullable();
            $table->string('submarca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('nombre_conductor')->nullable();
            $table->string('numero_motor')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('numero_economico')->nullable();
            $table->integer('cilindros')->nullable();
            $table->string('color')->nullable();
            $table->string('copia_factura')->nullable();
            $table->string('copia_tarjeta_circulacion')->nullable();
            $table->string('numero_tarjeta_combustible')->nullable();
            $table->string('tipo_vehiculo')->nullable();
            $table->text('documentos_alta')->nullable();
            $table->text('documentos_baja')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            //Relaciones
            $table->foreign('area_id')->references('area_id')->on('areas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p08_vehiculos');
    }
}
