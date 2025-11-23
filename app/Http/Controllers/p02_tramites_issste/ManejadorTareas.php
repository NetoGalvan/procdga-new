<?php

namespace App\Http\Controllers\p02_tramites_issste;

use App\Http\Traits\RegistroInstancias;
use App\Models\Instancia;
use App\models\EntidadFederativa;
use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\p02_tramites_issste\TramiteIsssteDetalle;
use App\Models\p02_tramites_issste\TipoMovimientoIssste;
use App\Models\p02_tramites_issste\TipoNombramiento;
use Illuminate\Support\Facades\DB;

trait ManejadorTareas
{
    use RegistroInstancias;

    public function agregarDatosDeMovimientosPersonalAlProcesoTramitesIssste($tramiteIssste) {
        // Obtenemos los Movimientos a enviar
        $movimientosPersonal = MovimientoPersonal::where('estatus_issste', 'LISTO')->get();
        foreach ($movimientosPersonal as $movimientoPersonal) {
            // Primero Actualizamos el estatus_issste del MoviminetoDePersonal
            $movimientoPersonal->update([
                'estatus_issste' => 'EN_PROCESO'
            ]);
            // Después vamos creando los Detalles del los folios a reportar al ISSSTE
            $detalle = new TramiteIsssteDetalle();
            $detalle->tramite_issste_id = $tramiteIssste->tramite_issste_id;
            $detalle->folio_p01 = $movimientoPersonal->instancia->folio;
            $detalle->nombre_empleado = $movimientoPersonal->nombre_empleado;
            $detalle->apellido_paterno = $movimientoPersonal->apellido_paterno;
            $detalle->apellido_materno = $movimientoPersonal->apellido_materno;
            $detalle->calle = $movimientoPersonal->calle;
            $detalle->ciudad = $movimientoPersonal->ciudad;
            $detalle->colonia = $movimientoPersonal->colonia;
            $detalle->cp = $movimientoPersonal->cp;
            $detalle->numero_exterior = $movimientoPersonal->numero_exterior;
            $detalle->numero_interior = $movimientoPersonal->numero_interior;
            $detalle->rfc = $movimientoPersonal->rfc;
            $detalle->curp = $movimientoPersonal->curp;
            $detalle->municipio_alcaldia = $movimientoPersonal->municipio_alcaldia;
            $detalle->fecha_alta = $movimientoPersonal->fecha_alta;
            $detalle->fecha_baja = $movimientoPersonal->fecha_baja;
            $detalle->numero_empleado = $movimientoPersonal->numero_empleado;
            $detalle->fecha_nacimiento = $movimientoPersonal->fecha_nacimiento;
            $detalle->numero_seguridad_social = $movimientoPersonal->numero_seguridad_social;
            $detalle->pagaduria = $movimientoPersonal->pagaduria;
            $detalle->qna_procesado = $movimientoPersonal->qna_procesado;
            $detalle->estatus_issste = $movimientoPersonal->estatus_issste;
            $detalle->nivel_salarial = $movimientoPersonal->nivel_salarial;

            $detalle->entidad_federativa_domicilio_id = $movimientoPersonal->entidad_federativa_domicilio_id;
            $detalle->entidad_federativa_nacimiento_id = $movimientoPersonal->entidad_federativa_nacimiento_id;
            $detalle->sexo_id = $movimientoPersonal->sexo_id;
            $detalle->tipo_movimiento_id = $movimientoPersonal->tipo_movimiento_id;
            $detalle->clave_cobro = 30;
            $detalle->clave_ramo = 9999999;

            $detalle->save();
        }
    }

