<?php

namespace App\Http\Controllers\p21_premio_administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoPremio;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoInscripcion;
use App\Models\historico\lbpm_dga\p21_premio_administracion\HistoricoCandidatosPremio;
use App\Models\p21_premio_administracion\PremioAdministracion;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Models\p21_premio_administracion\P21CandidatosPremio;

class ReportePremioAdministracionController extends Controller
{

    public function fecha(){
        $meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
            "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
        $nuevaFecha = Carbon::now();
        $cadenaFecha= $nuevaFecha->format('d') . ' de ' . $meses[$nuevaFecha->format('m')] . ' de ' . $nuevaFecha->format('Y');

        return $cadenaFecha;
    }

    public function reporteEjecutivo(Request $request) {
        return view('p21_premio_administracion.reportes.reporte_ejecutivo_premio_administracion');
    }

    public function reporteEjecutivoBuscar(Request $request) {
        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($request->fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fechaFinal)->endOfDay();

        $premio = PremioAdministracion::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')
                                            ->with('area')->get();
        if ( count($premio) > 0 ) {
            return response()->json([ "estatus" => true, "mensaje" => "Premios encontrados", "data" => $premio]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El rango de fechas ingredo no contiene premios, intente con otras fechas"]);
        }
    }

    public function descargarReporteEjecutivoPremioAdministracion($fechaInicio, $fechaFinal){

        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($fechaFinal)->endOfDay();

        $premios = PremioAdministracion::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')
                                            ->with('area')
                                            ->get();


        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_reporte_ejecutivo_premio_administracion', compact('premios') )
        ->download('Reporte-Ejecutivo-Premio-Administracion.pdf');
    }

    public function reporteListadoPorConvocatoria(Request $request){
        return view('p21_premio_administracion.reportes.reporte_listado_candidatos_por_convocatoria');
    }

    public function reporteListadoPorConvocatoriaBuscar(Request $request) {
        $existePremio = PremioAdministracion::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = PremioAdministracion::where('folio', $request->folio)->where('estatus', 'COMPLETADO')
                        ->with('area')
                        ->with('candidatosPremio')
                        ->first();
            $empleados = [];
            // Agregar los empleadosPremio al array de empleados
            foreach ($premio->candidatosPremio as $empleadoPremio) {
                $empleadoPremio->folio_premio = $premio->folio;
                $empleadoPremio->areaPremio = $premio->area;
                $empleados[] = $empleadoPremio;
            }

            return response()->json([ "estatus" => true, "mensaje" => "Premio perteneciente al folio", "data" => $empleados]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function descargarReporteListadoPorConvocatoria(Request $request, $folio){

        $premio = PremioAdministracion::where('folio', $folio)->where('estatus', 'COMPLETADO')
                        ->with('area')
                        ->with('candidatosPremio')
                        ->first();
        $empleados = [];
        // Agregar los empleadosPremio al array de empleados
        foreach ($premio->candidatosPremio as $empleadoPremio) {
            $empleadoPremio->folio_premio = $premio->folio;
            $empleadoPremio->areaPremio = $premio->area;
            $empleados[] = $empleadoPremio;
        }

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_reporte_listado_por_convocarotia', compact('premio', 'empleados') )
        ->setPaper('a4', 'landscape') // Para que la hoja sea de forma horizontal
        ->download('Reporte-Listado-Candidatos-Premio-Administración-Por-Convocatoria.pdf');
    }
}
