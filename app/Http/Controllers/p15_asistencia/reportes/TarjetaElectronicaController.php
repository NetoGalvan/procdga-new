<?php

namespace App\Http\Controllers\p15_asistencia\reportes;

use App\Http\Controllers\Controller;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\LogLocal;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TarjetaElectronicaController extends Controller {
    
    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_tarjeta_electronica")->first();
        View::share("reporte", $reporte);
    }

    public function index() {
        return view("p15_asistencia.reportes.tarjeta_electronica.index");
    }
    
    public function buscar(Request $request) {
        try {
            $empleado = $request->datos_empleado ? json_decode($request->datos_empleado) : Auth::user()->empleado;
            $fechaInicio = $request->fecha_inicio;
            $fechaFinal = $request->fecha_final;
            $administrarAsistenciaEmpleado = new AdministrarAsistenciaEmpleado($empleado, $fechaInicio, $fechaFinal);
            $evaluaciones = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();
            if ($request->accion == "descargar") {
                $pdf = PDF::loadView('p15_asistencia.reportes.tarjeta_electronica.formatos.index', compact(
                    "empleado",
                    "evaluaciones",
                    "fechaInicio",
                    "fechaFinal"
                ))->setPaper([0, 0, 612.00, 950.00]); 
                return response()->json([
                    "estatus" => true,
                    "nombre" => "tarjeta_electronica_{$empleado->rfc}.pdf",
                    "pdf" => base64_encode($pdf->output()),
                    "registros" => array_values($evaluaciones)
                ]);
            } 
            return response()->json([
                "estatus" => true,
                "registros" => array_values($evaluaciones)
            ]); 
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "TARJETA ELECTRÓNICA",
                "mensaje" => $e->getMessage(), 
                "datos_extra" => json_encode([
                    "file" => $e->getFile(),
                    "code" => $e->getCode(),
                    "line" => $e->getLine()
                ])
            ]);
            return response()->json([
                "estatus" => false,
                "mensaje" => "No se puede consultar los datos en este momento. Por favor, intente más tarde."
            ]);  
        } 
    }
}
