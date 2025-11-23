<?php

namespace App\Http\Controllers\p20_premio_puntualidad_asistencia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\p20_premio_puntualidad_asistencia\ManejadorTareas;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\p20_premio_puntualidad_asistencia\P20Premio;
use App\Models\p20_premio_puntualidad_asistencia\P20Nomina;
use App\Models\Area;
use Carbon\Carbon;
use DateInterval;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\p20_premio_puntualidad_asistencia\LayoutConNombres;
use App\Exports\p20_premio_puntualidad_asistencia\LayoutSinNombres;
use App\Exports\p20_premio_puntualidad_asistencia\EmpleadosAgregadosSubareas;
use App\Models\InstanciaTarea;
use App\Models\User;
use App\Http\Servicios\Empleado;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidad;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidadAreas;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidadEmpleados;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidadInscripcion;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\Empleado as EmpleadoModel;

class PremioPuntualidadAsistenciaController extends Controller
{
    use ManejadorTareas;
    use Empleado;

    public function descripcion(){
        return view('p20_premio_puntualidad_asistencia.tareas.descripcion');
    }

    public function iniciarProceso() {
        try {
            $user = Auth::user();
            DB::beginTransaction();

            $premioPuntualidad = P20PremioPuntualidad::create([
                'estatus' => 'EN_PROCESO',
                'area_id' => $user->area_id,
            ]);
            $instancia = $this->crearInstancia('premio_puntualidad_asistencia', $premioPuntualidad, Auth::user()->area);
            $instanciaTarea = $instancia->crearInstanciaTarea('DEFINIR_PARAMETROS_CONVOCATORIA', 'NUEVO');
            DB::commit();

            return redirect()
                    ->route('seleccion.quincena.unidades.administrativas', [$premioPuntualidad, $instanciaTarea])
                    ->with("success", "El proceso se ha iniciado correctamente.");

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('premio.puntualidad.asistencia.descripcion')->with('error', 'No se pudo crear el proceso, intente más tarde ');
        }
    }

    // PROCESO

