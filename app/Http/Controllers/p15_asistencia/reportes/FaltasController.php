<?php

namespace App\Http\Controllers\p15_asistencia\reportes;

use App\Exports\p15_asistencia\ReporteFaltasExport;
use App\Http\Controllers\Controller;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\Empleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoEmpleado;
use App\Models\historico\lbpm_dga\p15_asistencia\HistoricoEvaluacion;
use App\Models\LogLocal;
use App\Models\p15_asistencia\Evaluacion;
use App\Models\Reporte;
use App\Models\UnidadAdministrativa;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class FaltasController extends Controller {
    
    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_faltas")->first();
        View::share("reporte", $reporte);
    }

    public function index() {
        $unidades = UnidadAdministrativa::activo()
            ->orderByRaw("CAST(identificador AS INTEGER)")
            ->get();        
        return view("p15_asistencia.reportes.faltas.index", compact(
            "unidades"
        ));
    }

    public function buscar(Request $request) {
        $empleado = json_decode($request->datos_empleado);
        $unidadAdministrativa = ($request->unidad_administrativa_id != "TODAS") ? UnidadAdministrativa::find($request->unidad_administrativa_id) : null;
        // Fecha de inicio de evaluaciones en el sistema actual
        $fechaInicioEvaluacionLocal = Carbon::parse(config("general.asistencia.fecha_inicio_evaluacion"));
        // Fecha inicio a tomar en cuenta en el registro de asistencia
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        // Fecha final a tomar en cuenta en el registro de asistencia
        $fechaFinal = Carbon::parse($request->fecha_final);
        // Fecha inicio historico a tomar en cuenta en el registro de asistencia
        $fechaInicioHistorico = null;
        // Fecha final historico a tomar en cuenta en el registro de asistencia
        $fechaFinalHistorico = null;
        // Fecha inicio local a tomar en cuenta en el registro de asistencia
        $fechaInicioLocal = null;
        // Fecha final local a tomar en cuenta en el registro de asistencia
        $fechaFinalLocal = null;
        // Si la fecha de inicio es menor o igual a la última fecha de evaluación de los históricos
        if ($fechaInicio->lt($fechaInicioEvaluacionLocal)) {
            $fechaInicioHistorico = $fechaInicio->copy()->startOfDay();
            if ($fechaFinal->lt($fechaInicioEvaluacionLocal)) {
                $fechaFinalHistorico = $fechaFinal->copy()->endOfDay();
                $fechaInicioLocal = null;
                $fechaFinalLocal = null;
            } else {
                $fechaFinalHistorico = $fechaInicioEvaluacionLocal->copy()->subDay()->endOfDay();
                $fechaInicioLocal = $fechaInicioEvaluacionLocal->copy()->startOfDay();
                $fechaFinalLocal = $fechaFinal->copy()->endOfDay();
            }
        } else {
            $fechaInicioLocal = $fechaInicio->copy()->startOfDay();
            $fechaFinalLocal = $fechaFinal->copy()->endOfDay();
        }
        
        $condicionHistorico = '';
        
        if ($unidadAdministrativa) {
            $identificador = $unidadAdministrativa->identificador;  
            $condicionHistorico .= " AND id_unidad_administrativa = '{$identificador}'";
        }
        if ($empleado) {
            $numeroEmpleado = $empleado->numero_empleado;  
            $condicionHistorico .= " AND numero_empleado = '{$numeroEmpleado}'";
        }

        $evaluacionesHistoricas = collect();
        if (!is_null($fechaInicioHistorico)) {
            $tiposEvaluaciones = "'" . implode("', '", $request->tipos_evaluaciones) . "'";
            $query = "
                SELECT 
                    hr.fecha,
                    hr.nombre_completo,
                    hr.numero_empleado,
                    hr.id_nivel_salarial AS nivel_salarial,
                    hr.id_unidad_administrativa AS unidad_administrativa,
                    hr.resultado_eval_ew as evaluacion
                FROM (
                    SELECT 
                        *
                    FROM hr_super_eval_v2( ?::date, ?::date ) 
                    WHERE resultado_eval_ew IN ($tiposEvaluaciones) AND 
                        (CAST(id_nivel_salarial AS INTEGER) < 20 OR CAST(id_nivel_salarial AS INTEGER) > 48) 
                        $condicionHistorico
                ) hr 
                LEFT OUTER JOIN p15_horarios h ON (hr.id_horario = h.id);
            ";
            $evaluacionesHistoricas = DB::connection('lbpm_dga')->select($query, [$fechaInicioHistorico, $fechaFinalHistorico]);
            $evaluacionesHistoricas = collect($evaluacionesHistoricas);
        }

        // TRAER TODAS LAS EVALUACIONES LOCALES CON FALTA 
        $evaluacionesLocales = Evaluacion::select(
            'empleados.unidad_administrativa',
            'empleados.numero_empleado', 
            'empleados.nombre_completo', 
            'p15_evaluaciones.fecha',
            'p15_evaluaciones.evaluacion_final AS evaluacion'
        )
        ->join('empleados', 'empleados.rfc', '=', 'p15_evaluaciones.rfc')
        ->whereBetween('p15_evaluaciones.fecha', [$fechaInicioLocal, $fechaFinalLocal])
        ->whereIn('p15_evaluaciones.evaluacion_final', $request->tipos_evaluaciones)
        ->where(function ($query) use ($unidadAdministrativa, $empleado) {
            if ($unidadAdministrativa) {
                $query->where("empleados.unidad_administrativa", $unidadAdministrativa->identificador);
            }
            if ($empleado) {
                $query->where([
                    "empleados.numero_empleado" => $empleado->numero_empleado,
                    "empleados.rfc" => $empleado->rfc
                ]);
            }
        })
        ->orderBy('empleados.nombre_completo')
        ->orderBy('p15_evaluaciones.fecha')
        ->get();

        $unidadesEvaluaciones =  $evaluacionesHistoricas
            ->concat($evaluacionesLocales)
            ->sortBy(function ($item) {
                return [$item->unidad_administrativa, $item->nombre_completo, $item->fecha];
            })
            ->groupBy("unidad_administrativa");

        $unidadesAdministrativas = UnidadAdministrativa::activo()->get()->keyBy("identificador")->toArray();
        
        /* $pdf = PDF::loadView('p15_asistencia.reportes.faltas.formatos.index', compact(
            "unidadesAdministrativas",
            "unidadesEvaluaciones",
            "fechaInicio",
            "fechaFinal"
        ))->setPaper([0, 0, 612.00, 950.00]);
        
        return response()->json([
            "estatus" => true,
            "nombre" => "reporte_faltas.pdf",
            "pdf" => base64_encode($pdf->output()),
            "registros" => $unidadesEvaluaciones
        ]); */
        
        $excelFile = new ReporteFaltasExport($unidadesAdministrativas, 
            $unidadesEvaluaciones,
            $fechaInicio,
            $fechaFinal
        );
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $nombreArchivo = "reporte_faltas_{$timestamp}.xlsx";
        $path = "public/temporales/" . $nombreArchivo;
        Excel::store($excelFile, $path);
        $url = Storage::url($path);
        
        return response()->json([
            "estatus" => true,
            "url" => $url
        ]);
    }   
}
