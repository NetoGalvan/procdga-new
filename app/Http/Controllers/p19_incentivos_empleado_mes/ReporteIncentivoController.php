<?php

namespace App\Http\Controllers\p19_incentivos_empleado_mes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\p19_incentivos_empleado_mes\P19Incentivo;

class ReporteIncentivoController extends Controller
{

    public function reporteEjecutivoIncentivoEmpleadoMes(Request $request) {
        return view('p19_incentivos_empleado_mes.reportes.reporteEjecutivoIncentivoEmpleadoMes');
    }

    public function reporteEjecutivoIncentivoEmpleadoMesBuscar(Request $request) {
        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($request->fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fechaFinal)->endOfDay();

        $incentivos = P19Incentivo::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')
                                            ->with('areaCreadora')
                                            ->with('subprocesos')
                                            ->with('nominas')
                                            ->get();

        if ( count($incentivos) > 0 ) {
            return response()->json([ "estatus" => true, "mensaje" => "Premios encontrados", "data" => $incentivos]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El rango de fechas ingresado no contiene incentivos, intente con otras fechas"]);
        }
    }

    public function reporteEjecutivoIncentivoEmpleadoMesDescargar($fechaInicio, $fechaFinal){
        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($fechaFinal)->endOfDay();

        $incentivos = P19Incentivo::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')
                                            ->with('areaCreadora')
                                            ->with('subprocesos')
                                            ->with('nominas')
                                            ->get();

        return $pdf = \PDF::loadView('p19_incentivos_empleado_mes.formatos.pdf_reporte_ejecutivo_incentivo_empleado_mes', compact('incentivos') )->setPaper('a4', 'landscape')
                        ->download('reporte-ejecutivo-premio.pdf');
    }

}