    // T01
    public function seleccionQuincena(Request $request, P20PremioPuntualidad $premioPuntualidad, InstanciaTarea $instanciaTarea) {

        $user = Auth::user();
        $instancia =  $premioPuntualidad->instancia;

        // Obtén las áreas que tienen el rol ENLACE_PREMIO_PUNTUALIDAD
        $areasQueParticipan = Area::where('activo', true)
            ->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['ENLACE_PREMIO_PUNTUALIDAD']);
                    });
            })
            ->get();

        if ($request->isMethod('post')) {

            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $instanciaTarea->motivo_rechazo = 'CANCELACIÓN EN TAREA 1 - SELECCIÓN DE QUINCENA y ÁREAS';
                $instanciaTarea->save();
                $premioPuntualidad->estatus = 'CANCELADO';
                $premioPuntualidad->activo = false;
                $premioPuntualidad->save();

                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            }

            $existeQuincena = P20PremioPuntualidad::where('quincena', $request->fecha_quincena)->whereIn('estatus', ['EN_PROCESO', 'COMPLETADO'])->exists();
            if ($existeQuincena) {
                return back()->withInput()->withErrors(['mensaje_error' => '¡Esa Quincena ya fue capturada o esta en proceso!']);
            }
            // Pasamos los datos para su guardado
            $areasParticipantes = json_decode($request->areas);

            $guardo = $this->guardarAreasSeleccionadasT01($request, $user, $premioPuntualidad, $areasParticipantes);

            if ($guardo['estatus']) {
                $subproceso = $this->crearSubprocesoPremio($instancia, $premioPuntualidad, $areasParticipantes);
                if ($subproceso) {

                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('RECEPCION_REVISION_SOLICITUDES', 'NUEVO');
                    return redirect()->route('tareas')->with("success", "¡La tarea finalizo correctamente!");
                }else {
                    return back()->withInput()->withErrors(['mensaje_error' => $subproceso['mensaje']]);
                }
            }else {
                return back()->withInput()->withErrors(['mensaje_error' => $guardo['mensaje']]);
            }
        }

        return view('p20_premio_puntualidad_asistencia.tareas.TPPA01_seleccionQuincena', compact('premioPuntualidad', 'instanciaTarea', 'areasQueParticipan'));
    }

    // T02
    public function concentradoRevision(Request $request, P20PremioPuntualidad $premioPuntualidad, InstanciaTarea $instanciaTarea){

        $instancia      =  $premioPuntualidad->instancia;
        $subprocesos    =  $premioPuntualidad->inscripciones;
        foreach ($subprocesos as $key => $subproceso) {
            $subproceso->area;
        }

        if ($request->isMethod('post')) {

            try {
                $avanceSubprocesos = json_decode($request->avance_subprocesos);
                foreach ($avanceSubprocesos as $key => $avanceSubproceso) {
                    // Se onbtiene como Objeto
                    $avanceSubproceso = P20PremioPuntualidadInscripcion::find($avanceSubproceso->premio_puntualidad_inscripcion_id);
                    if ($avanceSubproceso->estatus != 'COMPLETADO') {
                        // Se cancelan las Instancias Tareas que no fueron completadas
                        InstanciaTarea::query()->where('instancia_id', $avanceSubproceso->instancia->instancia_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR']);
                        // Se cancelan las Áreas que no fueron completadas
                        P20PremioPuntualidadAreas::where('premio_puntualidad_inscripcion_id', $avanceSubproceso->premio_puntualidad_inscripcion_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR']);
                        // Se eliminan los empleados relacionados
                        P20PremioPuntualidadEmpleados::where('premio_puntualidad_inscripcion_id', $avanceSubproceso->premio_puntualidad_inscripcion_id)->delete();
                        // Finalmente se cancela el Subproceso
                        $avanceSubproceso->update(['estatus' => "CANCELADO"]);
                    }
                }

                DB::beginTransaction();

                    $premioPuntualidad->subproceso_fin = now();
                    $premioPuntualidad->save();

                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('GENERACION_ARCHIVOS_TRAMITE', 'NUEVO');

                DB::commit();
                return redirect()->route('tareas')->with("success", "¡La tarea finalizó correctamente!");

            } catch (\Throwable $th) {
                DB::rollback();
                return back()->withInput()->withErrors(['mensaje_error' => '¡Error: Intente más tarde!']);
            }

        }

        return view('p20_premio_puntualidad_asistencia.tareas.TPPA02_concentradoRevision', compact('premioPuntualidad', 'instanciaTarea', 'subprocesos' ));
    }

    public function descargaReporte($folio){
        try {
            $empleados = P20PremioPuntualidadEmpleados::where('folio', $folio)->get();
            return Excel::download(new EmpleadosAgregadosSubareas($empleados),'Premio_puntualidad_asistencia_'.$folio.'.xlsx');

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error al generar el layout "  ], 500);
        }
    }

    // T03
    public function generacionArchivosPago(Request $request, P20PremioPuntualidad $premioPuntualidad, InstanciaTarea $instanciaTarea){

        $instancia      =  $premioPuntualidad->instancia;
        $subprocesos    =  $premioPuntualidad->inscripciones;
        foreach ($subprocesos as $key => $subproceso) {
            $subproceso->area;
        }

        if ($request->isMethod('post')) {

            // Cancelar proceso
            if ($request->accion == "cancelar") {

                // Si se cancela se empieza recorriendo las Inscripciones (Subprocesos)
                foreach ($subprocesos as $key => $subproceso) {
                    // Se cancelan las Áreas por Inscripción (Subproceso)
                    P20PremioPuntualidadAreas::where('premio_puntualidad_inscripcion_id', $subproceso->premio_puntualidad_inscripcion_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR T03']);
                    // Se eliminan los empleados relacionados
                    P20PremioPuntualidadEmpleados::where('premio_puntualidad_inscripcion_id', $subproceso->premio_puntualidad_inscripcion_id)->delete();
                    // Se cancelan las Instancias Tareas
                    InstanciaTarea::query()->where('instancia_id', $subproceso->instancia->instancia_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR T03']);
                }
                // Ahora se pueden cancelar los Subprocesos
                P20PremioPuntualidadInscripcion::where('premio_puntualidad_id', $premioPuntualidad->premio_puntualidad_id)->update(['estatus' => "CANCELADO"]);

                // Se Cancela el Proceso
                $premioPuntualidadCancelado = $premioPuntualidad->update([
                    'estatus' => 'CANCELADO'
                ]);
                if ( $premioPuntualidadCancelado ) {
                    // Finalmente se finaliza la Instancia Tarea del Proceso principal
                    $instanciaTarea->updateEstatus('CANCELADO');
                    $instanciaTarea->motivo_rechazo = 'CANCELACIÓN ANTES DE FINALIZAR EN T03';
                    $instanciaTarea->save();
                    return redirect()->route("tareas")
                            ->with("success", "El proceso se canceló correctamente.");
                } else {
                    // Si surge un error los manda a las tareas nuevamente.
                    $mensaje = 'Error, No se Cancelo la tarea, intentalo más tarde';
                    return redirect()->route('tareas')->with('error', $mensaje);
                }
            }

            $premioPuntualidad->inscripciones;

            $subproceso = $this->crearNotificacionAreas($instancia, $premioPuntualidad);
            if ($subproceso['estatus']) {
                $premioPuntualidad->estatus = "COMPLETADO";
                $premioPuntualidad->save();
                $instanciaTarea->updateEstatus('COMPLETADO');
                return redirect()->route('tareas')->with("success", "¡El proceso finalizó correctamente!");
            } else {
                return back()->withInput()->withErrors(['mensaje_error' => "Error: Por favor intente más tarde"]);
            }
        }

        return view('p20_premio_puntualidad_asistencia.tareas.TPPA03_generacionArchivosPago', compact('premioPuntualidad', 'instanciaTarea', 'subprocesos' ));
    }

    protected $num_emple_longitud = 10;
    protected $unidad_longitud = 3;
    protected $codigo_sun = 1122;
    protected $dependencia_valor = "00000000";
    protected $switch = "01";
    protected $dato_adicional = "00000";
    protected $complemento_unidad = "00";

    protected $mesesIngles = [
        'ENERO' => 'January',
        'FEBRERO' => 'February',
        'MARZO' => 'March',
        'ABRIL' => 'April',
        'MAYO' => 'May',
        'JUNIO' => 'June',
        'JULIO' => 'July',
        'AGOSTO' => 'August',
        'SEPTIEMBRE' => 'September',
        'OCTUBRE' => 'October',
        'NOVIEMBRE' => 'November',
        'DICIEMBRE' => 'December',
    ];

    protected $mesesLay=array("01"=>"ENERO","02"=>"FEBRERO","03"=>"MARZO","04"=>"ABRIL","05"=>"MAYO","06"=>"JUNIO","07"=>"JULIO", "08"=>"AGOSTO","09"=>"SEPTIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");

    public function descargarLayoutConNombres(Request $request) {

        try {
            $premioPuntualidad = P20PremioPuntualidad::find($request->premio);
            $folios = [];
            $subprocesos = $premioPuntualidad->inscripciones;
            foreach ($subprocesos as $key => $subproceso) {
                $folios[] = $subproceso->folio;
            }

            $empleados = P20PremioPuntualidadEmpleados::whereIn('folio', $folios)->get();
            foreach ($empleados as $empleado) {
                $empleado->areaPremio->area;
                $layout_completo = $empleado->numero_empleado . $this->codigo_sun . $empleado->fecha_inicio_evaluacion . $this->dependencia_valor . $this->switch . $this->dato_adicional . $empleado->areaPremio->area->nombre . $this->complemento_unidad;
                $empleado->layout_completo = $layout_completo;
            }

            return Excel::download(new LayoutConNombres($empleados), "Layout_con_nombres.xlsx");

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error al generar el layout "  ], 500);
        }
    }

    public function descargarLayoutSinNombres(Request $request) {
        try {

            $premioPuntualidad = P20PremioPuntualidad::find($request->premio);
            $folios = [];
            $subprocesos = $premioPuntualidad->inscripciones;
            foreach ($subprocesos as $key => $subproceso) {
                $folios[] = $subproceso->folio;
            }

            $empleados = P20PremioPuntualidadEmpleados::whereIn('folio', $folios)->get();
            foreach ($empleados as $empleado) {
                $empleado->areaPremio->area;
                $layout_completo = $empleado->numero_empleado . $this->codigo_sun . $empleado->fecha_inicio_evaluacion . $this->dependencia_valor . $this->switch . $this->dato_adicional . $empleado->areaPremio->area->nombre . $this->complemento_unidad;
                $empleado->layout_completo = $layout_completo;
            }

            return Excel::download(new LayoutSinNombres($empleados), "Layout_sin_nombres.xlsx");
        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error al generar el layout "  ], 500);
        }
    }

    public function descargarRelacionEmpleados(Request $request) {
        try {
            $empleados = P20Nomina::select('p20_nomina.*', 'p.nombre_quincena')
            ->whereIn('p20_nomina.folio', $request->folios)
            ->join('p20_subproceso as s', 'p20_nomina.p20_subproceso_id', '=', 's.p20_subproceso_id')
            ->join('p20_premio as p', 's.p20_premio_id', '=', 'p.p20_premio_id')
            ->get();

            $quienFirma = User::select('users.*')
                            ->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id')
                            ->join('roles as r', 'mhr.role_id', '=', 'r.id')
                            ->where('r.name', 'DRH')
                            ->first();

            return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_relacion_empleados', compact('empleados', 'quienFirma') )
                            // ->setPaper(array(0,0,612,1300.00), 'landscape')
                            ->setPaper('a4', 'landscape')
                            ->download('Relacion_empleados_premio.pdf');
        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error al generar la relación de empleados" ], 500);
        }
    }

    // SUBPROCESOS

    // ST01
    public function capturaInstrucciones(Request $request, P20PremioPuntualidadInscripcion $subproceso, InstanciaTarea $instanciaTarea){

        $user  = Auth::user();
        $instancia  = $subproceso->instancia;
        $subproceso->premioPuntialidad;
        $areaPrincipal = $subproceso->area;

        $areasQueParticipan = Area::where('activo', true)
            ->where('area_id', $areaPrincipal->area_id) // Ajusta el valor 3 según tu necesidad
            ->orWhere('area_principal_id', $areaPrincipal->area_id) // Ajusta el valor 3 según tu necesidad
            ->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['ENLACE_PREMIO_PUNTUALIDAD', 'OPER_PREMIO_PUNTUALIDAD']);
                    });
            })
            ->with(['subAreas' => function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('activo', true)
                        ->whereHas('roles', function ($query) {
                            $query->whereIn('name', ['ENLACE_PREMIO_PUNTUALIDAD', 'OPER_PREMIO_PUNTUALIDAD']);
                        });
                });
            }])
            ->get();

        if ($request->isMethod('post')) {

            try {

                // Pasamos los datos para su guardado
                $subareasParticipantes = json_decode($request->subareas);

                $guardaSubtarea = $this->guardaSubtareaCapturarInstrucciones($request, $user, $subproceso);

                if ($guardaSubtarea['estatus']) {

                    DB::beginTransaction();

                    $instanciaTarea->updateEstatus('COMPLETADO');

                    foreach ($subareasParticipantes as $subArea) {
                        $instancia->crearInstanciaTarea('REGISTRO_DE_EMPLEADOS', 'NUEVO', $subArea);

                        $areaSubproceso = new P20PremioPuntualidadAreas();
                        $areaSubproceso->premio_puntualidad_inscripcion_id = $subproceso->premio_puntualidad_inscripcion_id;
                        $areaSubproceso->area_id = $subArea->area_id;
                        $areaSubproceso->estatus = 'EN_PROCESO';
                        $areaSubproceso->save();
                    }
                    DB::commit();
                    $instancia->crearInstanciaTarea('APROBACION_ENVIO_SOLICITUDES', 'NUEVO');

                    return redirect()->route('tareas')->with("success", "La tarea finalizo correctamente");

                }else {
                    return back()->withInput()->withErrors(['mensaje_error' => $guardaSubtarea['mensaje']]);
                }

            } catch (\Throwable $th) {
                return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error, por favor intente más tarde"]);
            }
        }

        return view('p20_premio_puntualidad_asistencia.tareas.STPPA01_capturaInstrucciones', compact('subproceso', 'instanciaTarea', 'areasQueParticipan'));
    }

    // ST02
    public function evaluacionAdicion(Request $request, P20PremioPuntualidadInscripcion $subproceso, InstanciaTarea $instanciaTarea) {

        $instancia  =  $subproceso->instancia;
        $subproceso->area;
        // Subarea en curso
        $subArea    = $subproceso->areasPremio->where('area_id', $instanciaTarea->pertenece_al_area)->first();
        $empleadosRegistrados = $subArea->empleadosPremio;

        $meses=array("1"=>"ENERO","2"=>"FEBRERO","3"=>"MARZO","4"=>"ABRIL","5"=>"MAYO","6"=>"JUNIO","7"=>"JULIO", "8"=>"AGOSTO","9"=>"SEPTIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");

        // Obtener fecha actual
        $date = Carbon::now();

        // Retroceder seis meses desde la fecha actual
        $endDate = $date->copy()->subMonths(6);

        // Establecer la fecha inicial seis meses antes de la fecha de finalización
        $startDate = $endDate->copy()->subMonths(6);

        $mesesEvaluacion = [];

        // Iterar sobre los meses dentro del rango
        while ($startDate <= $endDate) {
            // Agregar el formato de mes y año al array
            $mesesEvaluacion[] = $meses[(int)$startDate->format('n')] . " " . $startDate->format('Y');
            // Avanzar al siguiente mes
            $startDate->addMonth();
        }

        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            return redirect()->route('tareas')->with("success", "La tarea finalizo correctamente");
        }

        return view('p20_premio_puntualidad_asistencia.tareas.STPPA02_evaluacionAdicion', compact('subproceso', 'instanciaTarea', 'mesesEvaluacion', 'subArea', 'empleadosRegistrados' ));

    }

    public function evaluarEmpleado(Request $request){

        $data_empleado = json_decode($request->datos_empleado);
        try {
            $subprocesoExiste = P20PremioPuntualidadInscripcion::where('premio_puntualidad_inscripcion_id',  $request->premioPuntualidadInscripcionId)->exists();

            if ( $subprocesoExiste ) {

                $subproceso = P20PremioPuntualidadInscripcion::find($request->premioPuntualidadInscripcionId);
                $premioPuntialidad = $subproceso->premioPuntialidad;
                $foliosSubproceso = [];
                foreach ($premioPuntialidad->inscripciones as $key => $inscripcione) {
                    $foliosSubproceso[] = $inscripcione->folio;
                }
                $existeEmpleado = P20PremioPuntualidadEmpleados::whereIn('folio', $foliosSubproceso)->where('numero_empleado', $data_empleado->numero_empleado)->exists();
                $subArea    = P20PremioPuntualidadAreas::find($request->premioPuntualidadAreaId);

                if ( $existeEmpleado ) {
                    $response = ['estatus' => false, 'mensaje' => 'El empleado ya ha sido registrado en el proceso actual.'];
                    return response()->json($response);
                } else {
                    // INICIO

                    // Obtener el Mes Año
                    $mesInicioEvaluacion = $request->mesInicioEvaluacion;
                    $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

                    // Convertir la cadena a un objeto Carbon
                    $parteMesInicioEvaluacion = explode(' ', $mesInicioEvaluacion);
                    $mes = $parteMesInicioEvaluacion[0];
                    $anio = $parteMesInicioEvaluacion[1];

                    // Obtener el número de mes
                    $numeroMes = array_search($mes, $meses);

                    // Crear objeto Carbon con el primer día del mes
                    $fecha = Carbon::create($anio, $numeroMes, 1);

                    $fechasSiguientes = [];
                    // Obtener las fechas de los siguientes 6 meses
                    for ($i = 0; $i < 6; $i++) {
                        // Añadir un mes a la fecha actual
                        $fecha = $fecha->addMonths(1);

                        // Agregar la fecha al arreglo
                        $fechasSiguientes[] = $fecha->format('Y-m-d');
                    }

                    // Arreglo para almacenar los días de inicio y fin de cada mes
                    $mesesDiasInicioFin = [];

                    // Obtener el día de inicio y fin de cada mes
                    foreach ($fechasSiguientes as $fecha) {
                        // Convertir la fecha a objeto Carbon
                        $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fecha);

                        // Obtener el primer día del mes
                        $inicioMes = $fechaCarbon->startOfMonth()->format('d-m-Y');

                        // Obtener el último día del mes
                        $finMes = $fechaCarbon->endOfMonth()->format('d-m-Y');

                        // Obtener el mes y año como una sola cadena
                        $mesAnio = mb_strtoupper($fechaCarbon->translatedFormat('F Y')); // Por ejemplo, "Mayo 2023"

                        // Agregar los días de inicio y fin al arreglo
                        $mesesDiasInicioFin[] = [
                            'inicio' => $inicioMes,
                            'fin' => $finMes,
                            'mes_anio' => $mesAnio
                        ];
                    }

                    // Obtener empleado
                    $empleado = EmpleadoModel::find($data_empleado->empleado_id);

                    // Verificar y ver si existe el empleado en la tabla ya registrado aun que sea en otro premio, esto para validar los meses
                    $existeEmpleadoRegistradoAnteriormente = P20PremioPuntualidadEmpleados::where('numero_empleado', $data_empleado->numero_empleado)->exists();
                    $array_meses_anio = [];
                    if ($existeEmpleadoRegistradoAnteriormente) {
                        $empleadoRegistradoAnteriormente = P20PremioPuntualidadEmpleados::where('numero_empleado', $data_empleado->numero_empleado)->latest()->first();
                        $detalles_evaluacion = json_decode($empleadoRegistradoAnteriormente->json_detalle_evaluacion);
                        foreach ($detalles_evaluacion as $detalle_evaluacion) {
                            $array_meses_anio[] = $detalle_evaluacion->mes_anio;
                        }
                    }

                    // Evaluar Asistencias
                    foreach ($mesesDiasInicioFin as $i => $mesDiasInicioFin) {
                        $mes_anio_evaluado = $mesDiasInicioFin['mes_anio'];
                        if (in_array($mes_anio_evaluado, $array_meses_anio)) {
                            $response = ['estatus' => false, 'mensaje' => 'El empleado tiene registro de participación en el rango de meses: ' . implode(', ', $array_meses_anio) . '.<br> por esta razón no puede participar.'];
                            return response()->json($response);
                        }
                        $administrarAsistenciaEmpleado  = new AdministrarAsistenciaEmpleado($empleado, $mesDiasInicioFin['inicio'], $mesDiasInicioFin['fin']);
                        $evaluaciones                   = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();

                        // Comienza a obtener los valores y validar
                        $falta = 0;
                        $retardoLeve = 0;
                        $retardoGrave = 0;
                        $notaBuenaRetardoLeve = 0;
                        $notaBuenaRetardoGrave = 0;
                        $licSinSueldo = 0;
                        $cuidadoMarterno = 0;
                        $licMedica = 0;
                        $comisionSindical = 0;

                        foreach ($evaluaciones as $j => $evaluacione) {
                            if ($evaluacione["evaluacion_final"] == "FALTA" || $evaluacione["evaluacion_final"] == "SIN_EVALUACION") {
                                $falta ++;
                            } else if ($evaluacione["evaluacion_final"] == "RETARDO_LEVE") {
                                $retardoLeve ++;
                            } else if ($evaluacione["evaluacion_final"] == "RETARDO_GRAVE") {
                                $retardoGrave ++;
                            }
                        }

                        $mesesDiasInicioFin[$i]['falta'] = $falta;
                        $mesesDiasInicioFin[$i]['retardoLeve'] = $retardoLeve;
                        $mesesDiasInicioFin[$i]['retardoGrave'] = $retardoGrave;

                        // $incidencias        = $administrarAsistenciaEmpleado->getIncidenciasPorFechas();
                        $incidencias        = $administrarAsistenciaEmpleado->getIncidenciasPorFechas();
                        foreach ($incidencias as $k => $incidenciaPorFecha) {
                            if ( count($incidenciaPorFecha) > 0 ) {
                                foreach ($incidenciaPorFecha as $l => $incidenciaTipo) {
                                    $identificadorIncidencia =  $incidenciaTipo->tipoIncidencia->tipoJustificacion->identificador;
                                    if ($identificadorIncidencia == "nota_buena_retardo_leve") {
                                        $notaBuenaRetardoLeve ++;
                                    } else if ($identificadorIncidencia == "nota_buena_retardo_grave") {
                                        $notaBuenaRetardoGrave ++;
                                    } else if ($identificadorIncidencia == "licencia_sin_sueldo") {
                                        $licSinSueldo ++;
                                    } else if ($identificadorIncidencia == "cuidado_materno") {
                                        $cuidadoMarterno ++;
                                    } else if ($identificadorIncidencia == "licencia_medica") {
                                        $licMedica ++;
                                    } else if ($identificadorIncidencia == "comision_sindical") {
                                        $comisionSindical ++;
                                    }
                                }
                            }
                        }

                        $mesesDiasInicioFin[$i]['notaBuenaRetardoLeve'] = $notaBuenaRetardoLeve;
                        $mesesDiasInicioFin[$i]['notaBuenaRetardoGrave'] = $notaBuenaRetardoGrave;
                        $mesesDiasInicioFin[$i]['licSinSueldo'] = $licSinSueldo;
                        $mesesDiasInicioFin[$i]['cuidadoMarterno'] = $cuidadoMarterno;
                        $mesesDiasInicioFin[$i]['licMedica'] = $licMedica;
                        $mesesDiasInicioFin[$i]['comisionSindical'] = $comisionSindical;

                    }

                    $evaluacionFinalporMes = 0;
                    $licMedicaTotal = 0;
                    // Ya con los datos hechos hacemos las validaciones por MES y 6 MESES
                    foreach ($mesesDiasInicioFin as $key => $mesesDiasInicioFinEvaluaciones) {

                        if ($mesesDiasInicioFinEvaluaciones['falta'] > 0) {
                            $evaluacionFinalporMes ++;
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['retardoGrave'] > 0) {
                            $evaluacionFinalporMes ++;
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['retardoLeve'] > 3) {
                            $evaluacionFinalporMes ++;
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['notaBuenaRetardoLeve'] > 1 || $mesesDiasInicioFinEvaluaciones['notaBuenaRetardoGrave'] > 1) {
                            $evaluacionFinalporMes ++;
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['licMedica'] > 0) {
                            $licMedicaTotal += $mesesDiasInicioFinEvaluaciones['licMedica'];
                            if ($licMedicaTotal > 8) {
                                $evaluacionFinalporMes ++;
                            }
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['licSinSueldo'] > 0) {
                            $evaluacionFinalporMes ++;
                        }
                        else if ($mesesDiasInicioFinEvaluaciones['comisionSindical'] > 0) {
                            $evaluacionFinalporMes ++;
                        }

                        // Se agrega la evaluacion para cada mes
                        $mesesDiasInicioFin[$key]['evaluacionFinal'] = $evaluacionFinalporMes <= 0 ? 'CALIFICA' : 'NO CALIFICA';
                        $evaluacionFinalporMes = 0;
                    }

                    $response = ['estatus' => true,
                                'mensaje' => 'Evaluación Empleado',
                                'data' => $mesesDiasInicioFin];
                    return response()->json($response);
                }
            } else {
                $response = ['estatus' => false, 'mensaje' => 'No existe el Subproceso'];
                return response()->json($response);
            }
        } catch (\Throwable $e) {
            $response = ['estatus' => false, 'mensaje' => "Ocurrio un error, por favor intente más tarde"];
            return response()->json($response);
        }
    }

    public function agregarEmpleado(Request $request){

        $user = Auth::user();
        $emple = json_decode($request->datos_empleado);

        try {
            $subprocesoExiste = P20PremioPuntualidadInscripcion::where('premio_puntualidad_inscripcion_id',  $request->premioPuntualidadInscripcionId)->exists();

            if ( $subprocesoExiste ) {

                $subproceso = P20PremioPuntualidadInscripcion::find($request->premioPuntualidadInscripcionId);
                $premioPuntialidad = $subproceso->premioPuntialidad;
                $foliosSubproceso = [];
                foreach ($premioPuntialidad->inscripciones as $key => $inscripcione) {
                    $foliosSubproceso[] = $inscripcione->folio;
                }
                $existeEmpleado = P20PremioPuntualidadEmpleados::whereIn('folio', $foliosSubproceso)->where('numero_empleado', $emple->numero_empleado)->exists();
                $subArea    = P20PremioPuntualidadAreas::find($request->premioPuntualidadAreaId);

                if ( $existeEmpleado ) {
                    $response = ['estatus' => false, 'mensaje' => 'El empleado ya ha sido registrado en el proceso actual.'];
                    return response()->json($response);
                } else {

                    DB::beginTransaction();
                        $empleadoPremio = new P20PremioPuntualidadEmpleados();
                        $empleadoPremio->premio_puntualidad_area_id = $subArea->premio_puntualidad_area_id;
                        $empleadoPremio->premio_puntualidad_inscripcion_id = $subproceso->premio_puntualidad_inscripcion_id;
                        $empleadoPremio->folio = $subproceso->folio;
                        $empleadoPremio->numero_empleado = $emple->numero_empleado;
                        $empleadoPremio->nombre_empleado = $emple->nombre;
                        $empleadoPremio->apellido_paterno = $emple->apellido_paterno;
                        $empleadoPremio->apellido_materno = $emple->apellido_materno;
                        $empleadoPremio->rfc = $emple->rfc;
                        $empleadoPremio->nivel_salarial = $emple->nivel_salarial;
                        $empleadoPremio->seccion_sindical = $emple->seccion_sindical;
                        $empleadoPremio->area_empleado = $emple->unidad_administrativa_nombre;
                        $empleadoPremio->area_identificador_empleado = $emple->unidad_administrativa;
                        $empleadoPremio->fecha_inicio_evaluacion = $request->mesInicioEvaluacion;
                        $empleadoPremio->fecha_fin_evaluacion = $request->mesInicioEvaluacion;
                        $empleadoPremio->creado_por = $user->nombre .' '. $user->apellido_paterno .' '. $user->apellido_materno ;
                        $empleadoPremio->creado_por_area = $user->area->area_id;
                        $empleadoPremio->creado_por_titulo = $user->nombre_usuario;
                        $empleadoPremio->json_detalle_evaluacion = $request->evaluacionEmpleado;
                        $empleadoPremio->save();
                    DB::commit();

                    $empleadosPremio = $subArea->empleadosPremio;
                    $response = ['estatus' => true,
                                'mensaje' => 'Empleado agregado correctamente',
                                'data' => $empleadosPremio];
                    return response()->json($response);
                }
            } else {
                $response = ['estatus' => false, 'mensaje' => 'No existe el Subproceso'];
                return response()->json($response);
            }
        } catch (\Throwable $e) {
            DB::rollback();
            $response = ['estatus' => false, 'mensaje' => "Ocurrio un error, por favor intente más tarde"];
            return response()->json($response);
        }
    }

    public function borrarEmpleados(Request $request){
        try {
            DB::beginTransaction();
            P20PremioPuntualidadEmpleados::destroy($request->id);
            $subArea    = P20PremioPuntualidadAreas::find($request->premioPuntualidadAreaId);
            $empleadosPremio = $subArea->empleadosPremio;
            DB::commit();
            $response = ['estatus' => true, 'mensaje' => '¡Empleado Eliminado Correctamente!', 'data' => $empleadosPremio];
        } catch (\Throwable $e) {
            DB::rollback();
            $response = ['estatus' => false, 'mensaje' => 'Hubo un error al borrar la información, intente más tarde'];
        }
        return response()->json($response);
    }

    public function descargarReporteEmpleado($empleado_id){
        $empleado = P20PremioPuntualidadEmpleados::find($empleado_id);
        return $pdf = \PDF::loadView('p20_premio_puntualidad_asistencia.formatos.pdf_comprobante_solicitud_premio', compact( 'empleado') )
                            ->download($empleado->apellido_paterno.' '.$empleado->nombre_empleado.'.pdf');
    }

    public function validarEmpleado(Request $request){
        try {
            $empleado = json_decode($request->datos_empleado);
            return response()->json([ "estatus" => true, "empleado" => $empleado ]);
        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => "Ocurrio un error, por favor intente más tarde" ]);
        }
    }

    // ST03
    public function autorizacionSolicitudes(Request $request, P20PremioPuntualidadInscripcion $subproceso, InstanciaTarea $instanciaTarea){

        if ($request->isMethod('post')) {
            try {
                $subtareas = json_decode($request->avance_subareas);
                foreach ($subtareas as $key => $subtarea) {
                    if ($subtarea->estatus != 'COMPLETADO') {
                        InstanciaTarea::query()->where('instancia_tarea_id', $subtarea->instancia_tarea_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR LA SUBTAREA 2']);
                        P20PremioPuntualidadAreas::where('premio_puntualidad_area_id', $subtarea->subProcesoArea->premio_puntualidad_area_id)->update(['estatus' => "CANCELADO", 'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR LA SUBTAREA 2']);
                        P20PremioPuntualidadEmpleados::where('premio_puntualidad_area_id', $subtarea->subProcesoArea->premio_puntualidad_area_id)->delete();
                    } else {
                        P20PremioPuntualidadAreas::where('premio_puntualidad_area_id', $subtarea->subProcesoArea->premio_puntualidad_area_id)->update(['estatus' => "COMPLETADO", 'motivo_rechazo' => '']);
                    }
                }

                DB::beginTransaction();
                    $instancia = $subproceso->instancia;
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $subproceso->estatus = "COMPLETADO";
                    $subproceso->save();
                DB::commit();
                return redirect()->route('tareas')->with("success", "El subproceso finalizó correctamente");

            } catch (\Throwable $th) {
                DB::rollback();
                return back()->withInput()->withErrors(['mensaje_error' => "Ocurrio un error, por favor intente más tarde"]);
            }
        }

        // Obtenemos la instancia de la Inscripción (Subproceso)
        $instancia = $subproceso->instancia;
        // Luego las tareas ST02
        $instanciasTarea = $instancia->instanciasTareas->where('tarea.identificador', 'REGISTRO_DE_EMPLEADOS')->whereIn('estatus', ['NUEVO', 'COMPLETADO', 'EN_CORRECCION'])->values();

        // Se recorren para generar el objeto con la información
        foreach ($instanciasTarea as $key => $instanciaT) {

            // Saber a que área pertenencen
            $instanciaT->perteneceAlArea;
            // A través de la su instancia saber el modelo
            $instanciaT->instancia;
            // Y recuperar la área que esta relacionada a esta instancia
            $subProcesoInscripcion =  $instanciaT->instancia->model;
            $subProcesoArea = $subProcesoInscripcion->areasPremio->where('area_id', $instanciaT->pertenece_al_area)->first();

            $instanciaT->subProcesoInscripcion = $subProcesoInscripcion;
            $instanciaT->subProcesoArea = $subProcesoArea;
        }
        $subAreas = $instanciasTarea;

        return view('p20_premio_puntualidad_asistencia.tareas.STPPA03_autorizacionSolicitudes', compact('subproceso', 'instanciaTarea', 'subAreas'));
    }

    public function descargaReporteSubAreaPPA($premio_puntualidad_area_id){

        $empleados = P20PremioPuntualidadEmpleados::where('premio_puntualidad_area_id', $premio_puntualidad_area_id)->get();
        foreach ($empleados as $empleado) {
            $empleado->areaPremio->area;
        }
        return Excel::download(new EmpleadosAgregadosSubareas($empleados), 'Premio-puntualidad-asistencia.xlsx');
    }

    public function rechazarTareaSubarea(Request $request, P20PremioPuntualidadInscripcion $subproceso, InstanciaTarea $instanciaTarea){

        try {
            $subArea = P20PremioPuntualidadAreas::where('premio_puntualidad_area_id', $request->premio_puntualidad_area_id)->first();
            DB::beginTransaction();
                // se atualiza el estatus de la instancia tarea seleccionada por "RECHAZADO" y se guarda el motivo para tener registro de todos los rechazos
                InstanciaTarea::query()->where('instancia_tarea_id', $request->instancia_tarea_id)
                                ->update(['motivo_rechazo' => $request->motivo_rechazo, 'estatus' => 'RECHAZADO']);
                // se actualiza el registro de la subarea ´para tomar este dato y mostrarlo, así se rechace 10 veces, aquí se actualiza y se toma siempre el ultimo
                $subArea::query()->where('premio_puntualidad_area_id', $request->premio_puntualidad_area_id)
                            ->update(['motivo_rechazo' => $request->motivo_rechazo]);
                // Ya que se hizo ese update, ahora si se crea la nueva tarea con el estatus de EN CORRECCION
                $subproceso->instancia->crearInstanciaTarea('REGISTRO_DE_EMPLEADOS', 'EN_CORRECCION', $subArea);
            DB::commit();

            return back()->with("success", "Tarea rechazada correctamente. Se volvió a crear una nueva tarea para esa subarea");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->withErrors(['mensaje_error' => "Ocurrio un error, por favor intente más tarde"]);
        }
    }

    // NOTIFICACIÓN
    public function notificacionListadoSolicitantes(Request $request, P20PremioPuntualidad $premioPuntualidad, InstanciaTarea $instanciaTarea){

        $instancia =  $premioPuntualidad->instancia;

        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }

        $inscripcion    = $premioPuntualidad->inscripciones->where('area.area_id', $instanciaTarea->pertenece_al_area)->first();
        $empleadosRegistrados = $inscripcion->empleadosPremio;

        if ($request->isMethod('post')) {

            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');

            return redirect()->route('notificaciones')->with('mensaje', "Se ha eliminado la notificación");
        }

        return view('p20_premio_puntualidad_asistencia.notificaciones.TNOTAPPA01_listadoSolicitantes', compact('premioPuntualidad', 'instanciaTarea', 'empleadosRegistrados', 'inscripcion' ));
    }

}
