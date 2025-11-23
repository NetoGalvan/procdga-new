<?php

namespace App\Http\Controllers\p12_tramites_incidencias\reportes;

use App\Http\Controllers\Controller;
use App\Http\Utils\conexion_db_historicos\ConexionDBHistoricos;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoTramiteIncidencia;
use App\Models\LogLocal;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p12_tramites_incidencias\TramiteIncidencia;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class IncidenciasAutorizadasArchivoController extends Controller
{

    public function __construct()
    {
        $reporte = Reporte::where("identificador", "reporte_incidencias_archivo")->first();
        View::share("reporte", $reporte);
    }
    
    public function index(Request $request) {
        return view("p12_tramites_incidencias.reportes.incidencias_archivo.index");
    }

    public function buscar(Request $request) {
        try {
            $fechaInicio = Carbon::createFromFormat("d-m-Y", $request->fecha_inicio);
            $fechaFinal = Carbon::createFromFormat("d-m-Y", $request->fecha_final);
            $area = Auth::user()->area;
            // HISTÓRICO
            $tramitesIncidenciasHistorico = HistoricoTramiteIncidencia::where([
                    "work_status" => "COMPLETED",
                    "created_by_ou" => $area->identificador,
                    "modalidad_captura" => "INDIVIDUAL"
                ])
                ->whereBetween("aprobado_on", [$fechaInicio->copy()->startOfDay(), $fechaFinal->copy()->endOfDay()])
                ->with("incidenciasEmpleado.tipoIncidencia", "incidenciasEmpleadoCancelacion.tipoIncidencia")
                ->get();

            $incidenciasHistorico = $tramitesIncidenciasHistorico->flatMap(function ($tramiteIncidencia) {
                if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    return $tramiteIncidencia->incidenciasEmpleadoCancelacion->take(1);
                }
                return $tramiteIncidencia->incidenciasEmpleado->take(1);
            });

            // LOCAL
            $tramitesIncidenciasLocal = TramiteIncidencia::where([
                    "estatus" => "COMPLETADO",
                    "area_id" => $area->area_id,
                    "tipo_tramite" => "INCIDENCIA_INDIVIDUAL"
                ])
                ->where("tramite_incidencia_asociado_historico", null)
                ->whereBetween("aprobado_at", [$fechaInicio->copy()->startOfDay(), $fechaFinal->copy()->endOfDay()])
                ->with("incidenciasEmpleado.tipoIncidencia", "incidenciasEmpleadoCancelacion.tipoIncidencia")
                ->get();
            
            $incidenciasLocal = $tramitesIncidenciasLocal->flatMap(function ($tramiteIncidencia) {
                if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    return $tramiteIncidencia->incidenciasEmpleadoCancelacion->take(1);
                }
                return $tramiteIncidencia->incidenciasEmpleado->take(1);
            });
            $incidencias = $incidenciasHistorico->concat($incidenciasLocal)->sortBy("nombre_completo")->values();
            if ($request->accion == "descargar") { 
                $pdf = PDF::loadView("p12_tramites_incidencias.reportes.incidencias_archivo.formatos.index", compact(
                    "area",
                    "fechaInicio",
                    "fechaFinal",
                    "incidencias"
                ))->setPaper("letter");
                return response()->json([
                    "estatus" => true,
                    "nombre" => "incidencias_para_archivo.pdf",
                    "pdf" => base64_encode($pdf->output())
                ]);
            }
            return response()->json([
                "estatus" => true,
                "incidenciasEmpleado" => $incidencias
            ]);
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "INCIDENCIAS PARA ARCHIVO",
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
