<?php

namespace App\Http\Controllers\p23_solicitud_expediente;

use App\Http\Traits\RegistroInstancias;
use App\Models\Proceso;
use DB;
use App\Models\p23_solicitud_expediente\P23Indice;
use App\Models\p23_solicitud_expediente\P23Solicitud;
use App\Models\p23_solicitud_expediente\P23Digitalizacion;
use App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion;

trait ManejadorTareasSolicitud{

    use RegistroInstancias;

    public function guardarTSOL01($request, $datos_empleado, $solicitud, $datosCreador){
        // dd($request, $datos_empleado, "mane");
        try {
            DB::beginTransaction();

                if ($datos_empleado != null) {
                    $solicitud->p23_indice_id = $datos_empleado->p23_indice_id;
                    $solicitud->numero_empleado = $datos_empleado->numero_empleado;
                    $solicitud->nombre_empleado = $datos_empleado->nombre_empleado;
                    $solicitud->apellido_paterno = $datos_empleado->apellido_paterno;
                    $solicitud->apellido_materno = $datos_empleado->apellido_materno;
                    $solicitud->rfc = $datos_empleado->rfc;
                    $solicitud->numero_expediente = $datos_empleado->numero_expediente;
                }

                $solicitud->tipo_solicitud = $request['tipo_expediente'];
                $solicitud->comentarios_ini_exp = $request['comentarios'];
                $solicitud->tipo_solicitante = $request['tipo_solicitante'];
                $solicitud->nombre_solicitante = $request['nombre'];
                $solicitud->cargo_solicitante = $request['cargo'];
                $solicitud->ua_solicitante = $request['unidad_administrativa'];
                $solicitud->dependencia_solicitante = $request['dependencia'];
                $solicitud->referencia_oficio_solicitante = $request['referencia_u_oficio'];
                $solicitud->parentesco_solicitante = $request['parentesco'];
                $solicitud->razon_solicitante = $request['razon_solicitud'];

                $solicitud->created_by = $datosCreador->nombre_usuario;
                $solicitud->created_by_cn = $datosCreador->nombre_usu . " " . $datosCreador->apellido_paterno . " " . $datosCreador->apellido_materno;
                // $solicitud->created_by_bc = $datosCreador->identificador_unidad_area;
                $solicitud->created_by_bc_cn = $datosCreador->nombre_area;
                $solicitud->created_by_ou = $datosCreador->cn;
                // $solicitud->created_by_ou_cn = $datosCreador->ou;
                $solicitud->created_by_title = $datosCreador->puesto;
                $solicitud->created_on = now();
                $solicitud->save();

            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'La tarea finalizó correctamente.' ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error al guardar la información: ' . $th ];
        }
    }

}
