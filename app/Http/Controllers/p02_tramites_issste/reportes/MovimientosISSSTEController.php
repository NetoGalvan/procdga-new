<?php

namespace App\Http\Controllers\p02_tramites_issste\reportes;

use App\Exports\p02_tramites_issste\reportes\MovimientosISSSTEExport;
use App\Http\Controllers\Controller;
use App\Models\p02_tramites_issste\TramiteIsssteDetalle;
use App\Models\Reporte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class MovimientosISSSTEController extends Controller
{
    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_tramites_issste_movimientos")->first();
        View::share("reporte", $reporte);
    }
    
    public function index() {
        return view("p02_tramites_issste.reportes.movimientos_issste.index");
    }

    public function buscar(Request $request) {
        $movimientosISSSTE = TramiteIsssteDetalle::
            whereHas("tramiteIssste", function ($query) {
                $query->where("estatus", "COMPLETADO");
            })
            ->whereBetween('created_at', ["$request->fecha_inicio 00:00:00", "$request->fecha_final 23:59:59"])
            ->with('tipoMovimientoIssste')
            ->orderBy('detalle_id', 'desc')
            ->get();
            
        if ($request->accion == "descargar" && $movimientosISSSTE->count() > 0) {
            $excelFile = new MovimientosISSSTEExport($movimientosISSSTE);
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $nombreArchivo = "reporte_movimientos_issste_{$timestamp}.xlsx";
            $path = "public/temporales/" . $nombreArchivo;
            Excel::store($excelFile, $path);
            $url = Storage::url($path);
            return response()->json([
                "estatus" => true,
                "url" => $url,
                "registros" => $movimientosISSSTE
            ]);
        } 

        return response()->json([
            "estatus" => true,
            "registros" => $movimientosISSSTE
        ]); 

    }
}
