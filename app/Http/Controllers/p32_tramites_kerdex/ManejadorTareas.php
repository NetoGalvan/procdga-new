<?php

namespace App\Http\Controllers\p32_tramites_kerdex;

use App\Http\Traits\RegistroInstancias;
use App\Models\Proceso;
use App\Models\Area;
use App\Models\EntidadFederativa;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Carbon;

trait ManejadorTareas
{
    use RegistroInstancias;

    public function guardarTareaT01($tramiteKardex, $request) {
        $user = Auth::user();

        $datosEmpleado  = json_decode($request->datos_empleado);
        $entidad        = EntidadFederativa::where('entidad_federativa_id', $request->entidad_id )
                                ->where('activo', true)->first();

        $tramiteKardex->tipo_tramite_kardex_id       = $request->tipo_tramite_kardex_id;
        $tramiteKardex->numero_empleado              = $datosEmpleado->numero_empleado;
        $tramiteKardex->nombre                       = $datosEmpleado->nombre;
        $tramiteKardex->apellido_paterno             = $datosEmpleado->apellido_paterno;
        $tramiteKardex->apellido_materno             = $datosEmpleado->apellido_materno;
        $tramiteKardex->nombre_completo              = $datosEmpleado->nombre_completo;
        $tramiteKardex->rfc                          = $datosEmpleado->rfc;
        $tramiteKardex->curp                         = $request->curp;
        $tramiteKardex->puesto                       = $datosEmpleado->puesto;
        $tramiteKardex->codigo_puesto                = $datosEmpleado->codigo_puesto;
        $tramiteKardex->nivel_salarial               = $datosEmpleado->nivel_salarial;
        $tramiteKardex->fecha_alta_empleado          = $datosEmpleado->fecha_alta_empleado;
        $tramiteKardex->unidad_administrativa        = $datosEmpleado->unidad_administrativa;
        $tramiteKardex->unidad_administrativa_nombre = $datosEmpleado->unidad_administrativa_nombre;
        $tramiteKardex->solicitante                  = $datosEmpleado->nombre_completo;

        $tramiteKardex->calle                   = $request->calle;
        $tramiteKardex->numero_exterior         = $request->numero_exterior;
        $tramiteKardex->numero_interior         = $request->numero_interior;
        $tramiteKardex->ciudad                  = $request->ciudad;
        $tramiteKardex->colonia                 = $request->colonia;
        $tramiteKardex->cp                      = $request->cp;
        $tramiteKardex->municipio_alcaldia      = $request->municipio_alcaldia;
        $tramiteKardex->entidad_id              = isset($entidad->entidad_federativa_id) ? $entidad->entidad_federativa_id : null;
        $tramiteKardex->area_id                 = isset($user->area->area_id) ? $user->area->area_id : null;
        $tramiteKardex->revisado_por_usuario    = $user->id;

        $tramiteKardex->fecha_elaboracion_tramite = now();

        $documentos =[
            "identificacion_oficial"    => $request->identificacion_oficial == "on" ? true : false,
            "recibo_nomina"             => $request->recibo_nomina == "on" ? true : false,
            "comprobante_domicilio"     => $request->comprobante_domicilio == "on" ? true : false,
        ];
        $tramiteKardex->documentos      = json_encode($documentos);

        return $tramiteKardex->save();
    }

    public function guardarTareaT02($tramiteKardex, $request) {
        $userId = Auth::user()->id;
        return $tramiteKardex->update([
            'asignado_a_usuario' => $request->tecnico_operativo_kardex,
            'autorizado_por_usuario' => $userId,
        ]);
    }

    public function guardarTareaT03HojasServicio($tramiteKardex, $request) {
        return $tramiteKardex->update([
            'observaciones' => $request->observaciones
        ]);
    }

    public function guardarTareaT03ComprobantesServicio($tramiteKardex, $request) {

        $camposExtra = [
            'tramite' => $request->tramite,
            'sueldo_base' => $request->sueldo_base,
            'sueldo_total' => $request->sueldo_total,
            'prima_quincenal' => $request->prima_quincenal,
            'convenio' => $request->convenio,
            'descripcion_convenio' => $request->descripcion_convenio
        ];

        return $tramiteKardex->update([
            'campos_extra' => json_encode($camposExtra),
            'unidad_administrativa_nombre' => $request->unidad_administrativa_nombre,
            'puesto' => $request->puesto,
        ]);
    }

    public function guardarTareaT04($tramiteKardex, $request) {
        return $tramiteKardex->update([
            'estatus' => 'COMPLETADO'
        ]);
    }

    public function guardarTareaT04Firmas($tramiteKardex, $request) {

        if ($request->usuario_verifico == "" || $request->usuario_autorizo == "" ) {
            return false;
        } else {
            $firmas =[
                "usuario_verifico"    => $request->usuario_verifico,
                "usuario_autorizo"    => $request->usuario_autorizo,
            ];
            $tramiteKardex->firmas    = json_encode($firmas);
            return $tramiteKardex->save();
        }

    }

    public function guardarTramiteReasignacion($tramiteKardex, $request) {
        return $tramiteKardex->update([
            'asignado_a_usuario' => $request->tecnico_operativo_kardex
        ]);
    }

}
