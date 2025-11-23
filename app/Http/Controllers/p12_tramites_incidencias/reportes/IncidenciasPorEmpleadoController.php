<?php

namespace App\Http\Controllers\p12_tramites_incidencias\reportes;

use App\Http\Controllers\Controller;
use App\Http\Utils\conexion_db_historicos\ConexionDBHistoricos;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\LogLocal;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class IncidenciasPorEmpleadoController extends Controller
{
    public function __construct()
    {
        $reporte = Reporte::where("identificador", "reporte_incidencias_por_empleado")->first();
        View::share("reporte", $reporte);
    }
    
    public function index(Request $request) {
        $tiposIncidencias = TipoIncidencia::activo()
            ->with("tipoJustificacion")
            ->orderBy("tipo_justificacion_id")
            ->orderBy("articulo")
            ->get();
        return view("p12_tramites_incidencias.reportes.incidencias_por_empleado.index", compact(
            "tiposIncidencias"
        ));
    }

    public function buscar(Request $request) {
        try {
            $empleado = json_decode($request->datos_empleado) ?? Auth::user()->empleado;
            $fechaInicio = Carbon::createFromFormat("d-m-Y", $request->fecha_inicio);
            $fechaFinal = Carbon::createFromFormat("d-m-Y", $request->fecha_final);
            $tiposIncidencias = $request->tipos_incidencias;
            $estatus = $request->estatus;

            // Incidencias históricas
            $incidenciasHistoricas = HistoricoIncidenciaEmpleado::whereHas("cardex", function ($query) use ($empleado) {
                $query->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%$empleado->rfc%")
                    ->where("numero_empleado", $empleado->numero_empleado);
            })
            ->whereIn("status", ["ACTIVO", "CANCELADO"])
            ->whereHas("tramiteIncidencia", function ($query) use ($fechaInicio, $fechaFinal) {
                $query->whereBetween("aprobado_on", [$fechaInicio->copy()->startOfDay(), $fechaFinal->copy()->endOfDay()]);
            })
            ->where(function ($query) use ($tiposIncidencias, $estatus) {
                if ($tiposIncidencias) {
                    $query->whereIn("id_justificacion", $tiposIncidencias);
                }
                if ($estatus) {
                    $relacionEstatus = [
                        "AUTORIZADO" => "ACTIVO",
                        "CANCELADO" => "CANCELADO"
                    ];
                    $query->where("status", $relacionEstatus[$estatus]);
                }
            })
            ->with("tipoIncidencia", "horario")
            ->get();     
            
            // Incidencias Locales
            $incidenciasLocales = IncidenciaEmpleado::where([
                "rfc" => $empleado->rfc,
                "numero_empleado" => $empleado->numero_empleado
            ])
            ->whereIn("estatus", ["AUTORIZADO", "CANCELADO"])
            ->whereHas("tramiteIncidencia", function ($query) use ($fechaInicio, $fechaFinal) {
                $query->whereBetween("aprobado_at", [$fechaInicio->copy()->startOfDay(), $fechaFinal->copy()->endOfDay()]);
            })
            ->where(function ($query) use ($tiposIncidencias, $estatus) {
                if ($tiposIncidencias) {
                    $query->whereIn("tipo_incidencia_id", $tiposIncidencias);
                }
                if ($estatus) {
                    $query->where("estatus", $estatus);
                }
            })
            ->with("tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
            ->get();
            
            $incidenciasEmpleado = $incidenciasHistoricas->concat($incidenciasLocales)->sortByDesc('created_at')->values();

            if ($request->accion == "descargar") { 
                $pdf = PDF::loadView("p12_tramites_incidencias.reportes.incidencias_por_empleado.formatos.index", compact(
                    "empleado", 
                    "incidenciasEmpleado",
                    "fechaInicio",
                    "fechaFinal"
                ))->setPaper("letter");

                return response()->json([
                    "estatus" => true,
                    "nombre" => "incidencias_empleado_{$empleado->rfc}.pdf",
                    "incidenciasEmpleado" => $incidenciasEmpleado,
                    "pdf" => base64_encode($pdf->output())
                ]);
            }

            return response()->json([
                "estatus" => true,
                "incidenciasEmpleado" => $incidenciasEmpleado
            ]);
        }  catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "INCIDENCIAS POR EMPLEADO",
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
