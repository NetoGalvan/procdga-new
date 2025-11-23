<?php

namespace App\Http\Controllers\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;

use App\Models\InstanciaTarea;
use App\Models\Empleado;
use App\Models\NivelSalarial;
use App\Models\p22_reportes_dias_efectivamente_laborados\P22Reportes;
use App\Models\p22_reportes_dias_efectivamente_laborados\P22ReportesDetalle;

use App\Exports\p22_reportes_dias_efectivamente_laborados\ReportesExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ReporteDiasEfectivamenteLaboradosController extends Controller
{
    use RegistroInstancias;

    private $tipoReporte = [
            'RMF' => "REPORTE DE MULTAS FEDERALES", 
            'RML' => "REPORTE DE MULTAS LOCALES", 
            'RE' => "REPORTE DE ESCALAFÓN"
        ];

    private $meses = [
            "01"=>"ENERO", "02"=>"FEBRERO", "03"=>"MARZO", 
            "04"=>"ABRIL", "05"=>"MAYO", "06"=>"JUNIO",
            "07"=>"JULIO", "08"=>"AGOSTO", "09"=>"SEPTIEMBRE",
            "10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE"
        ];

/* ----- */
    private $queryEmpleadosRMF;
    private $queryEmpleadosRML;
    public function __construct()
    {
        $this->queryEmpleadosRMF = Empleado::query()->where('activo', true)
                                            ->where( function($q) {
                                                $q->where('unidad_administrativa', '11')->where('subunidad', '3');
                                            })
                                            ->where('nivel_salarial', '>', 80);

        $this->queryEmpleadosRML = Empleado::query()->where('activo', true)
                                            ->where('unidad_administrativa', '11')
                                            ->whereBetween('nivel_salarial', [80, 190]);
    }
/* ----- */    
    public function descripcion(){
        return view('p22_reportes_dias_efectivamente_laborados.tareas.descripcion');
    }

    public function iniciarProceso(Request $request){

        try {
            $user = Auth::user();
            DB::beginTransaction();

            $reportes = P22Reportes::create([
                'estatus' => "EN PROCESO",
                'area_creadora_id' => $user->area_id
            ]);
            $instancia = $this->crearInstancia('reportes_dias_efectivamente_laborados', $reportes, Auth::user()->area);
            $instanciaTarea = $instancia->crearInstanciaTarea('TRDEL01', 'NUEVO');

            DB::commit();
            return redirect()->route('reportes.dias.efectivamente.laborados.seleccion.reporte', [$reportes, $instanciaTarea])->with("success", "El proceso se creó correctamente.");
        } catch (\Exception $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }

    public function cancelarProceso(Request $request, P22Reportes $reportes, InstanciaTarea $instanciaTarea){
        try {
            DB::beginTransaction();
            InstanciaTarea::where('instancia_id', $instanciaTarea->instancia_id)->update([ 
                                'estatus' => 'CANCELADO' 
                            ]);

            P22Reportes::where('p22_reporte_id', $reportes->p22_reporte_id)->update([ 
                            'activo' => false,
                            'estatus' => 'CANCELADO' 
                        ]);
            DB::commit();
            return redirect()->route('procesos')->with("success", 'El proceso se ha finalizado correctamente.');

        } catch (\Throwable $th) {
            DB::rollback();
             return redirect()->back()->with("error", $th);
        }
    }

    public function configuracionFechas($fechaPart, $año, $request)
    {
        $fecha = explode('-', $fechaPart);
        $date = null;

        foreach($this->meses as $key => $mes){
            switch ( $request->tipo_reporte ) {
                case 'RML':
                    if($fecha[0] == $mes) return Carbon::parse($año . '-' . $key);
                break;
                
                default:
                    if($fecha[0] == $mes) return Carbon::parse($fecha[1] . '-' . $key);
                break;
            }
        }
    }

    public function seleccionReporte(Request $request, P22Reportes $reportes, InstanciaTarea $instanciaTarea) {
        $instancia =  $reportes->instancia;
        $tipo_reporte = $this->tipoReporte;

        if ($request->isMethod('post')) {

            try {
                DB::beginTransaction();

                $peridoEvaluacion = $request->periodo_evaluacion;
                switch ( $request->tipo_reporte ) {
                    case 'RML':
                        $newPeriodo = preg_replace('/ DEL | A /', "-", str_replace("DE ", "", $peridoEvaluacion));
                        $periodos = explode('-', $newPeriodo);

                        $fecha_inicio = $this->configuracionFechas($periodos[0], $periodos[2], $request);
                        $fecha_fin = $this->configuracionFechas($periodos[1], $periodos[2], $request);
                    break;
                    
                    default:
                        $newPeriodo = str_replace(' DEL ', "-", str_replace("DE ", "", $peridoEvaluacion));
                        $periodos = explode(' A ', $newPeriodo);

                        $fecha_inicio = $this->configuracionFechas($periodos[0], null, $request);
                        $fecha_fin = $this->configuracionFechas($periodos[1], null, $request);
                    break;
                }

                $user = Auth::user();

                $reportes->tipo_reporte = $this->tipoReporte[$request->tipo_reporte];
                $reportes->fecha_inicio_evaluacion = $fecha_inicio->format('Y-m-d');
                $reportes->fecha_fin_evaluacion = $fecha_fin->format('Y-m-t');
                $reportes->nombre_periodo_evaluacion = $peridoEvaluacion;
                $reportes->elaboro_id = $user->id;

                $reportes->created_on = now()->format('Y-m-d');
                $reportes->save();

                $instanciaTarea->updateEstatus('COMPLETADO');
                $regresa = $instancia->crearInstanciaTarea('TRDEL02', 'NUEVO');
                
                DB::commit();
                return redirect()->route('reportes.dias.efectivamente.laborados.revision.concentrado.empleados', [$reportes, $regresa->instancia_tarea_id ] )->with("success", "La tarea finalizó correctamente.");

            } catch (\Throwable $th) {
                DB::rollback();
                return redirect()->back()->with( "error", $th );
            }
        }

        
        return view('p22_reportes_dias_efectivamente_laborados.tareas.TRDEL01_seleccionReporte', compact('reportes', 'instanciaTarea', 'tipo_reporte'));
    }

    public function revisionConcentradoEmpleados(Request $request, P22Reportes $reportes, InstanciaTarea $instanciaTarea) {

        $tipo_reporte = $this->tipoReporte;
        $instancia =  $reportes->instancia;

        if ( $request->isMethod('post') ) 
        {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $regresa = $instancia->crearInstanciaTarea('TRDEL03', 'NUEVO');
   
            return redirect()->route('reportes.dias.efectivamente.laborados.generacion.reporte', [$reportes, $regresa->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");
        }

        return view('p22_reportes_dias_efectivamente_laborados.tareas.TRDEL02_revisionConcentradoEmpleados', compact('reportes', 'instanciaTarea', 'tipo_reporte'));

    }

    public function tableEmpleadosAgregados(Request $request, $reporte_id)
    {
        try {
            DB::beginTransaction();
            $reporte = P22Reportes::find($reporte_id);

            if( isset($request->datos_empleado) )
            {
                $datosEmpleado = json_decode($request->datos_empleado);
                $empleados = P22ReportesDetalle::where('empleado_id', $datosEmpleado->empleado_id)->where('p22_reporte_id', $reporte_id);
/*    
                switch ( $reporte->tipo_reporte ) {
                    case $this->tipoReporte['RMF']:
                        $listadoEmpleados = $this->queryEmpleadosRMF->get()->take(20);
                    break;
                    
                    case $this->tipoReporte['RML']:
                        $listadoEmpleados = $this->queryEmpleadosRML->get()->take(20);
                    break;
                }

                foreach($listadoEmpleados as $empleado){
                    if( $empleado->nombre_completo == $datosEmpleado->nombre_completo ) {
                        return response()->json(['estatus' => false, 'mensaje' => "EL empleado <b>$datosEmpleado->nombre_completo</b> se encuentra dentro del listado"]);
                    }
                }   
*/
                if ( !$empleados->exists() ) {

                    if ($reporte->tipo_reporte == $this->tipoReporte['RE']) 
                    {   
                        if( $datosEmpleado->es_sindicalizado ) {
                            
                            P22ReportesDetalle::where('p22_reporte_id', $reporte_id)->where('activo', true)->update([ 'activo' => false ]);
                            
                        } else {
                            return response()->json(['estatus' => false, 'mensaje' => "<b>$datosEmpleado->nombre_completo</b><br> No es sindicalizado"]);
                        }
                    }

                    $detalleReporte = new P22ReportesDetalle();

                    $detalleReporte->folio = $reporte->folio;
                    $detalleReporte->p22_reporte_id = $reporte_id;
                    $detalleReporte->area_creadora_id = $reporte->area_creadora_id;
                    $detalleReporte->empleado_id = $datosEmpleado->empleado_id;
                    $detalleReporte->rfc = $datosEmpleado->rfc;
                    $detalleReporte->numero_empleado = $datosEmpleado->numero_empleado;
                    $detalleReporte->elaboro_id = $reporte->elaboro_id;
                    $detalleReporte->created_on = now();
                    $detalleReporte->created_at = now();
                    $detalleReporte->updated_at = now();
                    $detalleReporte->save();

                } else {
                    if ( $empleados->where('activo', false)->exists() ) {

                        $empleados->update([ 'activo' => true ]);
                    }  else {

                        return response()->json(['estatus' => false, 'mensaje' => "<b>$datosEmpleado->nombre_completo</b><br>Ya se encuentra agregado"]);
                    }
                }
            }
            
            if( isset($request->remover_empleado) )
            {
                P22ReportesDetalle::where('p22_reporte_detalle_id', $request->reporte_detalle_id)->where('p22_reporte_id', $reporte_id)
                                  ->update([ 'activo' => false ]);

            }

            $empleadosAgregados = P22ReportesDetalle::where('p22_reporte_id', $reporte_id)->where('activo', true)->with('empleado')->get();
            DB::commit();
            return response()->json(['estatus' => true, 'empleados_agregados' => $empleadosAgregados]);
            
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th);
        }
    }

    public function descargarListadoEmpleadosEvaluacion($reporte){
        $reporte = P22Reportes::find($reporte);

        switch ( $reporte->tipo_reporte ) {
            case $this->tipoReporte['RMF']:
                $empleados = P22ReportesDetalle::where('p22_reporte_id', $reporte)->get();
                //$empleados = $this->queryEmpleadosRMF->get()->take(20);
            break;
            
            case $this->tipoReporte['RML']:
                $empleados = P22ReportesDetalle::where('p22_reporte_id', $reporte)->get();
                //$empleados = $this->queryEmpleadosRML->get()->take(20);
            break;
        }
        return $pdf = \PDF::loadView('p22_reportes_dias_efectivamente_laborados.formatos.pdf_listado_empleados', compact('empleados') )
                        ->stream('Listado-empleados-'.$reporte->folio.'.pdf');
    }

    public function generacionReporte(Request $request, P22Reportes $reportes, InstanciaTarea $instanciaTarea) {

        $instancia =  $reportes->instancia;

        $date = Carbon::now();

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();

                P22Reportes::where('p22_reporte_id', $reportes->p22_reporte_id)->update([ 'estatus' => "COMPLETADO" ]);

                $instanciaTarea->updateEstatus('COMPLETADO');
                
                DB::commit();
                return redirect()->route('tareas')->with('success', 'El proceso finalizó correctamente.');
            
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th);
                return redirect()->back()->with('error', $th);
            }
        }

        return view('p22_reportes_dias_efectivamente_laborados.tareas.TRDEL03_generacionReportes', compact('reportes', 'instanciaTarea'));
    }

    public function descargarReportes($reporte_id)
    {
        $reporte = P22Reportes::find($reporte_id);
        $reporteDetalle = P22ReportesDetalle::where('p22_reporte_id', $reporte_id)->where('activo', true)->get(); 
        $buscarEmpleados = Empleado::query();
        $tipo_reporte = $this->tipoReporte;

        switch ( $reporte->tipo_reporte ) {
            case $tipo_reporte['RMF']:
                $empleados = $buscarEmpleados->whereIn('rfc', $reporteDetalle->pluck('rfc'))->get();
                /*
                $empleados = $this->queryEmpleadosRMF->get()->take(20);

                $empleados = $empleados->concat($buscarEmpleados);
                */
            break;
            
            case $tipo_reporte['RML']:
                $empleados = $buscarEmpleados->whereIn('rfc', $reporteDetalle->pluck('rfc'))->get();
                /*
                $empleados = $this->queryEmpleadosRML->get()->take(20);
                $empleados = $empleados->concat($buscarEmpleados);
                */
            break;

            case $tipo_reporte['RE']:
                
                $empleados = $buscarEmpleados->where('activo', true)->where('rfc', $reporteDetalle->pluck('rfc'))->first();
            break;
        }

        return Excel::download(new ReportesExport($reporte, $empleados, $tipo_reporte), "reporte.xlsx");
    }

}
