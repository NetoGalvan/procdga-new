<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP23SolicitudTable extends Migration
{
    public function up()
    {
        Schema::create('p23_solicitud', function (Blueprint $table) {
            $table->increments('p23_solicitud_id');
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('area_creadora_id')->nullable();
            $table->unsignedInteger('p23_indice_id')->nullable();
            $table->string('folio')->unique()->nullable();
            $table->string('estatus')->nullable();
            $table->string('numero_empleado')->nullable();
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            //$table->string('fuente')->nullable();
            $table->string('numero_expediente')->nullable();
            $table->string('tipo_solicitud')->nullable();
            $table->string('comentarios_ini_exp')->nullable();
            $table->string('estatus_ctrl_exp')->nullable();
            $table->string('tipo_solicitante')->nullable();
            $table->string('nombre_solicitante')->nullable();
            $table->string('cargo_solicitante')->nullable();
            $table->string('ua_solicitante')->nullable();
            $table->string('dependencia_solicitante')->nullable();
            $table->string('referencia_oficio_solicitante')->nullable();
            $table->string('parentesco_solicitante')->nullable();
            $table->string('razon_solicitante')->nullable();
            $table->string('comentarios_ctrl_exp')->nullable();
            $table->string('ctrl_exp_cn')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->string('lugar_entrega')->nullable();
            $table->string('hora_entrega')->nullable();
            $table->string('comentarios_oper_exp')->nullable();
            $table->string('archivo_respuesta_digital')->nullable();
            $table->string('archivo_original')->nullable();
            $table->string('comentarios_solicitud_digital')->nullable();
            $table->string('uploaded_by_cn')->nullable();
            $table->string('uploaded_by_ip')->nullable();
            $table->date('uploaded_on')->nullable();
            $table->date('fecha_devolucion')->nullable();
            $table->string('nombre_quien_recibio')->nullable();
            $table->string('paginas_expediente')->nullable();
            $table->string('clave_entrega')->nullable();
            $table->string('numero_identificacion')->nullable();
            $table->string('status_expediente')->nullable();
            $table->string('entrego_cn')->nullable();
            $table->string('status_devolucion')->nullable();
            $table->string('comentario_devolucion')->nullable();
            $table->string('recibio_cn')->nullable();
            $table->string('created_by')->nullable();
            $table->string('created_by_cn')->nullable();
            $table->string('created_by_bc')->nullable();
            $table->string('created_by_bc_cn')->nullable();
            $table->string('created_by_ou')->nullable();
            $table->string('created_by_ou_cn')->nullable();
            $table->string('created_by_title')->nullable();
            $table->date('created_on')->nullable();
            $table->string('aprobado_by')->nullable();
            $table->string('aprobado_by_cn')->nullable();
            $table->string('aprobado_by_bc')->nullable();
            $table->string('aprobado_by_bc_cn')->nullable();
            $table->string('aprobado_by_ou')->nullable();
            $table->string('aprobado_by_ou_cn')->nullable();
            $table->string('aprobado_by_title')->nullable();
            $table->date('aprobado_on')->nullable();
            $table->string('operado_by')->nullable();
            $table->string('operado_by_cn')->nullable();
            $table->string('operado_by_bc')->nullable();
            $table->string('operado_by_bc_cn')->nullable();
            $table->string('operado_by_ou')->nullable();
            $table->string('operado_by_ou_cn')->nullable();
            $table->string('operado_by_title')->nullable();
            $table->date('operado_on')->nullable();
            $table->string('detalle_prestamo_fisico')->nullable();
            $table->string('recibido_by')->nullable();
            $table->string('recibido_by_cn')->nullable();
            $table->string('recibido_by_bc')->nullable();
            $table->string('recibido_by_bc_cn')->nullable();
            $table->string('recibido_by_ou')->nullable();
            $table->string('recibido_by_ou_cn')->nullable();
            $table->string('recibido_by_title')->nullable();
            $table->date('recibido_on')->nullable();
            $table->string('status_confirmacion')->nullable();
            $table->string('conf_status_devolucion')->nullable();
            $table->string('conf_comentario_devolucion')->nullable();
            $table->string('comentarios_rechazo_operador')->nullable();
            $table->string('solicitud_original')->nullable();
            $table->string('last_status_expediente')->nullable();
            $table->string('conf_status_expediente')->nullable();

            $table->timestamps();

            $table->foreign('area_creadora_id')->references('area_id')->on('areas')->onDelete('cascade');
            $table->foreign('p23_indice_id')->references('p23_indice_id')->on('p23_indice')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('p23_solicitud');
    }
}
