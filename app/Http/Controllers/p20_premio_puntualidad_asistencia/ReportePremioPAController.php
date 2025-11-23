<?php

namespace App\Http\Controllers\p20_premio_puntualidad_asistencia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20Premio;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20Nomina;
use App\Models\historico\lbpm_dga\p20_premio_puntualidad_asistencia\HistoricoP20SubprocesoNomina;
use App\Models\p20_premio_puntualidad_asistencia\P20Nomina;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidad;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidadEmpleados;
use App\Models\p20_premio_puntualidad_asistencia\P20SubprocesoNomina;
use App\Exports\p20_premio_puntualidad_asistencia\LayoutConNombres;
use App\Exports\p20_premio_puntualidad_asistencia\LayoutHistorico;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Area;
use App\Models\LogLocal;
use Exception;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;

class ReportePremioPAController extends Controller
{
    public function fecha(){
        $meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
            "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
        $nuevaFecha = Carbon::now();
        $cadenaFecha= $nuevaFecha->format('d') . ' de ' . $meses[$nuevaFecha->format('m')] . ' de ' . $nuevaFecha->format('Y');

        return $cadenaFecha;
    }

    //Reporte 1 - REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA
    public function reporteEjecutivoPremio(Request $request){
        return view('p20_premio_puntualidad_asistencia.reportes.reporteEjecutivoPremio');
    }

    public function descargarReporteEjecutivoPremio($fechaInicio, $fechaFinal){
        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($fechaFinal)->endOfDay();

        $premios = P20PremioPuntualidad::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')->get();

        return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_reporte_ejecutivo_premio', compact('premios') )
                        ->download('reporte-ejecutivo-premio.pdf');
    }

