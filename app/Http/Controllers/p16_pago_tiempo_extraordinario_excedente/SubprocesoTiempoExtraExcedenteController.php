<?php

namespace App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Empleado;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\InstanciaTarea;
use Illuminate\Support\Facades\Validator;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16HorasPorEmpleado;
// use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoPorArea;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoQuincenalAreas;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16TabuladorSueldoTecnicoOperativo;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16SubProcesoPagoTiempoExtraExcedente;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoQuincenalSubAreas;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente\ManejadorTareas;
use App\Exports\p16_pago_tiempo_extraordinario_excedente\HorasPorEmpleadoSubareaExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SubprocesoTiempoExtraExcedenteController extends Controller
{
    use ManejadorTareas;

    public function asignarPresupuestoSub(Request $request, P16SubProcesoPagoTiempoExtraExcedente $subPago, InstanciaTarea $instanciaTarea){
        if ($request->isMethod('post')) {

            DB::beginTransaction();
                $instancia = $subPago->instancia;
                $instanciaTarea->updateEstatus('COMPLETADO');
                foreach ($subPago->presupuestoQuincenalSubAreas as $subArea) {
                    if ($subArea->presupuesto_sub_area > 0) {
                        $instancia->crearInstanciaTarea('ASIGNACIÓN_DE_HORAS', 'NUEVO', $subArea);
                    }
                }
                $instancia->crearInstanciaTarea('REVISIÓN_Y_AUTORIZACIÓN_DE_HORAS_POR_SUB_ÁREAS', 'NUEVO');
            DB::commit();

            return redirect()->route('tareas')->with("success", "La tarea finalizo correctamente");
        }


        // Presupuesto asigando a esta Área
        $datosPresupuestoEstaUnidad = $subPago->presupuestoQuincenalArea;
        // Presupuestos asignados a sus Subáreas
        $datosPresupuestosSubUnidades = $subPago->presupuestoQuincenalSubAreas;

        // Obtenemos el las Subareas del Subproceso para validar la consulta
        $subAreas = Area::where('activo', true)
        ->where('area_id', $subPago->area->area_id) // Ajusta el valor 3 según tu necesidad
        ->orWhere('area_principal_id', $subPago->area->area_id) // Ajusta el valor 3 según tu necesidad
        ->whereHas('users', function ($query) {
            $query->where('activo', true)
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['ENLACE_TIEMPO_EXTRA', 'OPER_TIEMPO_EXTRA']);
                });
        })
        ->with(['subAreas' => function ($query) {
            $query->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['ENLACE_TIEMPO_EXTRA', 'OPER_TIEMPO_EXTRA']);
                    });
            });
        }])
        ->get();

        // Se valida si ya existen presupuestos asignanos a esa subárea
        foreach ($subAreas as $key => $subarea) {
            foreach ($datosPresupuestosSubUnidades as $key => $presupuestosSubarea) {
                if ( $subarea->area_id ==  $presupuestosSubarea->area_id) {
                    $subarea->presupuesto_sub_area = $presupuestosSubarea->presupuesto_sub_area;
                }
            }
        }

        return view("p16_pago_tiempo_extraordinario_excedente.tareas.ST01_asignarPresupuestoAreas",
        compact('subPago', 'instanciaTarea', 'datosPresupuestoEstaUnidad', 'datosPresupuestosSubUnidades', 'subAreas'));
    }

    public function asignarPresupuestoSubAreas(Request $request){

        try {
            $sumapresupuestos = P16PresupuestoQuincenalSubAreas::where('subproceso_pago_tiempo_extra_excedente_id',  $request->subproceso_id)
                                                                ->where('area_id', '!=' ,$request->area_id)
                                                                ->sum('presupuesto_sub_area');
            $sumatotal = ($sumapresupuestos + $request->presupuesto);

            if ($request->presupuesto_total < $sumatotal ) {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡La suma de los presupuestos, no debe ser mayor al presupuesto asignado!' ];
                return response()->json($respuesta);
            } else {
                DB::beginTransaction();
                DB::table('p16_presupuesto_quincenal_subareas')
                            ->updateOrInsert(
                                ['subproceso_pago_tiempo_extra_excedente_id' => $request->subproceso_id, 'area_id' => $request->area_id],
                                ['subproceso_pago_tiempo_extra_excedente_id' => $request->subproceso_id,
                                'area_id' => $request->area_id,
                                'presupuesto_sub_area' => $request->presupuesto,
                                'created_at' => now(),
                                'updated_at' => now()]
                            );
                $respuesta = [
                    'estatus' => true,
                    'mensaje' => '¡Presupuesto asignado exitosamente!' ];

                DB::commit();
                return response()->json($respuesta);
            }


        } catch (\Throwable $th) {
            DB::rollback();
            $respuesta = [
                'estatus' => false,
                'mensaje' => '¡Error al asignar presupuesto!' ];

            return response()->json($respuesta);
        }
    }

    public function asignarHorasEmpleado(Request $request, P16SubProcesoPagoTiempoExtraExcedente $subPago, InstanciaTarea $instanciaTarea){

        $instancia = $subPago->instancia;

        if ($request->isMethod('post')) {
            $instancia = $subPago->instancia;
            $instanciaTarea->updateEstatus('COMPLETADO');
            return redirect()->route('tareas')->with("success", "La tarea finalizo correctamente");
        }

        $presuQuinceSubarea = $subPago->presupuestoQuincenalSubAreas->where('area_id', $instanciaTarea->pertenece_al_area)->first();
        $presuQuinceSubarea->area;

        $empleadosAgregados = $presuQuinceSubarea->empleados;

        $meses_fecha = array("01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL", "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO", "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE");
        $fecha_cadena = Carbon::parse($subPago->pagoTiempoExtra->fecha_limite);
        $cadena_fecha= $fecha_cadena->format('d') . ' DE ' . $meses_fecha[$fecha_cadena->format('m')] . ' DE ' . $fecha_cadena->format('Y');
        // Datos de Tabla principal
        $procesoPago = $subPago->pagoTiempoExtra;

        return view("p16_pago_tiempo_extraordinario_excedente.tareas.ST02_asignarHorasEmpleados", compact('subPago', 'instanciaTarea', 'presuQuinceSubarea', 'empleadosAgregados', 'cadena_fecha', 'procesoPago'));
    }

    public function agregarEmpleado(Request $request){

        $emple = json_decode($request->empleado);
        try {

            $subprocesoExiste = P16SubProcesoPagoTiempoExtraExcedente::where('subproceso_pago_tiempo_extra_excedente_id',  $request->subproceso_id)->exists();

            if ( $subprocesoExiste ) {
                $subproceso = P16SubProcesoPagoTiempoExtraExcedente::find($request->subproceso_id);

                $existeEmpleado = false;
                $pago = $subproceso->pagoTiempoExtra;

                foreach ($pago->subprocesos as $i => $sub) {
                    foreach ($sub->horasEmpleados as $horaEmpleado) {
                        if ($emple->rfc === $horaEmpleado->rfc) {
                            $existeEmpleado = true;
                            break;
                        }
                    }
                }
                if ( $existeEmpleado ) {
                    $response = ['estatus' => false, 'mensaje' => 'El empleado ya ha sido registrado en el proceso actual'];
                    return response()->json($response);
                } else {

                    // Se obtienen las fechas de inicio y fin de la quincena
                    $fechasConvertidas = $this->obtenerHorasQuincena($subproceso->pagoTiempoExtra->quincena);
                    // Aquí se validan las horas
                    $empleado = Empleado::where("numero_empleado", $emple->numero_empleado)->first();
                    $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, $fechasConvertidas[0], $fechasConvertidas[1]);
                    $horasExtraPorFechas = $administrarAsistencia->getHorasExtraPorFechas();

                    $totalHorasExtra = $this->validacionHoras($horasExtraPorFechas);

                    $sindicalizado = '';
                    if ($emple->es_sindicalizado == true) {
                        $sindicalizado = "SI";
                    } else if ($emple->es_sindicalizado == false) {
                        $sindicalizado = "NO";
                    }
                    DB::beginTransaction();
                        $horasPorEmpleado = P16HorasPorEmpleado::create([
                            'subproceso_pago_tiempo_extra_excedente_id' => $request->subproceso_id,
                            'p16_presupuesto_quincenal_subareas_id' => $request->presu_quince_subarea_id,
                            'unidad_administrativa_id' => $emple->unidad_administrativa,
                            'unidad_administrativa_nombre' => $emple->unidad_administrativa_nombre,
                            'folio' => $request->folio,
                            'rfc' => $emple->rfc,
                            'tipo' => $request->tipo,
                            'numero_empleado' => $emple->numero_empleado,
                            'nombre_empleado' => $emple->nombre,
                            'apellido_paterno' => $emple->apellido_paterno,
                            'apellido_materno' => $emple->apellido_materno,
                            'nivel_salarial' => $emple->nivel_salarial,
                            'sindicalizado' => $sindicalizado,
                            'codigo_puesto' => $emple->codigo_puesto,
                        ]);
                    DB::commit();
                        $horas_empleado_id = $horasPorEmpleado->horas_empleado_id;

                    $instanciaTarea = InstanciaTarea::find($request->instancia_tarea_id);
                    $subproceso = P16SubProcesoPagoTiempoExtraExcedente::find($request->subproceso_id);
                    $presuQuinceSubarea = $subproceso->presupuestoQuincenalSubAreas->where('area_id', $instanciaTarea->pertenece_al_area)->first();
                    $empleadosHoras = $presuQuinceSubarea->empleados;
                    $response = ['estatus' => true,
                                'mensaje' => 'Empleado agregado correctamente',
                                'data' => $empleadosHoras,
                                'idEmpleadoCreado' => $horas_empleado_id,
                                'totalHorasExtra' => $totalHorasExtra];
                    return response()->json($response);
                }
            } else {
                $response = ['estatus' => false, 'mensaje' => 'No existe el Subproceso'];
                return response()->json($response);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            $response = ['estatus' => false, 'mensaje' => 'Error: '. $e];
            Log::warning(__METHOD__ . "--->Line:" . $e->getLine() . "----->" . $e->getMessage());
            return response()->json($response);
        }
    }

    // Aplica las reglas de validación para cada usuario
    public function validacionHoras( $datos ) {

        // Regla uno: cada dato debe tener máximo 3
        foreach ($datos as $fecha => $valor) {
            if ($valor > 3) {
                $datos[$fecha] = 3;
            }
        }

        // Regla tres: No puede tener 4 datos seguidos con número mayor a 0
        $consecutivosMayoresA0 = 0;
        foreach ($datos as $fecha => $valor) {
            if ($valor > 0) {
                $consecutivosMayoresA0++;
                if ($consecutivosMayoresA0 == 4) {
                    $datos[$fecha] = 0;
                    $consecutivosMayoresA0 = 0;
                }
            } else {
                $consecutivosMayoresA0 = 0;
            }
        }

        // Regla dos: por cada 7 datos no debe superar un total de 12
        $total = 0;
        $contador = 0;
        foreach ($datos as $fecha => $valor) {
            $total += $valor;
            $contador++;
            if ($contador == 7) {
                if ($total > 12) {
                    $exceso = $total - 12;
                    $datos[$fecha] -= $exceso;
                    $total -= $exceso;
                }
                $contador = 0;
                $total = 0;
            }
        }

        // Regla cuatro: Cada quince días no deben sumar más de 24
        $suma = 0;
        $dias = 0;
        foreach ($datos as $fecha => $valor) {
            $suma += $valor;
            $dias++;
            if ($dias == 15) {
                if ($suma > 24) {
                    $exceso = $suma - 24;
                    $datos[$fecha] -= $exceso;
                    $suma -= $exceso;
                }
                $dias = 0;
                $suma = 0;
            }
        }

        // Calcular el total después de aplicar todas las validaciones
        $totalFinal = array_sum($datos);
        return $totalFinal;

    }

    // Obtiene la fechas de la quincena a evaluar
    public function obtenerHorasQuincena( $quincena ) {
        // Expresión regular para encontrar fechas en el formato DD/MM/YYYY
        $patron = '/\d{2}\/\d{2}\/\d{4}/';

        // Buscar todas las coincidencias
        preg_match_all($patron, $quincena, $coincidencias);

        // Inicializar un arreglo para almacenar las fechas convertidas
        $fechasConvertidas = [];

        // Iterar sobre las fechas encontradas
        foreach ($coincidencias[0] as $fecha) {
            // Crear un objeto Carbon a partir de la fecha encontrada
            $fechaCarbon = Carbon::createFromFormat('d/m/Y', $fecha);

            // Convertir la fecha al formato deseado
            $fechaFormatoDeseado = $fechaCarbon->format('d-m-Y');

            // Agregar la fecha convertida al arreglo
            $fechasConvertidas[] = $fechaFormatoDeseado;
        }

        return $fechasConvertidas;
    }

    public function guardarDatosAutomaticamente(Request $request){

        try {

            DB::beginTransaction();

                $instanciaTarea = InstanciaTarea::find($request->instancia_tarea_id);
                $subproceso = P16SubProcesoPagoTiempoExtraExcedente::find($request->datos['subproceso_pago_tiempo_extra_excedente_id']);
                $presuQuinceSubarea = $subproceso->presupuestoQuincenalSubAreas->where('area_id', $instanciaTarea->pertenece_al_area)->first();

                // Monto sin tomar el input que esta siento capturado
                $montoOtrosEmpleados = $presuQuinceSubarea->empleados()->where('horas_empleado_id', '!=', $request->empleado_id)->sum('monto_bruto');
                // Se suma los costos si existen más el precio nuevo
                $totalMontoBruto = ($montoOtrosEmpleados + $request->monto_bruto);

                if ($totalMontoBruto > $request->datos['presupuesto_sub_area']) {
                    // Se regresa el dato que existe si no se cumple para actualizar los campos a su valor original
                    $horasEmpledo = P16HorasPorEmpleado::select('horas', 'monto_bruto', 'observaciones')->find($request->empleado_id);
                    return response()->json(['estatus' => false, 'mensaje' => 'El total de lo ya acumulado más la cantidad ingresada, supera el limite del presupuesto asignado, por lo que no es posible realizar esta acción.',
                                            'data' => $horasEmpledo]);
                } else {
                    $meno = P16HorasPorEmpleado::find($request->empleado_id);
                    $meno->horas = $request->datos['horas'];
                    $meno->monto_bruto = $request->monto_bruto;
                    $meno->save();
                }
            DB::commit();

            return response()->json(['estatus' => true, 'mensaje' => 'Datos guardados correctamente']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['estatus' => false, 'mensaje' => 'Error: ' . $th]);
            Log::warning(__METHOD__ . "--->Line:" . $th->getLine() . "----->" . $th->getMessage());
        }
    }

    public function guardarObservacionesAutomaticamente(Request $request){

        try {

            DB::beginTransaction();

                $empleado = P16HorasPorEmpleado::find($request->empleado_id);
                $empleado->observaciones = strtoupper($request->observaciones);
                $empleado->save();

            DB::commit();

            return response()->json(['estatus' => true, 'mensaje' => 'Datos guardados correctamente']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['estatus' => false, 'mensaje' => 'Error: ' . $th]);
            Log::warning(__METHOD__ . "--->Line:" . $th->getLine() . "----->" . $th->getMessage());
        }
    }

    public function calcularMontoBruto(Request $request){

        $rules = [
            'nivel_salarial' => 'required|numeric',
            'tipo_personal' => ['required', 'string'],
            'horas' => 'required|numeric|max:24',
        ];
        $messages = [
            'nivel_salarial.required' => 'No se recibió el nivel Salarial.',
            'nivel_salarial.numeric' => 'Formato desconocido (Nivel Salarial)',
            'tipo_personal.required' => 'No se recibió el tipo de personal.',
            'tipo_personal.string' => 'Formato desconocido (Tipo de Personal).',
            'horas.required' => 'Ingrese las horas laboradas.',
            'horas.numeric' => 'Formato desconocido (Horas Laboradas).',
            'horas.max' => 'El máximo de horas es 24 hrs.',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $tipo = null;
        if ($request->tipo_personal == "NO") {
            if ( substr($request->codigo_puesto, 0, 2) ===  "CF") {
                $tipo = "CONFIANZA";
            } else {
                $tipo = "BASE_NO_SINDICALIZADO";
            }
        }elseif ($request->tipo_personal == "SI") {
            $tipo = "BASE_SINDICALIZADO";
        }

        $totalMensual= P16TabuladorSueldoTecnicoOperativo::where('nivel_salarial', $request->nivel_salarial)
        ->where('tipo', $tipo)
        ->where('anio', now()->year)
        ->first();

        if ($totalMensual != null) {

            $doble_o_triple = 0;

            if ($request->tipo_pago == "EXTRAORDINARIO") {
                $doble_o_triple = 2;
            } else if ($request->tipo_pago == "EXCEDENTE") {
                $doble_o_triple = 3;
            }
            $factor120 = $totalMensual->total_mensual_bruto / 30 / 8 * $doble_o_triple;
            $montoBruto = $factor120 * $request->horas;

            return response()->json([ "estatus" => true, "mensaje" => round($montoBruto,2), "costo_unitario" => round($factor120,2) ]);

        } else {
            return response()->json([ "estatus" => false, "mensaje" => "No existe tabulador para este tipo de personal." ]);
        }

    }

    public function borrarEmpleados(Request $request){
        try {
            DB::beginTransaction();
            P16HorasPorEmpleado::destroy($request->id);

            $instanciaTarea = InstanciaTarea::find($request->instancia_tarea_id);
            $subproceso = P16SubProcesoPagoTiempoExtraExcedente::find($request->subproceso_id);
            $presuQuinceSubarea = $subproceso->presupuestoQuincenalSubAreas->where('area_id', $instanciaTarea->pertenece_al_area)->first();
            $empleadosHoras = $presuQuinceSubarea->empleados;
            DB::commit();
            $response = ['estatus' => true, 'mensaje' => '¡Empleado Eliminado Correctamente!', 'data' => $empleadosHoras];
        } catch (\Throwable $e) {
            DB::rollback();
            $response = ['estatus' => false, 'mensaje' => 'Hubo un error al borrar la información. Code-STEEC09'];
            Log::warning(__METHOD__ . "--->Line:" . $e->getLine() . "----->" . $e->getMessage());
        }
        return response()->json($response);
    }

    public function validarEmpleado(Request $request){
        try {
            $empleado = json_decode($request->datos_empleado);
            return response()->json([ "estatus" => true, "empleado" => $empleado ]);
        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => $th ]);
        }
    }

    public function revisionHorasSubarea(Request $request, P16SubProcesoPagoTiempoExtraExcedente $subPago, InstanciaTarea $instanciaTarea){

        if ($request->isMethod('post')) {
            try {
                $subtareas = json_decode($request->avance_subareas);
                foreach ($subtareas as $key => $subtarea) {
                    if ($subtarea->estatus != 'COMPLETADO') {
                        InstanciaTarea::query()->where('instancia_tarea_id', $subtarea->instancia_tarea_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR LA SUBTAREA 2 - ASIGNACIÓN DE HORAS']);
                        P16HorasPorEmpleado::where('p16_presupuesto_quincenal_subareas_id', $subtarea->p16_presupuesto_quincenal_subareas_id)->delete();
                    }
                }

                DB::beginTransaction();
                    $instancia = $subPago->instancia;
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $subPago->estatus = "COMPLETADO";
                    $subPago->save();
                DB::commit();
                return redirect()->route('tareas')->with("success", "El subproceso finalizó correctamente");

            } catch (\Throwable $th) {
                DB::rollback();
                return back()->withInput()->withErrors(['mensaje_error' => "Error: $th"]);
            }
        }

        $pendientes = 0;
        $subareas_general = [];

        $instancia = $subPago->instancia;
        $subareas = $instancia->instanciasTareas->where('tarea.identificador', 'ASIGNACIÓN_DE_HORAS')->whereIn('estatus', ['NUEVO', 'COMPLETADO', 'EN_CORRECCION'])->values();

        foreach ($subareas as $key => $instanciaSubTarea) {
            $area = $instanciaSubTarea->perteneceAlArea;
            $presupuestoQuincenalSubarea = $instanciaSubTarea->instancia->model->presupuestoQuincenalSubAreas->where('area.area_id', $area->area_id)->first();
            $instanciaSubTarea->p16_presupuesto_quincenal_subareas_id = $presupuestoQuincenalSubarea->p16_presupuesto_quincenal_subareas_id;


            $subareas_general[] = $presupuestoQuincenalSubarea->p16_presupuesto_quincenal_subareas_id;
            if($instanciaSubTarea->estatus != 'COMPLETADO'){
                $pendientes++;
            }
        }

        $meses_fecha = array("01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL", "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO", "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE");
        $fecha_cadena = Carbon::parse($subPago->pagoTiempoExtra->fecha_limite);
        $cadena_fecha= $fecha_cadena->format('d') . ' DE ' . $meses_fecha[$fecha_cadena->format('m')] . ' DE ' . $fecha_cadena->format('Y');

        return view("p16_pago_tiempo_extraordinario_excedente.tareas.ST03_revisionHorasSubAreas", compact('subPago', 'instanciaTarea', 'subareas', 'pendientes', 'subareas_general', 'cadena_fecha'));
    }

    public function descargaReporteSubArea($subarea_id){
        try {

            $empleados = P16HorasPorEmpleado::where('p16_presupuesto_quincenal_subareas_id', $subarea_id)->get();
            $total_horas = 0;
            $total_monto_bruto = 0;

            foreach ($empleados as $value) {

                $area = Area::select('areas.nombre')
                    ->join('p16_presupuesto_quincenal_subareas as subarea', 'areas.area_id', '=', 'subarea.area_id')
                    ->where('subarea.p16_presupuesto_quincenal_subareas_id', $subarea_id)->first();

                $value->nombre_sub_area = $area;

                $total_horas +=  $value->horas;
                $total_monto_bruto +=  $value->monto_bruto;
            }

            $total_empleados = count($empleados);

            return Excel::download(new HorasPorEmpleadoSubareaExport($empleados, $total_horas, $total_monto_bruto, $total_empleados), 'Pago_tiempo_extra_'.$area->nombre.'.xlsx');
        } catch (\Throwable $th) {

        }
    }

    public function descargaReporteGeneralSubareas(Request $request){
        try {

            $area = Area::select('areas.nombre', 'subarea.p16_presupuesto_quincenal_subareas_id')
                    ->join('p16_presupuesto_quincenal_subareas as subarea', 'areas.area_id', '=', 'subarea.area_id')
                    ->whereIn('subarea.p16_presupuesto_quincenal_subareas_id', $request->subareas_general)->get();

            $empleados = P16HorasPorEmpleado::whereIn('p16_presupuesto_quincenal_subareas_id', $request->subareas_general)->get();

            $total_horas = 0;
            $total_monto_bruto = 0;

            foreach ($empleados as $value) {

                $total_horas +=  $value->horas;
                $total_monto_bruto +=  $value->monto_bruto;

                foreach ($area as $ar) {
                    if ($value->p16_presupuesto_quincenal_subareas_id == $ar->p16_presupuesto_quincenal_subareas_id) {
                        $value->nombre_sub_area = $ar;
                    }
                }
            }
            // dd($empleados);
            $total_empleados = count($empleados);
            return Excel::download(new HorasPorEmpleadoSubareaExport($empleados, $total_horas, $total_monto_bruto, $total_empleados), 'pago_tiempo_extra_general_subareas.xlsx');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function rechazarTareaSubarea(Request $request, P16SubProcesoPagoTiempoExtraExcedente $subPago, InstanciaTarea $instanciaTarea){

        try {

            $subArea = Area::select('areas.*')
                    ->join('p16_presupuesto_quincenal_subareas as subarea', 'areas.area_id', '=', 'subarea.area_id')
                    ->where('subarea.p16_presupuesto_quincenal_subareas_id', $request->subarea_id)->first();

            $instancia =  $subPago->instancia;

            DB::beginTransaction();
                // se atualiza el estatus de la instancia tarea seleccionada por "RECHAZADO" y se guarda el motivo para tener registro de todos los rechazos
                InstanciaTarea::query()->where('instancia_tarea_id', $request->instancia_tarea_id)
                ->update(['motivo_rechazo' => $request->motivo_rechazo, 'estatus' => 'RECHAZADO']);
                // se actualiza el registro de la subarea ´para tomar este dato y mostrarlo, así se rechace 10 veces, aquí se actualiza y se toma siempre el ultimo
                P16PresupuestoQuincenalSubAreas::query()->where('p16_presupuesto_quincenal_subareas_id', $request->subarea_id)
                ->update(['motivo_rechazo' => $request->motivo_rechazo]);
                // Ya que se hizo ese update, ahora si se crea la nueva tarea con el estatus de EN CORRECCION
                $instancia->crearInstanciaTarea('ASIGNACIÓN_DE_HORAS', 'EN_CORRECCION', $subArea);
            DB::commit();

            return back()->with("success", "Tarea rechazada correctamente. Se volvió a crear una nueva tarea para esa subarea");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->withErrors(['mensaje_error' => "Error: $th"]);
        }
    }
}
