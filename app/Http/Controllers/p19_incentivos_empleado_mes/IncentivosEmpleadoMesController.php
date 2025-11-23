<?php

namespace App\Http\Controllers\p19_incentivos_empleado_mes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\p19_incentivos_empleado_mes\ManejadorTareas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\p19_incentivos_empleado_mes\P19Incentivo;
use App\Models\p19_incentivos_empleado_mes\P19Subproceso;
use App\Models\p19_incentivos_empleado_mes\P19Nomina;
use App\Models\Area;
use App\Models\User;
use App\Models\InstanciaTarea;
use App\Exports\p19_incentivos_empleado_mes\IncentivosEmpleadoMesExport;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Models\Empleado;
use Maatwebsite\Excel\Facades\Excel;
require_once('../app/helper.php');

class IncentivosEmpleadoMesController extends Controller
{

    use ManejadorTareas;
    public $mes = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

    /**
     * Método que muestra la descripcion del P08
     */
    public function descripcion()   {
        return view('p19_incentivos_empleado_mes.tareas.descripcion');
    }

    /**
     * Método que inicializa el proceso 19, crea su tarea y su folio en la tabla de instancia
     */
    public function iniciarProceso() {
        // Crear registro incentivo
        $incentivoEmpleadoMes = $this->crearIncentivoEmpleadoMes();
        // Crea instancia
        $instancia = $this->crearInstancia('incentivo_empleado_mes', $incentivoEmpleadoMes, Auth::user()->area);
        // Crea la T01
        $instanciaTarea = $instancia->crearInstanciaTarea('SELECCIONAR_QUINCENA_PAGO', 'NUEVO');
        // Redirigir a T01 del Proceso
        $mensaje = 'Se ha iniciado correctamente el proceso Incentivo Empleado del mes';
        return redirect()
                ->route('incentivos.empleado.mes.seleccion.quincena.pago', ['incentivoEmpleadoMes' => $incentivoEmpleadoMes, 'instanciaTarea' => $instanciaTarea])
                ->with("success", $mensaje);
    }

