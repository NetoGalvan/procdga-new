<?php

namespace App\Http\Controllers\p12_tramites_incidencias\reportes;

use App\Http\Controllers\Controller;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\LogLocal;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Exception;
use Illuminate\Support\Facades\Auth;

class DiasAcumuladosController extends Controller
{
    public function __construct()
    {
        $reporte = Reporte::where("identificador", "reporte_incidencias_dias_acumulados")->first();
        View::share("reporte", $reporte);
    }

    public function index(Request $request) {
        $tiposIncidencias = TipoIncidencia::activo()
            ->whereHas("tipoJustificacion", function($query) {
                $query->where("identificador", "!=", "cambio_horario");
            })
            ->with("tipoJustificacion")
            ->orderBy("tipo_justificacion_id")
            ->orderBy("articulo")
            ->get();
        return view("p12_tramites_incidencias.reportes.dias_acumulados.index", compact(
            "tiposIncidencias"
        ));
    }

    public function buscar(Request $request) {
        try {
            $empleado = json_decode($request->datos_empleado) ?? Auth::user()->empleado;
            $tiposIncidencias = $request->tipos_incidencias;
            $fechaInicio = $request->fecha_inicio;
            $fechaFinal = $request->fecha_final;
            $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, $fechaInicio, $fechaFinal);
            $incidenciasEmpleado = $administrarAsistencia->getDiasAcumuladosPorTiposIncidencias($tiposIncidencias);
            
            if ($request->accion == "descargar") { 
                $pdf = PDF::loadView("p12_tramites_incidencias.reportes.dias_acumulados.formatos.index", compact(
                    "empleado", 
                    "incidenciasEmpleado",
                    "fechaInicio",
                    "fechaFinal"
                ))->setPaper("letter");

                return response()->json([
                    "estatus" => true,
                    "nombre" => "reporte_acumulacion_dias_{$empleado->rfc}.pdf",
                    "incidenciasEmpleado" => $incidenciasEmpleado,
                    "pdf" => base64_encode($pdf->output())
                ]);
            }

            return response()->json([
                "estatus" => true,
                "incidenciasEmpleado" => $incidenciasEmpleado
            ]);
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "DÍAS ACUMULADOS POR TIPO DE INCIDENCIA",
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
