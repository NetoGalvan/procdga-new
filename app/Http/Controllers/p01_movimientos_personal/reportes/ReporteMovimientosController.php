<?php

namespace App\Http\Controllers\p01_movimientos_personal\reportes;

use App\Exports\p01_movimientos_personal\ReporteMovimientosExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\p01_movimientos_personal\TipoMovimiento;
use App\Models\historico\lbpm_dga\HistoricoMovimientoPersonal;
use App\Models\Reporte;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ReporteMovimientosController extends Controller
{
    var $estatus = [
        "COMPLETED" => "COMPLETADO",
    ];

    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_movimiento_personal")->first();
        View::share("reporte", $reporte);
    }
    
    public function index() {
        $tiposMovimientos = TipoMovimiento::activo()->get()->groupBy('tipo');
        $arrayEstatus = [
            "EN_PROCESO" => "EN PROCESO",
            "COMPLETADO" => "COMPLETADO"
        ];
        return view("p01_movimientos_personal.reportes.index", compact(
            "tiposMovimientos", 
            "arrayEstatus"
        ));
    } 

    public function buscar(Request $request) {
        $movimientosPersonal = MovimientoPersonal::activo()
            ->where(function ($query) use ($request) {
                if (Auth::user()->hasRole('SUB_EA')) {
                    $query->where('area_id', Auth::user()->area_id);
                }
                if (!is_null($request->folio)) {
                    $query->where("folio", $request->folio);
                }
                if (!is_null($request->fecha_inicio)) {
                    $query->whereBetween('created_at', ["$request->fecha_inicio 00:00:00", "$request->fecha_final 23:59:59"]);
                }
                if (!is_null($request->tipo_movimiento_id)) {
                    $query->where("tipo_movimiento_id", $request->tipo_movimiento_id);
                }
                if (!is_null($request->estatus)) {
                    $query->where("estatus", $request->estatus);
                }
            })
            ->with("tipoMovimiento", "area.unidadAdministrativa")
            ->orderBy('movimiento_personal_id', 'desc')
            ->get();
        if ($request->accion == "descargar") {
            $excelFile = new ReporteMovimientosExport($movimientosPersonal);
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $nombreArchivo = "reporte_movimientos_personal_{$timestamp}.xlsx";
            $path = "public/temporales/" . $nombreArchivo;
            Excel::store($excelFile, $path);
            $url = Storage::url($path);
            return response()->json([
                "estatus" => true,
                "url" => $url
            ]);
        } 

        return response()->json([
            "estatus" => true,
            "registros" => $movimientosPersonal
        ]); 
    }


    public function descargarReporte(Request $request) {
        return Excel::download(new ReporteMovimientosExport($request), "reporte_movimientos_personal.xlsx");
    }

    public function descargarAlimentario(MovimientoPersonal $movimientoPersonal) {
        if ($movimientoPersonal->tipoMovimiento->tipo == "ALTAS") {
            $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_altas', compact(
                "movimientoPersonal"
            ));
        } else if ($movimientoPersonal->tipoMovimiento->tipo == "REANUDACIONES") {
            $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_reanudaciones', compact(
                "movimientoPersonal"
            ));
        } else if ($movimientoPersonal->tipoMovimiento->tipo == "BAJAS") {
            $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_bajas', compact(
                "movimientoPersonal"
            ));
        }
        return $pdf->download('documento_alimentario.pdf');
    }
}
