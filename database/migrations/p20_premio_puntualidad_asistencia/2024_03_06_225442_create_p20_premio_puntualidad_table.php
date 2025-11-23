<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP20PremioPuntualidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p20_premio_puntualidad', function (Blueprint $table) {
            $table->bigIncrements('premio_puntualidad_id');
            $table->string('folio')->unique()->nullable();
            $table->enum('estatus', ['EN_PROCESO', 'RECHAZADO', 'COMPLETADO', 'CANCELADO'])->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('quincena')->nullable();
            $table->text('instrucciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('fecha_inicio_pago')->nullable();
            $table->string('fecha_fin_pago')->nullable();
            $table->string('firmas')->nullable();
            $table->json('estructura_concurrente')->nullable();
            $table->string('subproceso_inicio')->nullable();//timestamp ts_subprocess_start
            $table->string('subproceso_fin')->nullable();//timestamp ts_subprocess_end
            $table->string('creado_por')->nullable();
            $table->string('creado_por_area')->nullable();
            $table->string('creado_por_titulo')->nullable();

            $table->timestamps();

            $table->foreign('area_id')->references('area_id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p20_premio_puntualidad');
    }
}
