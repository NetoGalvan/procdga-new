<?php

namespace App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\p16_pago_tiempo_extraordinario_excedente\HorasPorEmpleadoSubareaExport;
use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\ManejadorTareas;
use App\Http\Traits\RegistroInstancias;
use App\Models\InstanciaTarea;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PagoTiempoExtraExcedente;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16HorasPorEmpleado;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoQuincenalAreas;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoQuincenalSubAreas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16AreasProcesos;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16SubProcesoPagoTiempoExtraExcedente;

class TiempoExtraExcedenteController extends Controller
{
    use ManejadorTareas;
    use RegistroInstancias;

    public function descripcion() {
        return view("p16_pago_tiempo_extraordinario_excedente.tareas.descripcion");
    }

    public function inicializarProceso() {
        $pago = P16PagoTiempoExtraExcedente::create([
            "estatus" => "EN_PROCESO",
            "area_id" => Auth::user()->area_id,
        ]);
        $instancia = $this->crearInstancia("tiempo_extraordinario_excedente", $pago, Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea('ASIGNAR_PRESUPUESTO_A_AREAS', 'NUEVO');
        return redirect()
            ->route('tiempo.extraordinario.excedente.presupuesto.por.area', [$pago, $instanciaTarea])
            ->with("success", "El proceso se ha iniciado correctamente.");
    }

    public function asignarPresupuestoPorAreas(Request $request, P16PagoTiempoExtraExcedente $pago, InstanciaTarea $instanciaTarea) {
        $instancia = $pago->instancia;

        if ($request->isMethod('post')) {
            $areasPresupuesto = json_decode($request->areas_presupuesto);

            $existeQuincenaCapturada = P16PagoTiempoExtraExcedente::where('quincena', $request->quincena)->whereIn('estatus', ['EN_PROCESO', 'COMPLETADO'])->where('tipo', $request->tipo)->exists();
            if ( $existeQuincenaCapturada)  {
                $mensaje = '¡La quincena seleccionada y tipo esta en proceso o fue completada, por favor selecciona otra!';
                return redirect()
                        ->back()
                        ->with("error", $mensaje);
            }

            foreach ($areasPresupuesto as $area) {
                $subproceso = new P16SubProcesoPagoTiempoExtraExcedente();
                $subproceso->pago_tiempo_extra_excedente_id = $pago->pago_tiempo_extra_excedente_id;
                $subproceso->area_id = $area->area_id;
                $subproceso->estatus = "EN_PROCESO";
                $subproceso->fecha_limite = $request->fecha_limite;
                $subproceso->save();

                $presupuesto = new P16PresupuestoQuincenalAreas();
                $presupuesto->pago_tiempo_extra_excedente_id = $pago->pago_tiempo_extra_excedente_id;
                $presupuesto->subproceso_pago_tiempo_extra_excedente_id = $subproceso->subproceso_pago_tiempo_extra_excedente_id;
                $presupuesto->area_id = $area->area_id;
                $presupuesto->presupuesto = $area->presupuesto;
                $presupuesto->save();

                $instanciaSubproceso = $this->crearInstancia("subproceso_tiempo_extraordinario_excedente", $subproceso, $area, $instancia);
                $instanciaSubproceso->crearInstanciaTarea('ASIGNAR_PRESUPUESTO_A_SUB_AREAS', 'NUEVO');
            }

            $pago->quincena = $request->quincena;
            $pago->fecha_limite = $request->fecha_limite;
            $pago->tipo = $request->tipo;
            $pago->save();

            $instanciaTarea->updateEstatus("COMPLETADO");
            $instanciaTarea = $instancia->crearInstanciaTarea("REVISIÓN_Y_AUTORIZACIÓN_DE_HORAS_POR_AREAS", "NUEVO");

            return redirect()->route("tiempo.extraordinario.excedente.revision.por.empleado", [$pago, $instanciaTarea])
                ->with("success", "La tarea finalizó correctamente.");
        }

        $areas = Area::where('activo', true)
            ->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['ENLACE_TIEMPO_EXTRA']);
                    });
            })
            ->get();

        return view("p16_pago_tiempo_extraordinario_excedente.tareas.T01_asignarPresupuestoAreas", compact(
            "instanciaTarea",
            "pago",
            "areas"
        ));
    }

    public function revisarHorasEmpleado(Request $request,P16PagoTiempoExtraExcedente $pago, InstanciaTarea $instanciaTarea){
        if ($request->isMethod('post')) {

            try {

                $finalizarTareasSubprocesos = $this->finalizarTareasTodosSubprocesos($pago, $instanciaTarea);

                if ($finalizarTareasSubprocesos['estatus']) {

                    DB::beginTransaction();
                    $instancia = $pago->instancia;
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $pago->estatus = "COMPLETADO";
                    $pago->save();
                    DB::commit();

                    return redirect()->route('tareas')->with("success", "El proceso finalizó correctamente");

                } else {
                    return back()->withInput()->withErrors(['mensaje_error' => $finalizarTareasSubprocesos['mensaje']]);
                }

            } catch (\Throwable $th) {
                DB::rollback();
                return back()->withInput()->withErrors(['mensaje_error' => "Error: $th"]);
            }
        }

        $finalizado=0;
        $folios = [];
        $subInstancias = $pago->instancia->subInstancias;
        foreach ($subInstancias as $key => $subInstancia) {
            $areas[$key] = array('instancia_id' => $subInstancia->instancia_id, 'subproceso_pago_tiempo_extra_excedente_id' => $subInstancia->model->subproceso_pago_tiempo_extra_excedente_id, 'estatus' => $subInstancia->model->estatus, 'area' => $subInstancia->area->nombre, 'identificador' => $subInstancia->area->identificador, 'folio'=>$subInstancia->folio);
            $subInstancia->area;
            if($subInstancia->model->estatus != 'COMPLETADO'){
                $finalizado++;
            }
            $folios [] = $subInstancia->folio;
        }

        $meses_fecha = array("01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL", "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO", "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE");
        $fecha_cadena = Carbon::parse($pago->fecha_limite);
        $cadena_fecha= $fecha_cadena->format('d') . ' DE ' . $meses_fecha[$fecha_cadena->format('m')] . ' DE ' . $fecha_cadena->format('Y');

        return view("p16_pago_tiempo_extraordinario_excedente.tareas.T02_revisarHorasEmpleados",
        compact('pago', 'areas', 'subInstancias', 'finalizado', 'instanciaTarea', 'folios', 'cadena_fecha'));
    }

    public function descargaReporte($folio){
        try {
            $empleados = P16HorasPorEmpleado::where('folio', $folio)->get();
            $total_horas = 0;
            $total_monto_bruto = 0;

            foreach ($empleados as $value) {
                $total_horas +=  $value->horas;
                $total_monto_bruto +=  $value->monto_bruto;

                $area = Area::select('areas.nombre')
                ->join('p16_presupuesto_quincenal_subareas as subarea', 'areas.area_id', '=', 'subarea.area_id')
                ->where('subarea.p16_presupuesto_quincenal_subareas_id', $value->p16_presupuesto_quincenal_subareas_id)->first();

                $value->nombre_sub_area = $area;
            }

            $total_empleados = count($empleados);
            return Excel::download(new HorasPorEmpleadoSubareaExport($empleados, $total_horas, $total_monto_bruto, $total_empleados),'Pago_tiempo_extra_'.$folio.'.xlsx');

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function descargaReporteGeneral(Request $request){
        try {

            $empleados = P16HorasPorEmpleado::whereIn('folio', $request->folios)->get();
            $area = [];
            $total_horas = 0;
            $total_monto_bruto = 0;

            foreach ($empleados as $e) {

                $total_horas +=  $e->horas;
                $total_monto_bruto +=  $e->monto_bruto;

                $area [] = Area::select('areas.nombre', 'subarea.p16_presupuesto_quincenal_subareas_id')
                ->join('p16_presupuesto_quincenal_subareas as subarea', 'areas.area_id', '=', 'subarea.area_id')
                ->where('subarea.p16_presupuesto_quincenal_subareas_id', $e->p16_presupuesto_quincenal_subareas_id)->get();

                foreach ($area as $ar) {
                    foreach ($ar as $a) {
                        if ($e->p16_presupuesto_quincenal_subareas_id == $a->p16_presupuesto_quincenal_subareas_id) {
                            $e->nombre_sub_area = $a;
                        }
                    }
                }
            }

            $total_empleados = count($empleados);

            return Excel::download(new HorasPorEmpleadoSubareaExport($empleados, $total_horas, $total_monto_bruto, $total_empleados), 'Pago_tiempo_extra_GENERAL.xlsx');

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
