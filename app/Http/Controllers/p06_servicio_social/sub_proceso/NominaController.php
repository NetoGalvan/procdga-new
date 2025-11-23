<?php

namespace App\Http\Controllers\p06_servicio_social\sub_proceso;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\p06_servicio_social\sub_proceso\ManejadorTareasSubProceso;

use App\Models\Tarea;
use App\Models\Instancia;
use App\Models\Area;
use App\Models\InstanciaTarea;
use App\Models\Proceso;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Nomina;
use App\Models\p06_servicio_social\P06NominaDetalle;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use App\Exports\p06_servicio_social\NominaServSocExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Throwable;

class NominaController extends Controller
{
    use ManejadorTareasSubProceso;

    private $sub_eas;
    private $posiblesValidaciones = [
        'ACEPTADO',
        'RECHAZADO',
        'RECHAZADO PERMANENTEMENTE'
    ];

    public function __construct()
    {
        $this->areas_sub_eas = Area::whereHas("users.roles", function($q) {
                                        $q->where("name", "SUB_EA");
                                    })->get()->pluck('area_id');
    }

    public function descripcion(){
        return view('p06_servicio_social.sub_proceso.descripcionNomina');
    }

    public function iniciarProceso(){

        try {
            DB::beginTransaction();

            $nomina = P06Nomina::create([]);
            $instancia = $this->crearInstancia('servicio_social_nomina', $nomina, Auth::user()->area);
            $instanciaTarea = $instancia->crearInstanciaTarea("SUBT01", "NUEVO");

            DB::commit();
            return redirect()->route('servicio.social.sub.seleccion.tipo.nomina', [$nomina, $instanciaTarea])->with("success", "El proceso se creó correctamente.");
        } catch (\Exception $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }

    public function seleccionarNomina(Request $request, P06Nomina $nomina, InstanciaTarea $instanciaTarea) {

        $instancia =  $nomina->instancia;
        $instanciaSubPro =  $nomina->instanciaSubProcesosNomina;

        if ($request->isMethod('post'))
        {
            $response = $this->guardarTareaT01Nomina($nomina, $request->all());
            if ( $response['guardado']) {

                $P06 = $this->querySearchPrestadores($this->areas_sub_eas, $nomina)
                            ->where(function($q) {
                                $q->where('payment_estatus', 'RECHAZADO')->orWhere('payment_estatus', null);
                            })
                            ->get()->pluck('area_id');

                if(count($P06) > 0){

                    if( $request->ajax() ) {
                        return response()->json([ "estatus" => true]);

                    } else {
                        $areas_sub_ea = Area::whereIn('area_id', $P06)->get();
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        $this->crearTareasParaSubEa($instancia, $areas_sub_ea);
                        $this->crearTarea($instancia, 'SUBT03', 'NUEVO');

                        return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
                    }
                } else {
                    if( $request->ajax() ) {

                        return response()->json([ "estatus" => false, "mensaje" => "Ninguna de las áreas cuenta con prestadores suceptibles para la beca."]);
                    }
                }
            } else {
                if( $request->ajax() ) {

                    Log::error(__METHOD__." -> ".$response['mensaje']);
                    return response()->json([ "estatus" => false, 'mensaje' => 'Ocurrio un problema' ]);
                }
            }


        }
        return view('p06_servicio_social.sub_proceso.seleccionNomina', compact('nomina', 'instanciaTarea'));
    }

    public function validacionNomina(Request $request, P06Nomina $nomina, InstanciaTarea $instanciaTarea){

        $instanciaSubPro =  $nomina->instanciaSubProcesosNomina;

        $instancia =  $nomina->instancia;
        $area_usuario = Auth::user()->area_id;
        $nomina_id = $nomina->nomina_id;

        $datosNomina = P06Nomina::select('*')->where('nomina_id', $nomina->nomina_id)->first();

        if( $request->ajax() ) #Guardar estatus de las validaciones
        {
            try {
                DB::beginTransaction();
                foreach($request->get('asignar_validacion') as $asignar) {
                    $asignar = explode(',', $asignar);

                    P06ServicioSocial::where('servicio_social_id', $asignar[1])
                            ->update([
                                'payment_estatus' => $asignar[0]
                            ]);
                }
                DB::commit();
                return response()->json([ "estatus" => true ]);
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return response()->json([ "estatus" => false ]);
            }
        }

        $servicioSocialPrestadores = $this->querySearchPrestadores([$instanciaTarea->pertenece_al_area], $nomina)->get();
        $validaciones = $this->posiblesValidaciones;

        if ($request->isMethod('post'))
        {
            if ($this->guardarTareaT02Validacion($request, $nomina)) {
                $instanciaTarea->updateEstatus('COMPLETADO');

                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            }else{
                return redirect()->back()->with("error", "Ocurrio un error al guardar la información, intente de nuevo más tarde." );
            }
        }

        //dd($servicioSocialPrestadores->prestador->escuela->nombre_escuela);
        return view('p06_servicio_social.sub_proceso.validacionNomina', compact('datosNomina', 'servicioSocialPrestadores', 'validaciones', 'nomina_id', 'instanciaTarea'));
    }

    public function cierreDeNomina(P06Nomina $nomina, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $nomina->instancia;
        $nombreTarea = $instanciaTarea->tarea_id;

        $datosNomina = $nomina;

        $prestadoresYaValidados = $this->querySearchPrestadores($this->areas_sub_eas, $nomina)
                                        ->where('payment_estatus', 'ACEPTADO')
                                        ->whereHas('nominaDetalle', function($q) use ($nomina) {
                                            $q->where('nomina_id', $nomina->nomina_id);
                                        })->get();

        $datos_sub_ea = InstanciaTarea::where('instancia_id', $instanciaTarea->instancia_id)
                                        ->whereHas('tarea', function($q) {
                                            $q->where('identificador', 'SUBT02');
                                        })->get();

        $totalRegistros = count($datos_sub_ea);
        $contadorFinalizadas=0;
        $nomina_id = $nomina->nomina_id;
        $instancia_id = $instancia->instancia_id;

        if ($request->isMethod('post'))
        {
            try {
                $guardarDatosCierre = $this->guardarTareaT03Cierre($nomina, $prestadoresYaValidados);

                if ( $guardarDatosCierre['estatus'] ) {
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $regresa = $this->crearTarea($instancia, 'SUBT04', 'NUEVO');

                    return redirect()->route('servicio.social.sub.generacion.xls', ['nomina' => $nomina, 'instanciaTarea' => $regresa->instancia_tarea_id])->with("success", 'La tarea finalizó correctamente');
                } else {
                    return redirect()->back()->with("error", $guardarDatosCierre['mensaje']);
                }

            }catch (\Throwable $th) {
                return redirect()->back()->with("error", $th);
            }
        }

        return view('p06_servicio_social.sub_proceso.cierreNomina', compact('datosNomina','prestadoresYaValidados', /*'infoTarea',*/ 'instanciaTarea','nomina_id', 'instancia_id', 'datos_sub_ea', 'contadorFinalizadas', 'nomina', 'totalRegistros'));
    }

    public function finalizarProcesoDesdeT03(P06Nomina $nomina, InstanciaTarea $instanciaTarea){

        try {

            $instanciaTarea->updateEstatus('COMPLETADO');
            $this->actualizarEstatusTareasMismaInstancia($instanciaTarea, 'COMPLETADO');
            $this->finalizarProceso($instanciaTarea, 'CANCELADO'/*, $request*/);

            return redirect()->route('procesos')->with("success", 'El proceso finalizó correctamente');
        } catch (\Throwable $th) {

            return redirect()->back()->with("error", $th);
        }
    }

    public function generacionNominaXLS(Request $request, P06Nomina $nomina, InstanciaTarea $instanciaTarea){

        #FINALIZAR PROCESO ->
        if ($request->isMethod('post'))
        {
            try {
                $instanciaTarea->updateEstatus('COMPLETADO');
                $this->finalizarProceso($instanciaTarea, 'COMPLETADO', $request);

                return redirect()->route('tareas')->with("success", 'El proceso finalizó correctamente');

            }catch (\Throwable $th) {
                return redirect()->back()->with("error", $th);
            }
        }
        #END <-
        return view('p06_servicio_social.sub_proceso.generacionNomina', compact('instanciaTarea', 'nomina'));
    }

    public function descargarExcelNomina(Request $request, P06Nomina $nomina){

        try {
            $nomina->updated_at = now();
            $nomina->save();
/*
            $prestadores = P06ServicioSocial::select('p06_servicio_social.*', 'pres.nombre_prestador', 'pres.primer_apellido', 'pres.segundo_apellido', 'pres.tipo_prestador', 'pres.carrera', 'nomDet.tipo_pago', 'nomDet.meses_pagar', 'nomDet.fecha_cerrado', 'escuela.nombre_escuela')
            ->join('p06_prestadores as pres', 'p06_servicio_social.prestador_id', '=', 'pres.prestador_id')
            ->join('p06_nomina_detalle as nomDet', 'p06_servicio_social.servicio_social_id', '=', 'nomDet.servicio_social_id')
            ->join('p06_escuelas as escuela', 'p06_servicio_social.escuela_id', '=', 'escuela.escuela_id')
            ->where("p06_servicio_social.nomina_id", $nomina->nomina_id)
            ->get();
*/
            $ss = P06ServicioSocial::where("p06_servicio_social.nomina_id", $nomina->nomina_id)->get();
            return Excel::download(new NominaServSocExport($ss, $nomina->descripcion, $nomina->tipo_validacion), 'nomina.xlsx');

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function querySearchPrestadores($areas_id, $nomina)
    {
        $prest = P06ServicioSocial::query()->whereIn('area_id', $areas_id)->where('activo', true);

        switch( $nomina->tipo_validacion )
        {
            case 'PARCIAL':
                return $prest->whereHas('prestador', function($q) {
                                $q->where('estatus_prestador', 'LIBERADO');
                             })
                             ->whereBetween('fecha_carta_fin', [
                                $nomina->fecha_inicio, $nomina->fecha_fin
                             ]);
                break;

            case "COMPLETA":
                return $prest->whereHas('prestador', function($q) {
                                $q->whereIn('estatus_prestador', ['LIBERADO', 'EN CURSO']);
                             });
                break;
        }
    }
}