    public function guardarTareaT01($tramiteIssste, $request) {
        $tramiteIssste->quincena = $request->qna_issste;
        $tramiteIssste->save();

        foreach($request->movimientos as $movimiento) {
            $detalle = TramiteIsssteDetalle::find($movimiento["detalle_id"]);
            $detalle->movimientoPersonal->estatus_issste = "LISTO";
            $detalle->movimientoPersonal->save();
            $detalle->update([
                // Datos Generales
                'estatus_issste' => 'LISTO',
                'qna_issste' => $request->qna_issste,
                'tipo_movimiento_issste_id' => $movimiento["tipo_movimiento_issste_id"],
                // Dirección del Empleado
                'cp' => $movimiento["cp"],
                'colonia' => $movimiento["colonia"],
                'ciudad' => $movimiento["ciudad"],
                'municipio_alcaldia' => $movimiento["municipio_alcaldia"],
                'entidad_federativa_domicilio_id' => $movimiento["entidad_federativa_domicilio_id"],
                'calle' => $movimiento["calle"],
                'numero_exterior' => $movimiento["numero_exterior"],
                'numero_interior' => $movimiento["numero_interior"],
                // Datos Salariales
                'clave_cobro' => $movimiento["clave_cobro"],
                'clave_ramo' => $movimiento["clave_ramo"],
                /* 'pagaduria' => $movimiento["pagaduria"], */
                'sueldo_cotizable' => $movimiento["sueldo_cotizable"],
                'sueldo_sar' => $movimiento["sueldo_sar"],
                'sueldo_total' => $movimiento["sueldo_total"],
                'tipo_nombramiento_id' => $movimiento["tipo_nombramiento_id"],
            ]);
        }
    }

    public function guardarTareaT02($tramiteIssste, $request) {
        foreach($request->movimientos as $movimiento) {
            $detalle = TramiteIsssteDetalle::find($movimiento["detalle_id"]);
            if ($movimiento["estatus_issste"] == "ACEPTADO") {
                $detalle->movimientoPersonal->estatus_issste = "COMPLETADO";
                $detalle->estatus_issste = "COMPLETADO";
            } else if ($movimiento["estatus_issste"] == "RECHAZADO") {
                $detalle->movimientoPersonal->estatus_issste = "RECHAZADO";
                $detalle->estatus_issste = "RECHAZADO";
                $detalle->motivo_rechazo = $movimiento["motivo_rechazo"];
            }
            $detalle->movimientoPersonal->save();
            $detalle->save();
        }
    }

    public function guardarTareaTR03($tramiteIssste, $request) {
        $tramiteIssste->quincena = $request->qna_issste;
        $tramiteIssste->save();

        foreach($request->movimientos as $movimiento) {
            $detalle = TramiteIsssteDetalle::find($movimiento["detalle_id"]);
            $detalle->movimientoPersonal->estatus_issste = "LISTO";
            $detalle->movimientoPersonal->save();
            $detalle->update([
                // Datos Generales
                'estatus_issste' => 'LISTO',
                'qna_issste' => $request->qna_issste,
                'tipo_movimiento_issste_id' => $movimiento["tipo_movimiento_issste_id"],
                // Dirección del Empleado
                'cp' => $movimiento["cp"],
                'colonia' => $movimiento["colonia"],
                'ciudad' => $movimiento["ciudad"],
                'municipio_alcaldia' => $movimiento["municipio_alcaldia"],
                'entidad_federativa_domicilio_id' => $movimiento["entidad_federativa_domicilio_id"],
                'calle' => $movimiento["calle"],
                'numero_exterior' => $movimiento["numero_exterior"],
                'numero_interior' => $movimiento["numero_interior"],
                // Datos Salariales
                'clave_cobro' => $movimiento["clave_cobro"],
                'clave_ramo' => $movimiento["clave_ramo"],
                /* 'pagaduria' => $movimiento["pagaduria"], */
                'sueldo_cotizable' => $movimiento["sueldo_cotizable"],
                'sueldo_sar' => $movimiento["sueldo_sar"],
                'sueldo_total' => $movimiento["sueldo_total"],
                'tipo_nombramiento_id' => $movimiento["tipo_nombramiento_id"],
            ]);
        }
    }

}
