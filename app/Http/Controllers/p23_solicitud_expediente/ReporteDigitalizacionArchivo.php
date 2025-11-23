<?php

namespace App\Http\Controllers\p23_solicitud_expediente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Solicitud;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Digitalizacion;
use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23DetalleDigitalizacion;
use App\Models\p23_solicitud_expediente\P23Indice;
use App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion;
use App\Models\p23_solicitud_expediente\P23Digitalizacion;
use App\Models\p23_solicitud_expediente\P23Solicitud;
use Maatwebsite\Excel\Facades\Excel;

class ReporteDigitalizacionArchivo extends Controller
{    
    #BEGIN::REPORTE 01 - REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN
    public function reporteEjecutivoDetalleDigitalizacion(Request $request){

        if ($request->ajax()) {
            $indiceDigitalizacion = P23Indice::query()->where('activo', true);

            if( !is_null($request->numero_expediente) ) $indiceDigitalizacion = $indiceDigitalizacion->where('numero_expediente', $request->numero_expediente);
            if( !is_null($request->nombre_empleado) ){ 
                $indiceDigitalizacion = $indiceDigitalizacion->where(DB::raw("concat(apellido_paterno, ' ', apellido_materno, ' ', nombre_empleado)"), 'ilike', '%'.$request->nombre_empleado.'%');
            }

            $indiceDigitalizacion = $indiceDigitalizacion->get();
            return response()->json($indiceDigitalizacion);
        }

        return view('p23_digitalizacion_archivo.reportes.reporteEjecutivoDetalleDigitalizacion');
    }
    
    public function descargarReporteEjecutivoDetalleDigitalizacion($numero_expediente) {
        //dd($numero_expediente.' >.< ');
        $p23Indice = P23Indice::firstWhere('numero_expediente', $numero_expediente);
        $p23Digitalizacion = P23Digitalizacion::where('folio', $p23Indice->folio)->where('expediente_actual', true)->first();
        $p23DetalleDig = null;

        if( !is_null($p23Digitalizacion->nombre_archivo) ){
            $p23DetalleDig = P23DetalleDigitalizacion::where('folio', $p23Indice->folio)->where('activo', true)->get();
        
        } else {
            $p23DetalleDig = P23DetalleDigitalizacion::where('folio', $p23Indice->folio)->get();
        }

        return $pdf = \PDF::loadView('p23_digitalizacion_archivo.formatos.pdf_reporte_detalle_digitalizacion', compact('p23Digitalizacion', 'p23DetalleDig'))->download();
    }
    #END::REPORTE 01 - REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN

    //Reporte 2 - REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN
    public function reporteEjecutivoDigitalizacion(Request $request) {
        
        if ($request->ajax()) {
            $indiceDigitalizacion = P23Indice::where('activo', true)
                                                ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])
                                                ->get();

            return response()->json($indiceDigitalizacion);
        }

        return view('p23_digitalizacion_archivo.reportes.reporteEjecutivoDigitalizacion');
    }
    
    public function descargarReporteEjecutivoDigitalizacion(Request $request){

        $fechas = [$request->fecha_inicio, $request->fecha_fin];
        $p23Indice = P23Indice::where('activo', true)->whereBetween('created_at', $fechas)->get();

        return $pdf = \PDF::loadView('p23_digitalizacion_archivo.formatos.pdf_reporte_digitalizacion_archivo', compact('p23Indice', 'fechas'))->download();
    }

    //Reporte 3 - REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN
    public function reporteEjecutivoExpedientesDigitalizados(Request $request){

        if ($request->ajax()) {
            $fechas = [$request->fecha_inicio, $request->fecha_fin];
            $indiceDigitalizacion = P23Indice::where('activo', true)
                                                ->whereBetween('created_at', $fechas)
                                                ->whereHas('digitalizacionFolio', function($query) {
                                                    $query->whereNotNull('nombre_archivo');
                                                })
                                                ->get();

            return response()->json($indiceDigitalizacion);
        }
        return view('p23_digitalizacion_archivo.reportes.reporteEjecutivoExpedientesDigitalizados');
    }
    
    public function descargarReporteEjecutivoExpedientesDigitalizados(Request $request){
        $fechas = [$request->fecha_inicio, $request->fecha_fin];
        $p23Indice = P23Indice::where('activo', true)->whereBetween('created_at', $fechas)
                                ->whereHas('digitalizacionFolio', function($query) {
                                    $query->whereNotNull('nombre_archivo');
                                })
                                ->get();

        return $pdf = \PDF::loadView('p23_digitalizacion_archivo.formatos.pdf_reporte_expedientes_digitalizados', compact('p23Indice', 'fechas'))->download();
    }

    #BEGIN::Conexion con la B.D. Historica
    public function connect_db_old() {
        $db_old_connected = false;
        try {
                DB::connection('lbpm_dga')->getPdo();
                $db_old_connected = true;
            
            } catch (\Exception $e) { }

        return $db_old_connected;
    }
    #END::Conexion con la B.D. Historica
}
