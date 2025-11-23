<?php

namespace App\Http\Controllers\p15_asistencia\reportes;

use App\Http\Controllers\Controller;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\LogLocal;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TarjetaElectronicaCalendarioController extends Controller {

    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_tarjeta_electronica_calendario")->first();
        View::share("reporte", $reporte);
    }

    public function index() {
        return view("p15_asistencia.reportes.tarjeta_electronica_calendario.index");
    }

    public function buscar(Request $request) {
        try {
            $empleado = json_decode($request->datos_empleado) ?? Auth::user()->empleado;
            $fechaInicio = Carbon::parse($request->fecha_inicio);
            $fechaFinal = Carbon::parse($request->fecha_final);
            $administrarAsistenciaEmpleado = new AdministrarAsistenciaEmpleado($empleado, $fechaInicio, $fechaFinal);
            $evaluaciones = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();      
            if ($request->accion == "descargar") {
                $periodoMeses = CarbonPeriod::create($fechaInicio->copy()->setDay(1), '1 month', $fechaFinal);
                $contenedores = [];
                foreach ($periodoMeses as $mes) {
                    $primerDiaDelMes = $mes->copy()->firstOfMonth();
                    $ultimoDiaDelMes = $mes->copy()->endOfMonth();
                    $indicePrimerDiaDelMes = $primerDiaDelMes->dayOfWeek;
                    $periodoMes = CarbonPeriod::create($primerDiaDelMes, $ultimoDiaDelMes);
                    // Crear contenedores de días por mes
                    $totalContenedores = 42;
                    for ($i = 0; $i < $totalContenedores; $i++) {
                        $contenedores[$mes->format("Y-m-d")][] = $i;
                    }
                    // Agregar las fechas a los contenedores
                    foreach($periodoMes as $indice => $fecha) {
                        $contenedores[$mes->format("Y-m-d")][$indicePrimerDiaDelMes + $indice] = [
                            "fecha" => $fecha, 
                            "data" => $evaluaciones[$fecha->format("Y-m-d")] ?? null
                        ];
                    }
                }
                $pdf = PDF::loadView('p15_asistencia.reportes.tarjeta_electronica_calendario.formatos.index', compact(
                    "empleado",
                    "contenedores",
                    "fechaInicio",
                    "fechaFinal"
                ))->setPaper([0, 0, 612.00, 950.00]);           
                return response()->json([
                    "estatus" => true,
                    "nombre" => "tarjeta_electronica_calendario_{$empleado->rfc}.pdf",
                    "pdf" => base64_encode($pdf->output()),
                    "registros" => array_values($evaluaciones)
                ]);
            }
            return response()->json([
                "estatus" => true,
                "fecha_inicio" => $request->fecha_inicio,
                "fecha_final" => $request->fecha_final,
                "registros" => array_values($evaluaciones)
            ]); 
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "TARJETA ELECTRÓNICA CALENDARIO",
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
