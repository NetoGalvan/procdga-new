<?php

namespace App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PagoTiempoExtraExcedente;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16HorasPorEmpleado;
use App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente\HistoricoP16TiempoExtraExcedente;
use App\Models\historico\lbpm_dga\p16_pago_tiempo_extraordinario_excedente\HistoricoP16Nominas;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16SubProcesoPagoTiempoExtraExcedente;
use DB;
use Carbon\Carbon;

class ReportesPagoTiempoExtra extends Controller
{
    public function reporteEmpleadosIncluidosPago(Request $request){
        return view('p16_pago_tiempo_extraordinario_excedente.reportes.reporteEmpleadosIncluidosPago');
    }

    public function reporteEmpleadosIncluidosPagoBuscar(Request $request) {

        $existePago = P16PagoTiempoExtraExcedente::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePago) {
            $pago = P16PagoTiempoExtraExcedente::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->first();

            $subprocesos = $pago->subprocesos;
            $empleadosHoras = array();
            if ( count($subprocesos) > 0 ) {
                foreach ($subprocesos as $key => $subproceso) {
                    if ( count($subproceso->horasEmpleados) > 0 ) {
                        foreach ($subproceso->horasEmpleados as $key => $empleado) {
                            $empleadosHoras[] = $empleado;
                        }
                    }

                }
            }
            return response()->json([ "estatus" => true, "mensaje" => "Empleado(s) pertenecientes al folio", "data" => $empleadosHoras]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function descargarReporteEmpleadosIncluidosPago(Request $request, $folio){

        $existePago = P16PagoTiempoExtraExcedente::where('folio', $folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePago) {
            $pago = P16PagoTiempoExtraExcedente::where('folio', $folio)->where('estatus', 'COMPLETADO')->first();

            $subprocesos = $pago->subprocesos;
            $empleadosHoras = array();
            $total_horas = 0;
            if ( count($subprocesos) > 0 ) {
                foreach ($subprocesos as $key => $subproceso) {
                    if ( count($subproceso->horasEmpleados) > 0 ) {
                        foreach ($subproceso->horasEmpleados as $key => $empleado) {
                            $empleadosHoras[] = $empleado;
                            $total_horas += $empleado->horas;
                        }
                    }

                }
            }
            return $pdf = \PDF::loadView('p16_pago_tiempo_extraordinario_excedente.formatos.pdf_reporte_empleados_incluidos', compact('pago', 'empleadosHoras', 'total_horas') )
                            ->download($pago->folio.'.pdf');

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function reporteEjecutivoProcesosEjecutados(Request $request){

        return view('p16_pago_tiempo_extraordinario_excedente.reportes.reporteEjecutivoProcesosEjecutados');
    }

    public function reporteEjecutivoProcesosEjecutadosBuscar(Request $request) {

        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($request->fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fechaFinal)->endOfDay();

        $pagos = P16PagoTiempoExtraExcedente::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')->get();
        if ( count($pagos) > 0 ) {
            return response()->json([ "estatus" => true, "mensaje" => "Pagos encontrados", "data" => $pagos]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El rango de fechas ingredo no contiene pagos, intente con otro"]);
        }
    }

    public function descargarReporteEjecutivoProcesosEjecutados($fechaInicio, $fechaFinal){

        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($fechaFinal)->endOfDay();

        $pagos = P16PagoTiempoExtraExcedente::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')->get();

        if ( count($pagos) > 0 ) {

            foreach ($pagos as $key => $pago) {
                $subprocesos = $pago->subprocesos;
                $empleadosHoras = 0;
                if ( count($subprocesos) > 0 ) {
                    foreach ($subprocesos as $key => $subproceso) {
                        if ( count($subproceso->horasEmpleados) > 0 ) {
                            foreach ($subproceso->horasEmpleados as $key => $empleado) {
                                $empleadosHoras += $empleado->horas;

                            }
                        }

                    }
                    $pago->total_horas_empleados = $empleadosHoras;
                }
            }

            return $pdf = \PDF::loadView('p16_pago_tiempo_extraordinario_excedente.formatos.pdf_reporte_ejecutivo_procesos',
                    compact('pagos') )
                        ->download('reporte_pagos.pdf');

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El rango de fechas ingredo no contiene pagos, intente con otro"]);
        }
    }
}