    /**
     * Método que muestra y guarda T01 - SELECCIONAR_QUINCENA_PAGO del proceso 19
     */
    public function seleccionarQuincenaPago(Request $request, P19Incentivo $incentivoEmpleadoMes, InstanciaTarea $instanciaTarea) {

        $instancia      =  $incentivoEmpleadoMes->instancia;
        // Usuario logueado
        $usuario = Auth::user();

        // Obtener la fecha actual
        $fecha_actual = Carbon::now();
        // Formatear la fecha en año/mes/día
        $fecha_formateada = $fecha_actual->format('Y/m/d');
        $mesesAnioObjeto = $this->generarMesAnio( 'periodo_mes_anio_evaluacion', 3, false, $fecha_formateada);

        if ( $request->isMethod('post') ) {

            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $instanciaTarea->motivo_rechazo = 'CANCELACIÓN PREMATURA (TAREA 1 - SELECCIÓN DE QUINCENA DE PAGO)';
                $instanciaTarea->save();
                $incentivoEmpleadoMes->estatus = 'CANCELADO';
                $incentivoEmpleadoMes->save();

                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            }

            $existeQuincenaCapturada = P19Incentivo::where('nombre_quincena', $request->fecha_data)->whereIn('estatus', ['EN_PROCESO', 'COMPLETADO', 'SUBPROCESO_INICIO', 'SUBPROCESO_FINALIZO'])->exists();
            if ( $existeQuincenaCapturada)  {
                $mensaje = '¡La quincena seleccionada esta en proceso o fue completada, por favor selecciona otra!';
                return redirect()
                        ->back()
                        ->with("error", $mensaje);
            }

            // Datos de la Mes a Evaluar
            $fechaEvaluacion = json_decode($request['fecha_evaluacion']);
            $existeMesAnioCapturada = P19Incentivo::where('nombre_mes_anio_evaluacion', $fechaEvaluacion->nombre_mes_anio)->whereIn('estatus', ['EN_PROCESO', 'COMPLETADO', 'SUBPROCESO_INICIO', 'SUBPROCESO_FINALIZO'])->exists();
            if ( $existeMesAnioCapturada)  {
                $mensaje = '¡El mes seleccionado esta en proceso o fue completado, por favor selecciona otro!';
                return redirect()
                        ->back()
                        ->with("error", $mensaje);
            }

            // Pasamos los datos para su guardado
            $incentivoEmpleadoMesSeGuardo = $this->guardarTareaT01($incentivoEmpleadoMes, $request);
            if ( $incentivoEmpleadoMesSeGuardo ) {
                // Finaliza la tarea T01
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T02 - Asignar los premios por unidad administrativa
                $instanciaTarea = $instancia->crearInstanciaTarea('ASIGNAR_PREMIOS_POR_AREA', 'NUEVO');
                 // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('incentivos.empleado.mes.asignacion.premios.por.unidad', ['incentivoEmpleadoMes' => $incentivoEmpleadoMes, 'instanciaTarea' => $instanciaTarea])->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.T01_seleccionarQuincenaPago', [ 'incentivoEmpleadoMes' => $incentivoEmpleadoMes, 'mesesAnioObjeto' => $mesesAnioObjeto, 'usuario' => $usuario, 'instanciaTarea' => $instanciaTarea ]);
    }

    /**
     * Método que muestra y guarda T02 del proceso 19
     */
    public function asignarPremiosPorUnidad(Request $request, P19Incentivo $incentivoEmpleadoMes, InstanciaTarea $instanciaTarea) {

        $instancia  = $incentivoEmpleadoMes->instancia;

        $usuario    = Auth::user();

        $areasUnidades = Area::where('activo', true)
        ->whereHas('users', function ($query) {
            $query->where('activo', true)
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['SUB_EA']);
                });
        })
        ->get();

        if ( $request->isMethod('post') ) {

            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $instanciaTarea->motivo_rechazo = 'CANCELACIÓN PREMATURA (TAREA 2 - ASIGNACIÓN DE PREMIOS POR UNIDAD ADMINISTRATIVA)';
                $instanciaTarea->save();
                $incentivoEmpleadoMes->estatus = 'CANCELADO';
                $incentivoEmpleadoMes->save();

                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            }

            // Pasamos los datos para su guardado
            $incentivoEmpleadoMesSeGuardo = $this->guardarTareaT02($incentivoEmpleadoMes, $request);
            if ( $incentivoEmpleadoMesSeGuardo ) {
                // Finaliza la tarea T02
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T03 - Revisión de solicitudes de premio
                $instancia->crearInstanciaTarea('REVISAR_SOLICITUDES_PREMIO', 'NUEVO');
                 // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.T02_asignarPremiosPorUnidad',
            compact ('incentivoEmpleadoMes',
                    'usuario',
                    'areasUnidades',
                    'instanciaTarea') );
    }

    /**
     * Método que muestra y guarda T03 del proceso 19
     */
    public function revisionSolicitudesPremio(Request $request, P19Incentivo $incentivoEmpleadoMes, InstanciaTarea $instanciaTarea) {

        $instancia      = $incentivoEmpleadoMes->instancia;
        $usuario = Auth::user();

        $subprocesos = $incentivoEmpleadoMes->subprocesos;

        foreach ($subprocesos as $key => $subproceso) {
            $subproceso->area;
            $subprocesos[$key]['premios_aplicados'] = count($subproceso->nominas);
        }

        if ( $request->isMethod('post') ) {

            // Pasamos los datos para su guardado
            $incentivoEmpleadoMesSeGuardo = $this->guardarTareaT03($incentivoEmpleadoMes, $request);

            if ( $incentivoEmpleadoMesSeGuardo ) {
                // Finaliza la tarea T03
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T04 - Generación de archivos de pago
                $instanciaTarea = $instancia->crearInstanciaTarea('GENERAR_ARCHIVOS_PAGO', 'NUEVO');
                 // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('incentivos.empleado.mes.generar.archivos.pago', ['incentivoEmpleadoMes' => $incentivoEmpleadoMes, 'instanciaTarea' => $instanciaTarea])->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.T03_revisionSolicitudesPremio',
                compact('incentivoEmpleadoMes',
                        'usuario',
                        'subprocesos',
                        'instanciaTarea'));
    }

    /**
     * Método que muestra y guarda T04 del proceso 19
     */
    public function generacionArchivosPago(Request $request, P19Incentivo $incentivoEmpleadoMes, InstanciaTarea $instanciaTarea) {

        $instancia      = $incentivoEmpleadoMes->instancia;
        // Usuario logueado
        $usuario = Auth::user();

        // Obtenemos los subprocesos de este Incentivo
        $subprocesos        = $incentivoEmpleadoMes->subprocesos;
        $subprocesosFinales = [];
        foreach ($subprocesos as $key => $subproceso) {
            // Validamos si cuenta con Nominas Agregadas. Para esta tarea ya debia estar validado que debe tener al menos una data de alta
            if ( count($subproceso->nominas) > 0 ) {
                // Si cuenta con al menos 1 nomina, obtenemos su información adicional y lo agregamos a un arreglo nuevo
                $subproceso->area;
                $subprocesos[$key]['premios_aplicados'] = count($subproceso->nominas);
                $subprocesosFinales[] = $subproceso;
            }
        }
        // Despues obtenemos las nominas de este Incentivo
        // $nominas = $incentivoEmpleadoMes->nominas()->orderBy('area_id', 'asc')->get();

        if ( $request->isMethod('post') ) {

            // Cancelar proceso
            if ($request->accion == "cancelar") {
                // Actualizamos los estatus de las tabla involucradas, Primero la tabla principal de p19_incentivos
                $incentivoFinalizadoPrematura = $incentivoEmpleadoMes->update([
                    'estatus' => 'CANCELADO'
                ]);
                if ( $incentivoFinalizadoPrematura ) {
                    // Despues se debe Eliminar las Nominas Asociadas, ya que no serán tomadas en cuenta para el Incentivo
                    P19Nomina::where('p19_incentivo_id', $incentivoEmpleadoMes->p19_incentivo_id)->delete();
                    $instanciaTarea->updateEstatus('CANCELADO');
                    $instanciaTarea->motivo_rechazo = 'CANCELACIÓN ANTES DE FINALIZAR (TAREA 4 - GENERACIÓN DE ARCHIVOS DE PAGO)';
                    $instanciaTarea->save();
                    $instancia->update(['estatus' => 'CANCELADO']);
                    return redirect()->route("tareas")
                            ->with("success", "El proceso se canceló correctamente.");
                } else {
                    // Si surge un error los manda a las tareas nuevamente.
                    $mensaje = 'Error, No se Cancelo la tarea, intentalo más tarde';
                    return redirect()->route('tareas')->with('error', $mensaje);
                }
            }

            // Pasamos los datos para su guardado
            $incentivoEmpleadoMesSeGuardo = $this->guardarTareaT04($incentivoEmpleadoMes, $request);

            if ( $incentivoEmpleadoMesSeGuardo ) {
                // Finaliza la tarea T04
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Se recorren las Sub Áreas Finales y se les Notifica a su área correspondiente
                foreach ($subprocesosFinales as $key => $subproceso) {
                    $instancia->crearInstanciaTarea('NOTIFICACION_LISTADO_SOLICITANTES_PREMIO_INCENTIVO_SUB_EA', 'NOTIFICACION_NO_LEIDO', $subproceso->area);
                }
                // Finaliza la Instancia y acaba proceso
                $instancia->update(['estatus' => 'COMPLETADO']);
                // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.T04_generacionArchivosPago', [ 'incentivoEmpleadoMes' => $incentivoEmpleadoMes, 'usuario' => $usuario, 'subprocesosFinales' => $subprocesosFinales, 'instanciaTarea' => $instanciaTarea ]);
    }

    /**
     * Método que muestra y guarda ST01 del proceso 19
     */
    public function subprocesoDistribucionPremiosSubareas(Request $request, P19Subproceso $subproceso, InstanciaTarea $instanciaTarea) {

        $instancia = $subproceso->instancia;
        $usuario   = Auth::user();

        // Obtenemos el las Subareas del Subproceso para validar la consulta
        $subAreas = Area::where('activo', true)
            ->where('area_id', $subproceso->area->area_id) // Ajusta el valor 3 según tu necesidad
            ->orWhere('area_principal_id', $subproceso->area->area_id) // Ajusta el valor 3 según tu necesidad
            ->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['SUB_EA', 'OPER_INC_19']);
                    });
            })
            ->with(['subAreas' => function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('activo', true)
                        ->whereHas('roles', function ($query) {
                            $query->whereIn('name', ['SUB_EA', 'OPER_INC_19']);
                        });
                });
            }])
            ->get();

        if ( $request->isMethod('post') ) {

            // Pasamos los datos para su guardado
            $subproceso = $this->guardarTareaST01($subproceso, $request);
            // Datos de la tabla de las Sub áreas
            $dataSubAreas = json_decode($request['arreglo_sub_areas']);

            if ( $subproceso ) {
                // Finaliza la tarea ST01
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Se recorren las Áreas de la tabla Si tienen CANTIDAD de PREMIOS asignada
                // Y se les Crea la tarea ST02 - Asignación de premios por empleado para las Sub Áreas
                foreach ($dataSubAreas as $key => $area) {
                    if ( $request['premios_asignados_'.$area->area_id] > 0 ) {
                        $instancia->crearInstanciaTarea('ASIGNAR_PREMIOS_POR_EMPLEADO', 'NUEVO', $area, null, null, $instanciaTarea);
                    }
                }
                // ST03 - Autorización de solicitudes, Se crea la ST03 ya que si no llenan las Áreas de 3er Nivel esta puede continuar
                $instancia->crearInstanciaTarea('AUTORIZAR_SOLICITUDES', 'NUEVO');
                 // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.ST01_subprocesoDistribucionPremiosSubareas', [ 'subproceso' => $subproceso, 'usuario' => $usuario, 'subAreas' => $subAreas, 'instanciaTarea' => $instanciaTarea ]);
    }

    /**
     * Método que muestra y guarda ST02 del proceso 19
     */
    public function subprocesoAsigancionPremiosEmpleado(Request $request, P19Subproceso $subproceso, InstanciaTarea $instanciaTarea) {

        $instancia  =  $subproceso->instancia;
        // Usuario logueado
        $usuario    = Auth::user();
        // Con la Instancia Tarea obtenemos los datos del Área a la que fue asiganda, ya que esta tarea ST02 puede ser creada para varias Áreas de 3er Nivel
        // $subArea    = Area::find($instanciaTarea->asignado_al_area); PENDIENTE POR REVISAR AHORA YA CAMBIO y HACE QUE ELÑ FLUJO NO SE AJUSTE
        $subArea    = Area::find($instanciaTarea->pertenece_al_area);

        // Obtenemos los empleados dados de alta para este Subproceso y filtramos por la Sub Área que esta generandolos
        $empleadosNomina = $subproceso->nominas()->where('sub_area_id', '=', $subArea->area_id)->get();

        // Finalmente obtenemos los premios asignados a esta sub área
        $premiosSubAreaAutorizados = 0;
        foreach ($subproceso->estructura_concurrente->hijo as $key => $premiosSubArea) {
            if ( $premiosSubArea->identificador == $subArea->identificador ) {
                $premiosSubAreaAutorizados = $premiosSubArea->premios_sub_ea;
            }
        }

        if ( $request->isMethod('post') ) {

                // Finaliza la tarea ST02, se valida ya que pueden existir varias tareas ST02 ya que se crean dependiendo a cuantas sub áreas se asignen premios
                if ( $instanciaTarea ) {
                    $instanciaTarea->updateEstatus('COMPLETADO');
                }
                 // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);

        }

        return view('p19_incentivos_empleado_mes.tareas.ST02_subprocesoAsignacionPremiosEnmpleado',
            compact('subproceso',
            'usuario',
            'subArea',
            'empleadosNomina',
            'premiosSubAreaAutorizados',
            'instanciaTarea'));
    }

    // Método Evaluar al Empleado es parte de ST02
    public function subprocesoAsigancionPremiosEmpleadoEvaluacion(Request $request) {

        try {

            // EN ESTA SECCIÓN SE DEBERA REALIZAR LA VALUACIÓN PARA VER SI NO TIENE PROBLEMAS DE ASISTENCIAS
            // POR EL MOMENTO SOLO REGRESO AL MISMO USUARIO QUE SE ENVÍO
            $respuesta = [
                "estatus" => true,
                "mensaje" => '¡Evaluación realizada correctamente!',
                "data" => $request->all(),
            ];
            return response()->json($respuesta);

        } catch (\Throwable $th) {

            $respuesta = [
                'estatus' => false,
                'mensaje' => '¡Ocurrió un error, Intente más tarde!',
                'data' => $th
            ];
            return response()->json($respuesta);

        }
    }

    // Método para Agregar al Empleado a la Nomina es parte de ST02
    public function subprocesoAsigancionPremiosEmpleadoAgregarEmpleado(Request $request) {

        // Validamos primero si existe el subproceso
        $existeSubProceso = P19Subproceso::where('p19_subproceso_id', $request->subproceso['p19_subproceso_id'])->exists();

        if ( $existeSubProceso ) {

            $subproceso = P19Subproceso::find($request->subproceso['p19_subproceso_id']);
            $subproceso->area;
            $data_empleado           = json_decode($request->data_empleado);
            $comentarios_admin_incen = $request->comentarios_admin_incen;
            $instancia_tarea         = $request->instancia_tarea;

            // 2da Validación - Validamos si alguien de la misma Área ya a agregado al empleado a este Incentivo
            $existeEmpleadoNomina = P19Nomina::where('folio', $subproceso->folio_padre)->where('numero_empleado', $data_empleado->numero_empleado)->exists();

            if (!$existeEmpleadoNomina) {

                // 3ra Validación - El periodo de tiempo entre solicitudes del premio "Incentivo empleado del mes" deberá ser mayor o igual a 3 meses
                // Obtenemos la fecha de inicio de esta Evaluación
                $fechaInicioPago = Carbon::parse($subproceso->fecha_inicio_pago);
                // Despúes, a partir de esta fecha se obtienen los 3 meses anteriores y con la función se obtienen las quincenas
                $quincenasAnteriores = traerQuincenasActual( $fechaInicioPago->subMonths(3), Carbon::parse($subproceso->fecha_inicio_pago) );
                // Con esas quincenas se obtienen los subprocesos para validar si ya fue agregado el empleado en los meses anteriores al Premio Validado
                $subprocesosPrevios = P19Subproceso::whereIn('nombre_quincena', $quincenasAnteriores)->get();
                // Ahora se recorren los subprocesos para ver si este empleado ya esta agregado
                foreach ($subprocesosPrevios as $key => $subprocesoPrevio) {
                    if ( count($subprocesoPrevio->nominas) > 0 ) {
                        foreach ($subprocesoPrevio->nominas as $key => $nominaEmpleado) {
                            if ( $nominaEmpleado->numero_empleado == $data_empleado->numero_empleado) {
                                $respuesta = [
                                    'estatus' => false,
                                    'mensaje' => '¡El empleado ya fue agregado en la quincena: ' . $subprocesoPrevio->nombre_quincena . '. <br>Para ser admitido no debe haber sido agregado en un premio mayor o igual a 3 meses atrás!',
                                ];
                                return response()->json($respuesta);
                            }
                        }
                    }
                }

                /* $empleado = Empleado::where("numero_empleado", "889806")->first(); TEST */
                /* $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, "01-01-2024", "31-01-2024"); TEST */

                // 4ta Validación - Validar si tiene algún tipo de retardo
                $empleado = Empleado::find($data_empleado->empleado_id);
                // Se pasan la fecha de inicio y fin del mes a evaluar
                $administrarAsistenciaEmpleado = new AdministrarAsistenciaEmpleado($empleado, $subproceso->fecha_inicio_evaluacion, $subproceso->fecha_fin_evaluacion);
                $evaluaciones = $administrarAsistenciaEmpleado->getEvaluacionesPorFechas();
                foreach ($evaluaciones as $key => $evaluacione) {
                    if ($evaluacione["evaluacion_final"] == "FALTA" || $evaluacione["evaluacion_final"] == "RETARDO_LEVE" || $evaluacione["evaluacion_final"] == "RETARDO_GRAVE") {
                        $respuesta = [
                            'estatus' => false,
                            'mensaje' => '¡El empleado no puede ser agregado ya que cuenta con algún retardo leve, grave o falta en el més evaluado!',
                        ];
                        return response()->json($respuesta);
                    }
                }

                // 5ta Validación - Validar las Justificaciones que tenga aplicadas y no se permitan para aplicar al premio
                $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, $subproceso->fecha_inicio_evaluacion, $subproceso->fecha_fin_evaluacion);
                $incidenciasPorFechas = $administrarAsistencia->getIncidenciasPorFechas();
                foreach ($incidenciasPorFechas as $key => $incidenciaPorFecha) {
                    if ( count($incidenciaPorFecha) > 0 ) {
                        foreach ($incidenciaPorFecha as $i => $incidenciaTipo) {
                            $identificadorIncidencia =  $incidenciaTipo->tipoIncidencia->tipoJustificacion->identificador;
                            if ( $identificadorIncidencia != "reloj_descompuesto" || $identificadorIncidencia != "lista_asistencia" ) {
                                $respuesta = [
                                    'estatus' => false,
                                    'mensaje' => '¡El empleado no puede ser agregado ya que cuenta con algúna incidencia ó justificación aplicada en el mes evaluado!',
                                ];
                                return response()->json($respuesta);
                            }
                        }
                    }
                }

                $EmpleadoNomina = $this->guardarTareaST02EmpleadoNomina($subproceso, $data_empleado, $comentarios_admin_incen, $instancia_tarea);

                if ( $EmpleadoNomina['estatus'] ) {

                    $respuesta = [
                        "estatus" => true,
                        "mensaje" => '¡Empleado agreagado exitosamente!',
                        "EmpleadoNomina" => $EmpleadoNomina['empleado'],
                    ];
                    return response()->json($respuesta);


                } else {

                    $respuesta = [
                        'estatus' => false,
                        'mensaje' => '¡Ocurrió un error, Intente más tarde!',
                    ];
                    return response()->json($respuesta);

                }

            } else {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡El empleado que intentas agregar, ya fue agregado para este incentivo, por ti o alguna otra área!',
                ];
                return response()->json($respuesta);
            }

        } else {
            $respuesta = [
                'estatus' => false,
                'mensaje' => '¡Ocurrió un error, Intente más tarde!',
            ];
            return response()->json($respuesta);
        }
    }

    // Método para Eliminar al Empleado a la Nomina es parte de ST02
    public function subprocesoAsigancionPremiosEmpleadoEliminarEmpleado(Request $request) {

        try {
            // Despues se debe Eliminar las Nominas Asociadas, ya que no serán tomadas en cuenta para el Incentivo
            P19Nomina::where('p19_nomina_id', $request->p19_nomina_id)->delete();

            return response()->json([
                "estatus" => true,
                "mensaje" => '¡El empleado fue eliminado con éxito!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "estatus" => false,
                "mensaje" => '¡Surgió un error al intentar finalizar el proceso, por favor intentelo más tarde!'
            ]);
        }

    }

    // Método para Generar Reporte Empleado, es parte de ST02
    public function subprocesoAsigancionPremiosEmpleadoGenerarReporteEmpleado(P19Nomina $empleadoNomina)  { //TEST
        $empleadoNomina->subproceso;
        $empleadoNomina->areaEmpleado;

        $subprocesoAreaId = $empleadoNomina->subproceso->area->area_id;

        $enlace = User::where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['SUB_EA']);
                    })
                    ->whereHas('area', function ($query) use ($subprocesoAreaId) {
                        $query->where('activo', true)->where('area_id', $subprocesoAreaId);
                    })
                    ->first();

        // Uso el método general para crear la fecha
        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        $pdf =  \PDF::loadView('p19_incentivos_empleado_mes.formatos.reporte_empleado_nomina_pdf',
                    compact('empleadoNomina', 'fechaCompleta', 'enlace'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('concentrado_incentivo.pdf');
    }

    /**
     * Método que muestra y guarda ST03 del proceso 19
     */
    public function subprocesoAutorizacionSolicitudes(Request $request, P19Subproceso $subproceso, InstanciaTarea $instanciaTarea) {

        $instancia   =  $subproceso->instancia;
        // Usuario logueado
        $usuario     = Auth::user();

        // Obtenemos todas las tareas del subproceso a traves de la Instancia
        $instanciasTareasSubproceso = $instancia->instanciasTareas;

        $subAreas = [];
        foreach ($instanciasTareasSubproceso as $key => $instanciaTareaSubproceso) {
            // Recorremos y Validamos cuales de todas las tareas son de tipo TS02
            if ( $instanciaTareaSubproceso->tarea->identificador == 'ASIGNAR_PREMIOS_POR_EMPLEADO' ) {
                // Ya que identificamos cuales son, obtenemos los datos del (Sub) Área que tienen asignada esta tarea
                $subAreaAsiganda = $instanciaTareaSubproceso->perteneceAlArea;
                $subAreas[] = [
                    'area_id' => $subAreaAsiganda->area_id,
                    'identificador' => $subAreaAsiganda->identificador,
                    'nombre' => $subAreaAsiganda->nombre,
                    'estatus' => $instanciaTareaSubproceso->estatus == 'NUEVO' ? 'PENDIENTE' : 'COMPLETADO',
                ];
            }
        }

        if ( $request->isMethod('post') ) {

            // Pasamos los datos para su guardado
            $subproceso = $this->guardarTareaST03($subproceso, $request);

            if ( $subproceso ) {
                // Finaliza la tarea ST03
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Actualiza el estatus de la instancia
                $instancia->update(['estatus' => 'COMPLETADO']);
                // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p19_incentivos_empleado_mes.tareas.ST03_subprocesoAutorizacionSolicitudes', [ 'subproceso' => $subproceso, 'usuario' => $usuario, 'subAreas' => $subAreas, 'instanciaTarea' => $instanciaTarea ]);
    }

    // Método encargado de generar las quincenas
    public function generarQuincenasObjecto($name='',$qnas_atras=24,$qna_actual=true,$atras=true,$sel="none") {

		$hoy    = time();
        $k      = ($qna_actual) ? 0 : 1;

        if ( date("d", $hoy) > 15 )	$temp = mktime(0,0,0,date("m",$hoy), 28, date("Y",$hoy));
        else $temp = mktime(0,0,0,date("m",$hoy), 14, date("Y",$hoy));

        $tiempo=($atras) ? '-' : '+';

	    for( $i=$k; $i < $qnas_atras + $k; $i++ )
        {
            $temp   = strtotime("$tiempo 14 days", $temp);
            $fi     = (date('d', $temp) <= 15) ? 1 : 16;
            $ff     = (date("d", $temp) <= 15) ? 15 : date('d',strtotime("+1month -1day",mktime(0,0,0,date('m',$temp),1,date('Y',$temp))));
            $mes    = date("n", $temp);
            $anio   = date("Y", $temp);
            $no_qna = ($fi==1) ? 1 : 0;
            $no_qna = (2*$mes) - $no_qna;

            $fechas = array('fecha_inicio' => date('d/m/Y',mktime(0,0,0,$mes,$fi,$anio)),
                            'fecha_fin' => date('d/m/Y',mktime(0,0,0,$mes,$ff,$anio)),
                            'nombre_quincena' => "QUINCENA $no_qna, $fi al $ff de ".$this->mes[$mes]." de ". date('Y',$temp));

            $resultado[json_encode($fechas)] = $fechas['nombre_quincena'];

            if ( date("d",$temp) > 15 )	$temp = mktime(0,0,0,date("m",$temp),28,date("Y",$temp));
            else $temp = mktime(0,0,0,date("m",$temp), 14, date("Y",$temp));

        }

	 return $resultado;
	}

    // Método encargado de generar los meses
    public function generarMesAnio($name='', $meses_atras=12, $mes_actual=true, $fecha_inicio=false, $sel="none") {
		$resultado = array();
 		if( !$fecha_inicio ) $hoy = time();
		else {
			$hoy = explode("/",$fecha_inicio);
			$hoy = mktime(0,0,0,$hoy[1],$hoy[2],$hoy[0]);
		}

		if( date("d",$hoy) > 28 )
        	$hoy=strtotime("-4 day",$hoy);
        $k = ($mes_actual) ? 0 : 1;
		for( $i=$k; $i < $meses_atras + $k; $i++ )
         	{
         		$mes = date("n",strtotime("-$i"."month",$hoy));
         		$año = date("Y",strtotime("-$i"."month",$hoy));
         		$fechas = mktime(0,0,0,$mes,1,$año);
      			$fechas = array('fecha_inicio'=>date('d/m/Y',$fechas),
      							'fecha_fin' => date('d/m/Y',strtotime('+1month -1day',$fechas)),
      							'nombre_mes_anio' => $this->mes[$mes]." ".$año);
      			$resultado[json_encode($fechas)] = $fechas['nombre_mes_anio'];
         	}

	    return $resultado;
	}

    /**
     * Notificación: TNOTA01 del P19
     * Método donde se muestra la notificación del listado de Solicitantes del Premio de Incentivo
     * Esta Notificacion se envía al SUB_EA
     */
    public function notificacionListadoSolicitantesPremioIncentivoSubea(Request $request, P19Incentivo $incentivoEmpleadoMes, InstanciaTarea $instanciaTarea) {
        // Usuario logueado
        $usuario    = Auth::user();
        $subArea    = Area::find($instanciaTarea->pertenece_al_area);

        $instancia  = $incentivoEmpleadoMes->instancia;

        $subProcesoNomina = $incentivoEmpleadoMes->subprocesos->where('area_id', $subArea->area_id)->first();
        $subProcesoNomina->nominas;
        foreach ($subProcesoNomina->nominas as $key => $nomina) {
            $nomina->subareaEmpleado;
        }


        // Actualizar estatus a LEIDO  de TNOTA01
        if ( $instanciaTarea ) {
            if (!Auth::user()->hasRole("SUPER_ADMIN")) {
                $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
            }
        }
        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO de TNOTA01
            if ( $instanciaTarea ) {
                $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            }
            $mensaje = 'Notificación eliminada correctamente.';
            return redirect()->route('notificaciones')->with('success', $mensaje);
        }
        return view('p19_incentivos_empleado_mes.notificaciones.TNOTA01_notificacionListadoSolicitantesPremioIncentivoSubea', compact('incentivoEmpleadoMes', 'subProcesoNomina', 'instanciaTarea'));
    }

    // Función encargada de Generar el EXCEL del Concentrado Incentivo Empleados Mes
    public function generarExcelFormatoGeneracionConcentradoIncentivoEmpleadosMes( P19Incentivo $incentivoEmpleadoMes ) {

        $incentivoEmpleadoMes->nominas;

        return Excel::download(new IncentivosEmpleadoMesExport( $incentivoEmpleadoMes, $incentivoEmpleadoMes->p19_incentivo_id ), 'concentrado_incentivos.xlsx');
    }

    // Función encargada de Generar el PDF del Concentrado Incentivo Empleados Mes
    public function generarPDFFormatoGeneracionConcentradoIncentivoEmpleadosMes( P19Incentivo $incentivoEmpleadoMes ) {

        // Uso el método general para crear la fecha
        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        // Empleados aplicables al Incentivo
        $nominaEmpleados = $incentivoEmpleadoMes->nominas()->orderBy('area_id', 'asc')->get();

        foreach ($nominaEmpleados as $key => $nominaEmpleado) {
            $nominaEmpleado->areaCreadora;
        }

        $pdf =  \PDF::loadView('p19_incentivos_empleado_mes.formatos.concentrado_listado_incentivos_empleado_mes_pdf',
                    compact('incentivoEmpleadoMes', 'nominaEmpleados', 'fechaCompleta'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('concentrado_incentivo.pdf');
    }

}
