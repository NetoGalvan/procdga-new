<?php

namespace App\Http\Controllers\p02_tramites_issste\reportes;

use App\Http\Controllers\Controller;
use App\Models\p02_tramites_issste\TramiteIssste;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProcesosTramiteISSSTEController extends Controller
{
    public function __construct() {
        $reporte = Reporte::where("identificador", "reporte_tramites_issste_procesos")->first();
        View::share("reporte", $reporte);
    }

    public function index() {
        return view("p02_tramites_issste.reportes.procesos_issste.index");
    }

    public function buscar(Request $request) {
        $procesosISSSTE = TramiteIssste::
            where("estatus", "COMPLETADO")
            ->whereBetween('created_at', ["$request->fecha_inicio 00:00:00", "$request->fecha_final 23:59:59"])
            ->orderBy('tramite_issste_id', 'desc')
            ->get();

        if ($request->accion == "descargar" && $procesosISSSTE->count() > 0) {
            $pdf = Pdf::loadView('p02_tramites_issste.reportes.procesos_issste.formatos.index', compact(
                'procesosISSSTE'
            ))->setPaper([0, 0, 612.00, 950.00]);
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $nombreArchivo = "reporte_ejecutivo_procesos_issste_{$timestamp}.pdf"; 
            return response()->json([
                "estatus" => true,
                "nombre" => $nombreArchivo,
                "pdf" => base64_encode($pdf->output()),
                "registros" => $procesosISSSTE
            ]);
        } 
        return response()->json([
            "estatus" => true,
            "registros" => $procesosISSSTE
        ]); 
    }


    


}