    public function reporteEjecutivoPremioBuscar(Request $request) {
        // Obtener las fechas del request
        $fechaInicio = Carbon::parse($request->fechaInicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fechaFinal)->endOfDay();

        $premio = P20PremioPuntualidad::whereBetween('created_at', [$fechaInicio, $fechaFin])
                                            ->where('estatus', 'COMPLETADO')
                                            ->with('area')->get();
        if ( count($premio) > 0 ) {
            return response()->json([ "estatus" => true, "mensaje" => "Premios encontrados", "data" => $premio]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El rango de fechas ingredo no contiene premios, intente con otras fechas"]);
        }
    }

    //Reporte 2 - REIMPRESIÓN RELACIÓN DE EMPLEADOS PREMIO DE PUNTUALIDAD Y ASISTENCIA
    public function reporteReimpresionRelacionEmpleados(Request $request){
        return view('p20_premio_puntualidad_asistencia.reportes.reporteReimpresionRelacionEmpleados');
    }

    public function descargarReporteReimpresionRelacionEmpleados(Request $request, $folio){

        $existePremio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')
                                            ->with('area')
                                            ->with('inscripciones')
                                            ->first();
            $empleados = [];
            // Iterar sobre las inscripciones del premio
            foreach ($premio->inscripciones as $inscripcion) {
                // Agregar los empleadosPremio al array de empleados
                foreach ($inscripcion->empleadosPremio as $empleadoPremio) {
                    $empleados[] = $empleadoPremio;
                }
            }

            return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_reporte_reimpresion_relacion_empleados', compact('premio', 'empleados'))
                    ->setPaper('a4', 'landscape') // Para que la hoja sea de forma horizontal
                    ->download('P20_Reporte_Relacion_Empleados_REIMPRESION.pdf');

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function reporteReimpresionRelacionEmpleadosBuscar(Request $request) {

        $existePremio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')
                        ->with('area')
                        ->with('inscripciones')
                        ->first();

            return response()->json([ "estatus" => true, "mensaje" => "Premio perteneciente al folio", "data" => $premio]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    //Reporte 3 - REIMPRESIÓN DE LAYOUT PREMIO PUNTUALIDAD Y ASISTENCIA
    public function reimpresionLayout(Request $request){
        return view('p20_premio_puntualidad_asistencia.reportes.reporteReimpresionLayout');
    }

    public function descargarReimpresionLayout(Request $request, $folio){

        $existePremio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')
                                            ->with('area')
                                            ->with('inscripciones')
                                            ->first();
            $empleados = [];
            // Iterar sobre las inscripciones del premio
            foreach ($premio->inscripciones as $inscripcion) {
                // Agregar los empleadosPremio al array de empleados
                foreach ($inscripcion->empleadosPremio as $empleadoPremio) {
                    $empleados[] = $empleadoPremio;
                }
            }

            return Excel::download(new LayoutConNombres($empleados), "P20_Layout_Reimpresion.xlsx");

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function reimpresionLayoutBuscar(Request $request) {
        $existePremio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')
                        ->with('area')
                        ->with('inscripciones')
                        ->first();

            return response()->json([ "estatus" => true, "mensaje" => "Premio perteneciente al folio", "data" => $premio]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    //Reporte 5 - ENLACE REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA
    public function enlaceListadoSolicitantes(Request $request) {
        return view('p20_premio_puntualidad_asistencia.reportes.reporteEnlaceListadoSolicitantes');
    }

    public function descargarEnlaceListadoSolicitantes(Request $request, $folio) {

        $existePremio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $folio)->where('estatus', 'COMPLETADO')
                                            ->with('area')
                                            ->with('inscripciones')
                                            ->first();
            $empleados = [];
            // Iterar sobre las inscripciones del premio
            foreach ($premio->inscripciones as $inscripcion) {
                // Agregar los empleadosPremio al array de empleados
                foreach ($inscripcion->empleadosPremio as $empleadoPremio) {
                    $empleadoPremio->folio_premio = $premio->folio;
                    $empleadoPremio->areaPremio->area;
                    $empleados[] = $empleadoPremio;
                }
            }

            return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_reporte_enlace_listado_solicitantes', compact('premio', 'empleados'))
                                ->download('P20_Reporte_Enlace_Listado'.$folio.'.pdf');

            return Excel::download(new LayoutConNombres($empleados), "P20_Layout_Reimpresion.xlsx");

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }




        $infoPremio = P20Premio::where('folio', $folio)->first();

        $empleados = P20Nomina::select('p20_nomina.*')
        ->join('p20_subproceso as s', 'p20_nomina.p20_subproceso_id', '=', 's.p20_subproceso_id')
        ->join('p20_premio as p', 's.p20_premio_id', '=', 'p.p20_premio_id')
        ->where("s.p20_premio_id", $infoPremio->p20_premio_id)
        ->get();

        return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_reporte_enlace_listado_solicitantes', compact('infoPremio', 'empleados'))
        ->download('P20_Reporte_Enlace_Listado'.$folio.'.pdf');



    }

    public function enlaceListadoSolicitantesBuscar(Request $request) {
        $existePremio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')->exists();
        if ($existePremio) {
            $premio = P20PremioPuntualidad::where('folio', $request->folio)->where('estatus', 'COMPLETADO')
                        ->with('area')
                        ->with('inscripciones')
                        ->first();
            $empleados = [];
            // Iterar sobre las inscripciones del premio
            foreach ($premio->inscripciones as $inscripcion) {
                // Agregar los empleadosPremio al array de empleados
                foreach ($inscripcion->empleadosPremio as $empleadoPremio) {
                    $empleadoPremio->folio_premio = $premio->folio;
                    $empleadoPremio->areaPremio->area;
                    $empleados[] = $empleadoPremio;
                }
            }

            return response()->json([ "estatus" => true, "mensaje" => "Premio perteneciente al folio", "data" => $empleados]);
        } else {
            return response()->json([ "estatus" => false, "mensaje" => "El folio ingresado no existe o esta en proceso aún, intente con otro"]);
        }
    }

    public function enlaceListadoSolicitantesTarjetaElectronica(Request $request) {
        try {
            $empleado = P20PremioPuntualidadEmpleados::find($request->id);
            if ($empleado)
            {
                $empleado->nombre_completo = $empleado->nombre_empleado . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno;
                $empleado->unidad_administrativa = $empleado->area_identificador_empleado;
                $empleado->unidad_administrativa_nombre = $empleado->area_empleado;
                $fechas = json_decode( $empleado->json_detalle_evaluacion );
                // Obtener el "inicio" de la primera posición
                $fechaInicio = $fechas[0]->inicio;
                // Obtener el "fin" de la última posición
                $fechaFinal = $fechas[count($fechas) - 1]->fin;

                $administrarAsistenciaEmpleado = new AdministrarAsistenciaEmpleado($empleado, $fechaInicio, $fechaFinal);
                $evaluaciones = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();

                $pdf = \PDF::loadView('p15_asistencia.reportes.tarjeta_electronica.formatos.index', compact(
                    "empleado",
                    "evaluaciones",
                    "fechaInicio",
                    "fechaFinal"
                ))->setPaper([0, 0, 612.00, 950.00]);

                return response()->json([
                    "estatus" => true,
                    "nombre" => "tarjeta_electronica_{$empleado->rfc}.pdf",
                    "pdf" => base64_encode($pdf->output()),
                    "registros" => array_values($evaluaciones)
                ]);
            }
            else
            {
                return response()->json([
                    "estatus" => false,
                    "mensaje" => "No se puede consultar los datos de este empleado en este momento. Por favor, intente más tarde."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "estatus" => false,
                "mensaje" => "No se puede consultar los datos en este momento. Por favor, intente más tarde."
            ]);
        }
    }

}
