<?php

namespace App\Http\Controllers\p12_tramites_incidencias;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;
use App\Http\Utils\procesos\asistencias\AdministrarAsistenciaEmpleado;
use App\Http\Utils\procesos\notas_buenas\AdministrarNotasBuenasEmpleado;
use App\Models\Empleado;
use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoEmpleadoCardex;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoIncidenciaEmpleado;
use App\Models\historico\lbpm_dga\p12_tramites_incidencias\HistoricoTramiteIncidencia;
use App\Models\InstanciaTarea;
use App\Models\LogLocal;
use App\Models\p12_tramites_incidencias\IncidenciaEmpleado;
use App\Models\p12_tramites_incidencias\TramiteIncidencia;
use App\Models\p12_tramites_incidencias\TipoCaptura;
use App\Models\p12_tramites_incidencias\TipoIncidencia;
use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioEmpleado;
use App\Models\UnidadAdministrativa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TramiteIncidenciaController extends Controller
{
    use RegistroInstancias;
    use ManejadorTareas;

    var $intervalosJustificacion = [
        "1000" => "ENTRADA",
        "0001" => "SALIDA",
        "1001" => "TODO EL DIA",
        "1010" => "RETARDO GRAVE", // Sindicalizado
        "1100" => "RETARDO LEVE" // Sindicalizado
    ];

    // TAREAS

    public function descripcion() {
        $tiposTramites = [];
        if (Auth::user()->hasRole(["SUPER_ADMIN", "INI_JUST"])) {
            $tiposTramites[] = "INCIDENCIA_INDIVIDUAL";
        }
        if (Auth::user()->hasRole(["SUPER_ADMIN", "CAPT_KDX"])) {
            $tiposTramites[] = "INCIDENCIA_INDIVIDUAL_ADMIN";
            $tiposTramites[] = "INCIDENCIA_GRUPAL";
        } 
        if (Auth::user()->hasRole(["SUPER_ADMIN", "EMPLEADO_GRAL"])) {
            $tiposTramites[] = "AUTOINCIDENCIA";
        }
        return view("p12_tramites_incidencias.tareas.descripcion", compact("tiposTramites"));
    }
    
    public function inicializarProceso(Request $request) {
        $tipoTramite = $request->tipo_tramite;
        $tramiteIncidencia = TramiteIncidencia::create([
            "tipo_tramite" => $tipoTramite,
            "area_id" => Auth::user()->area->area_id,
            "estatus" => "EN_PROCESO",  
            "creado_por" => Auth::user()->id,
        ]);
        $instancia = $this->crearInstancia("tramites_incidencias", $tramiteIncidencia, Auth::user()->area);
        if (in_array($tramiteIncidencia->tipo_tramite, ["AUTOINCIDENCIA", "INCIDENCIA_INDIVIDUAL", "INCIDENCIA_INDIVIDUAL_ADMIN"])) {
            $instanciaTarea = $instancia->crearInstanciaTarea("T01_SELECCIONAR_TIPO_CAPTURA", "NUEVO", null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
            $ruta = route("tramite.incidencia.seleccionar.tipo.captura", [$tramiteIncidencia, $instanciaTarea]);
        } else if ($tramiteIncidencia->tipo_tramite == "INCIDENCIA_GRUPAL") {
            $instanciaTarea = $instancia->crearInstanciaTarea("T01_GRUPAL_TIPO_CAPTURA", "NUEVO");
            $ruta = route("tramite.incidencia.grupal.tipo.captura", [$tramiteIncidencia, $instanciaTarea]);
        }
        return redirect($ruta)->with("success", "Ha iniciado correctamente el proceso");
    }

    /*
     * T01 SELECCIONAR TIPO CAPTURA
     */
    public function seleccionarTipoCaptura(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            }
            $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first(); 
            if (!$usuarioEnlace) {
                return redirect()->back()
                    ->with("error", "No hay un usuario enlace para esta área.")
                    ->withInput();
            }
            $resp = $this->guardarTareaT01($tramiteIncidencia, $request);
            if ($resp["estatus"]) {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02_ALTA_INCIDENCIA", "NUEVO", null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                    $ruta = route("tramite.incidencia.alta.incidencia", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02_APLICACION_NOTAS_BUENAS", "NUEVO", null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                    $ruta = route("tramite.incidencia.aplicacion.notas.buenas", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02_CANCELACION_INCIDENCIA", "NUEVO", null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                    $ruta = route("tramite.incidencia.cancelacion.incidencia", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } 
                $instanciaTarea->updateEstatus("COMPLETADO");
                return redirect($ruta)->with("success", "La tarea finalizó correctamente.");
            } else {
                return redirect()->back()->with("error", $resp["mensaje"])->withInput();
            }
        }
        $tiposCaptura = TipoCaptura::activo()->get();
        return view("p12_tramites_incidencias.tareas.T01_seleccionarTipoCaptura", compact(
            "instanciaTarea", 
            "tramiteIncidencia", 
            "tiposCaptura"
        ));
    }
    
    /*
     * T02 ALTA de incidencia 
     */
    public function altaIncidencia(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route('tareas')
                    ->with('success', "El proceso se canceló correctamente.");
            } 
            try {
                $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first(); 
                if (!$usuarioEnlace) {
                    return redirect()->back()
                        ->with("error", "No hay un usuario enlace para esta área.")
                        ->withInput();
                }
                if ($this->guardarTareaT02aAltaIncidencia($tramiteIncidencia, $request)) {
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    if (in_array($tramiteIncidencia->tipo_tramite, ["AUTOINCIDENCIA", "INCIDENCIA_INDIVIDUAL"])) {
                        $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T03_FORMATO_SOLICITUD', 'NUEVO', null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                        $ruta = route("tramite.incidencia.formato.solicitud", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                    } else if ($tramiteIncidencia->tipo_tramite == "INCIDENCIA_INDIVIDUAL_ADMIN") {
                        $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T05', 'NUEVO');
                        $ruta = route("tareas");
                    }
                    return redirect($ruta)->with('success', "La tarea finalizó correctamente.");
                } 
            } catch (Exception $e) {
                $tipoExcepcion = get_class($e);
                LogLocal::create([
                    "tipo" => "ERROR", 
                    "modulo" => "TramiteIncidenciaController::altaIncidencia",
                    "mensaje" => $e->getMessage(), 
                ]);
                switch ($tipoExcepcion) {
                    case "Exception":
                        $mensaje = $e->getMessage();
                        break;
                    default:
                        $mensaje = "Error interno en el sistema. Contacte al administrador.";
                        break;
                }
                return redirect()->back()
                    ->with(["error" => $mensaje])
                    ->withInput(); 
            }
        }
        $tiposIncidencias = TipoIncidencia::activo()
            ->where(function($query) use ($tramiteIncidencia) {
                if ($tramiteIncidencia->es_sindicalizado) {
                    $query->whereIn('tipo_empleado', ['SINDICALIZADO', 'TODOS']);
                } else {
                    $query->whereIn('tipo_empleado', ['NO_SINDICALIZADO', 'TODOS']);
                } 
                if ($tramiteIncidencia->sexo == "M") {
                    $query->whereIn('sexo', ['M', 'TODOS']);
                } else {
                    $query->whereIn('sexo', ['F', 'TODOS']);
                }
                if ($tramiteIncidencia->tipo_tramite == "AUTOINCIDENCIA") {
                    $query->where("aplica_autoincidencia", true);
                }
            })
            ->whereDoesntHave("tipoJustificacion", function($query) {
                $query->whereIn("identificador", ["nota_buena_inasistencia", "nota_buena_retardo_leve", "nota_buena_retardo_grave"]);
            })
            ->with("tipoJustificacion")
            ->orderBy("tipo_justificacion_id")
            ->orderBy("articulo")
            ->get();
        
        $horarios = Horario::activo()->where([
            "tipo_empleado" => $tramiteIncidencia->tipo_empleado,
            "es_horario_base" => false,
            "tipo_asignacion" => "SISTEMA",
        ])
        ->orderBy("entrada")
        ->get();

        return view("p12_tramites_incidencias.tareas.T02_altaIncidencia", compact(
            "instanciaTarea", 
            "tramiteIncidencia", 
            "tiposIncidencias",
            "horarios"
        ));
    }

    /*
     * T02 APLICACIÓN DE NOTAS BUENAS
     */
    public function aplicacionNotasBuenas(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route('tareas')
                    ->with('success', "El proceso se canceló correctamente.");
            }
            $usuarioEnlace = User::activo()->where("area_id", $tramiteIncidencia->area->area_id)->role("SUB_EA")->first(); 
            if (!$usuarioEnlace) {
                return redirect()->back()
                    ->with("error", "No hay un usuario enlace para esta área.")
                    ->withInput();
            }
            if ($this->guardarTareaT02aplicacionNotasBuenas($tramiteIncidencia, $request)) {
                $instanciaTarea->updateEstatus('COMPLETADO');
                if (in_array($tramiteIncidencia->tipo_tramite, ["AUTOINCIDENCIA", "INCIDENCIA_INDIVIDUAL"])) {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T03_FORMATO_SOLICITUD', 'NUEVO', null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                    $ruta = route("tramite.incidencia.formato.solicitud", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } else if ($tramiteIncidencia->tipo_tramite == "INCIDENCIA_INDIVIDUAL_ADMIN") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T05', 'NUEVO');
                    $ruta = route("tareas");
                }
                return redirect($ruta)->with('success', "La tarea finalizó correctamente.");
            } 
        }
        
        $tiposJustificaciones = [
            "RETARDO_LEVE" => "RETARDO LEVE", 
            "RETARDO_GRAVE" => "RETARDO GRAVE",
            "INASISTENCIA" => "INASISTENCIA"
        ];

        return view("p12_tramites_incidencias.tareas.T02_aplicacionNotasBuenas", compact(
            "instanciaTarea", 
            "tramiteIncidencia", 
            "tiposJustificaciones"
        ));
    }

    /*
     * T02 CANCELACIÓN DE INCIDENCIAS
     */
    public function cancelacionIncidencia(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route('tareas')
                    ->with('success', "El proceso se canceló correctamente.");
            } 
            if ($this->guardarTareaT02CancelacionIncidencia($tramiteIncidencia, $request)) {
                $instanciaTarea->updateEstatus('COMPLETADO');
                if (in_array($tramiteIncidencia->tipo_tramite, ["AUTOINCIDENCIA", "INCIDENCIA_INDIVIDUAL"])) {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T03_FORMATO_SOLICITUD', 'NUEVO', null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                    $ruta = route("tramite.incidencia.formato.solicitud", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } else if ($tramiteIncidencia->tipo_tramite == "INCIDENCIA_INDIVIDUAL_ADMIN") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T05', 'NUEVO');
                    $ruta = route("tareas");
                }
                return redirect($ruta)->with('success', "La tarea finalizó correctamente.");
            } 
        }

        $tramitesIncidenciasHistorico = HistoricoTramiteIncidencia::whereHas('incidenciasEmpleado', function ($query) use ($tramiteIncidencia) {
            $query->where([
                "status" => "ACTIVO",
                ["tipo_justificacion", "!=", "Cambio de horario"],
            ])
            ->whereHas("cardex", function ($query) use ($tramiteIncidencia) {
                $query->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%$tramiteIncidencia->rfc%")
                    ->where("numero_empleado", $tramiteIncidencia->numero_empleado);
            });
        })
        ->where("aprobado_on", '>=', Carbon::now()->subMonths(6))
        ->with([
            "incidenciasEmpleado" => function ($query) use ($tramiteIncidencia) {
                $query->whereHas("cardex", function ($query) use ($tramiteIncidencia) {
                    $query->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%$tramiteIncidencia->rfc%")
                        ->where("numero_empleado", $tramiteIncidencia->numero_empleado);
                })->orderBy("created_on", "DESC");
            },
            "incidenciasEmpleado.tramiteIncidencia", 
            "incidenciasEmpleado.tipoIncidencia", 
            "incidenciasEmpleado.horario", 
        ])
        ->orderBy("created_on", "DESC")
        ->get();
        $tramitesIncidenciasHistorico = collect([]);

        $tramitesIncidencias = TramiteIncidencia::whereHas('incidenciasEmpleado', function ($query) use ($tramiteIncidencia) {
            $query->where([
                "rfc" => $tramiteIncidencia->rfc,
                "numero_empleado" => $tramiteIncidencia->numero_empleado,
                "estatus" => "AUTORIZADO"
            ])->whereDoesntHave("tramitesIncidenciasCancelacion", function ($subQuery) {
                $subQuery->whereIn("estatus", ["EN_PROCESO", "COMPLETADO"]);
            });
        })
        ->where("aprobado_at", '>=', Carbon::now()->subMonths(6))
        ->with([
            "incidenciasEmpleado" => function ($query) use ($tramiteIncidencia) {
                $query->where([
                    "rfc" => $tramiteIncidencia->rfc,
                    "numero_empleado" => $tramiteIncidencia->numero_empleado,
                ])->orderBy("created_at", "DESC");
            },
            "incidenciasEmpleado.tramiteIncidencia.tipoCaptura", 
            "incidenciasEmpleado.tipoIncidencia.tipoJustificacion", 
            "incidenciasEmpleado.notasBuenas", 
            "incidenciasEmpleado.horario", 
            "tipoCaptura"])
        ->orderBy("created_at", "DESC")
        ->get();

        $tramitesIncidencias = $tramitesIncidenciasHistorico->concat($tramitesIncidencias);

        return view("p12_tramites_incidencias.tareas.T02_cancelacionIncidencia", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "tramitesIncidencias"
        ));
    }

    /*
     * T03 FORMATO SOLICITUD
     */
    public function formatoSolicitud(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {                
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "TRAMITE_SIN_COMPLETAR"]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "TRAMITE_SIN_COMPLETAR"]);
                    $tramiteIncidencia->tramiteNotaBuena->updateEstatus("CANCELADO");
                } 
                return redirect()->route('tareas')
                    ->with('success', "El proceso se canceló correctamente.");
            } 
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea('T04', 'NUEVO');
            return redirect()->route("tareas")->with('success', "La tarea finalizó correctamente.");
        }
        if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                    ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                    ->get();
            } else {
                $incidenciasEmpleado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico)->incidencias_empleado;
                $incidenciasEmpleado = collect($incidenciasEmpleado);
            }
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                ->get();
        }
        return view("p12_tramites_incidencias.tareas.T03_formatoSolicitud", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }

    /*
     * T04 APROBAR SOLICITUD
     */
    public function aprobarSolicitud(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod("post")) {
            if ($request->estatus == "RECHAZADO") {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "RECHAZADO_ENLACE"]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "RECHAZADO_ENLACE"]);
                    $tramiteIncidencia->tramiteNotaBuena->updateEstatus("RECHAZADO");
                }
                $instanciaTarea->update([
                    "autorizado_por_usuario" => Auth::user()->id,
                    "autorizado_por_area" => Auth::user()->area->area_id,
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]);
                $tramiteIncidencia->update([
                    "rechazado_por" => Auth::user()->id, 
                    "rechazado_at" => Carbon::now(),
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]); 
                $instancia->crearInstanciaTarea("N01_RESPUESTA_SOLICITUD", "NOTIFICACION_NO_LEIDO", null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
                return redirect()->route("tareas")->with("success", "Se envió la respuesta al empleado.");
            } else {
                $tramiteIncidencia->update(["aprobado_por" => Auth::user()->id, "aprobado_at" => Carbon::now()]);
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea("T05", "NUEVO");                   
                return redirect()->route("tareas")->with("success", "La tarea finalizó correctamente.");
            }
        }
        if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                    ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                    ->get();
            } else {
                $incidenciasEmpleado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico)->incidencias_empleado;
                $incidenciasEmpleado = collect($incidenciasEmpleado);
            }
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario", "notasBuenas")
                ->get();
        }
        return view("p12_tramites_incidencias.tareas.T04_aprobarSolicitud", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }

    /*
     * T05 AUTORIZAR SOLICITUD
     */
    public function autorizarSolicitud(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            if ($request->estatus == "RECHAZADO") {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "RECHAZADO_ADMIN"]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "RECHAZADO_ADMIN"]);
                    $tramiteIncidencia->tramiteNotaBuena->updateEstatus("RECHAZADO");
                } 
                $instanciaTarea->update([
                    "autorizado_por_usuario" => Auth::user()->id,
                    "autorizado_por_area" => Auth::user()->area->area_id,
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]);
                $tramiteIncidencia->update([
                    "rechazado_por" => Auth::user()->id, 
                    "rechazado_at" => Carbon::now(),
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]); 
            } else {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update([
                        "folio_autorizacion" => $tramiteIncidencia->folio,
                        "estatus" => "AUTORIZADO"
                    ]);
                    $incidenciaEmpleado = $tramiteIncidencia->incidenciasEmpleado()->first();
                    if ($incidenciaEmpleado->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario") {
                        $horarioEmpleado = HorarioEmpleado::create([
                            "horario_id" => $incidenciaEmpleado->horario_id,
                            "rfc" => $incidenciaEmpleado->rfc,
                            "numero_empleado" => $incidenciaEmpleado->numero_empleado,
                            "fecha_inicio" => $incidenciaEmpleado->fecha_inicio,
                            "fecha_final" => $incidenciaEmpleado->fecha_final
                        ]);
                        $incidenciaEmpleado->horario_empleado_id = $horarioEmpleado->horario_empleado_id;
                        $incidenciaEmpleado->save();
                    }
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
                    $tramiteIncidencia->incidenciasEmpleado()->update([
                        "folio_autorizacion" => $tramiteIncidencia->folio,
                        "estatus" => "AUTORIZADO"
                    ]);
                    $tramiteIncidencia->tramiteNotaBuena->updateEstatus("COMPLETADO");
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                        $tramiteIncidencia->incidenciasEmpleadoCancelacion()->update([
                            "folio_cancelacion" => $tramiteIncidencia->folio, 
                            "numero_documento_cancelacion" => $tramiteIncidencia->numero_documento, 
                            "motivo_cancelacion" => $tramiteIncidencia->motivo_cancelacion, 
                            "firmas_cancelacion" => $tramiteIncidencia->firmas, 
                            "estatus" => "CANCELADO"
                        ]);
                        $incidenciaEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first();
                        if ($incidenciaEmpleado->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario") {
                            $incidenciaEmpleado->horarioEmpleado()->delete();
                        }
                    } else { 
                        // Crear una instancia histórica
                        $historicoInstancia = HistoricoInstancia::create([
                            'id_proc' => "p12",
                            'created_on' => now(),
                            'last_modified' => now(),
                            'created_by' => Auth::user()->nombre_usuario,
                            'created_by_ou' => Auth::user()->area->identificador,
                            'created_by_mail' => Auth::user()->email,
                            'created_by_cn' => Auth::user()->nombre_completo,
                            'created_by_title' => Auth::user()->puesto,
                            'created_by_uas_ou' => Auth::user()->area->nombre,
                            'closed_by' => '',
                            'closed_by_task' => '',
                            'status' => 'END',
                        ]);
                        // Crear un tramite de incidencia histórica
                        $historicoTramiteIncidencia = HistoricoTramiteIncidencia::create([
                            'id_proc' => "p12",
                            'id_instance' => $historicoInstancia->id_instance,
                            'folio' => $tramiteIncidencia->folio,
                            'work_status' => "COMPLETED",
                            'tipo_captura' => "CANCELACION",
                            'modalidad_captura' => "INDIVIDUAL",
                            'grupo_numeros_empleado' => null,
                            'grupo_ous' => null,
                            'numero_empleado' => $tramiteIncidencia->numero_empleado,
                            'apellido_paterno' => $tramiteIncidencia->apellido_paterno,
                            'apellido_materno' => $tramiteIncidencia->apellido_materno,
                            'nombre_empleado' => $tramiteIncidencia->nombre,
                            'fecha_alta_empleado' => $tramiteIncidencia->fecha_alta_empleado,
                            'rfc' => substr($tramiteIncidencia->rfc, 0, 10),
                            'homoclave' => substr($tramiteIncidencia->rfc, 10, 13),
                            'sexo_empleado' => $tramiteIncidencia->sexo,
                            'id_unidad_administrativa' => $tramiteIncidencia->unidad_administrativa,
                            'unidad_administrativa' => $tramiteIncidencia->unidad_administrativa_nombre,
                            'id_business_category' => $tramiteIncidencia->unidad_administrativa,
                            'business_category' => $tramiteIncidencia->unidad_administrativa_nombre,
                            'id_sindicato' => $tramiteIncidencia->seccion_sindical,
                            'sit_emp' => $tramiteIncidencia->codigo_situacion_empleado,
                            'id_puesto' => $tramiteIncidencia->codigo_puesto,
                            'id_zona_pagadora' => $tramiteIncidencia->zona_pagadora,
                            'id_turno' => $tramiteIncidencia->turno,
                            'id_empleado_cardex' => HistoricoEmpleadoCardex::where("numero_empleado", $tramiteIncidencia->numero_empleado)
                                ->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%{$tramiteIncidencia->rfc}%")
                                ->first()->id_empleado_cardex,
                            'id_justificacion' => null,
                            'ley' => null,
                            'tipo_justificacion' => null,
                            'articulo' => null,
                            'sub_articulo' => null,
                            'descripcion' => null,
                            'dias' => null,
                            'anio' => null,
                            'cada_cuantos_dias' => null,
                            'fecha_inicio' => null,
                            'fecha_fin' => null,
                            'gasta' => null,
                            'tipo_empleado' => $tramiteIncidencia->tipo_empleado == "SINDICALIZADO" ? "sindicalizado" : "no sindicalizado",
                            'status' => null,
                            'tipo_dias' => null,
                            'antiguedad' => null,
                            'sexo' => null,
                            'fecha_prescribe' => null,
                            'unica_vez' => null,
                            'fecha_inicio_justificacion' => null,
                            'fecha_fin_justificacion' => null,
                            'id_horario_justificacion' => null,
                            't_start_justificacion' => null,
                            't_end_justificacion' => null,
                            'texto_horario_justificacion' => null,
                            'dias_justificacion' => null,
                            'observaciones_justificacion' => null,
                            'id_cardex_detalle_cancelar' => null,
                            'folio_a_cancelar' => $tramiteIncidencia->tramite_incidencia_asociado_historico_folio,
                            'numero_documento' => $tramiteIncidencia->numero_documento, 
                            'created_on' => $tramiteIncidencia->created_at,
                            'created_by' => $tramiteIncidencia->creadoPor->nombre_usuario,
                            'created_by_ou' => $tramiteIncidencia->creadoPor->area->identificador,
                            'created_by_bc' => $tramiteIncidencia->creadoPor->area->unidadAdministrativa->identificador,
                            'created_by_cn' => $tramiteIncidencia->creadoPor->nombre_completo,
                            'created_by_title' => $tramiteIncidencia->creadoPor->puesto,
                            'created_by_area' => $tramiteIncidencia->creadoPor->area->nombre,
                            'aprobado_on' => $tramiteIncidencia->aprobado_at,
                            'aprobado_por' => $tramiteIncidencia->aprobadoPor->nombre_usuario,
                            'aprobado_por_ou' => $tramiteIncidencia->aprobadoPor->area->identificador,
                            'aprobado_por_cn' => $tramiteIncidencia->aprobadoPor->nombre_completo,
                            'aprobado_por_title' => $tramiteIncidencia->aprobadoPor->puesto,
                            'aprobado_por_area' => $tramiteIncidencia->aprobadoPor->area->nombre,
                            'revisado_on' => now(),
                            'revisado_por' => Auth::user()->nombre_usuario,
                            'revisado_por_ou' => Auth::user()->area->identificador,
                            'revisado_por_cn' => Auth::user()->nombre_completo,
                            'revisado_por_title' => Auth::user()->puesto,
                            'revisado_por_area' =>  Auth::user()->area->nombre,
                            'firmas' => $tramiteIncidencia->firmas,
                            'comentarios_rechazo' => null,
                            'last_modified' => now(),
                            'status_solicitud' => 'APROBADO',
                            'intervalo_evaluacion' => null,
                            'debio' => null,
                            'razon_debio' => null,
                            'json_nota_buena' => null
                        ]);
                        // Cancelar las incidencias históricas
                        $tramiteIncidenciaAsociado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico);
                        $incidenciasEmpleadoCancelar = collect($tramiteIncidenciaAsociado->incidenciasEmpleado);

                        foreach ($incidenciasEmpleadoCancelar as $incidenciaEmpleado) {
                            HistoricoIncidenciaEmpleado::where("id_cardex_detalle", $incidenciaEmpleado->id_cardex_detalle)->update([
                                "status" => "CANCELADO",
                                "folio_de_cancelacion" => $historicoTramiteIncidencia->folio,
                            ]);
                        }
                    }
                }
                $instanciaTarea->updateEstatus("COMPLETADO");
                $tramiteIncidencia->update([
                    "autorizado_por" => Auth::user()->id, 
                    "autorizado_at" => Carbon::now(),
                    "estatus" => "COMPLETADO"
                ]); 
            }
            $instancia->crearInstanciaTarea('N01_RESPUESTA_SOLICITUD', 'NOTIFICACION_NO_LEIDO', null, $tramiteIncidencia->roleIniciadorTramite, $tramiteIncidencia->userIniciadorTramite);
            return redirect()->route('tareas')->with("success", "Se envió la respuesta al empleado.");
        }
        if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                    ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                    ->get();
            } else {
                $incidenciasEmpleado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico)->incidencias_empleado;
                $incidenciasEmpleado = collect($incidenciasEmpleado);
            }
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario", "notasBuenas")
                ->get();
        }
        return view("p12_tramites_incidencias.tareas.T05_autorizarSolicitud", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }

    /*
     * N01 - RESPUESTA
     */
    public function respuestaSolicitud(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            return redirect()->route('notificaciones')->with("success", "La notificación se eliminó correctamente.");
        }
        if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                    ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                    ->get();
            } else {
                $incidenciasEmpleado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico)->incidencias_empleado;
                $incidenciasEmpleado = collect($incidenciasEmpleado);
            }
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario", "notasBuenas")
                ->get();
        }
        return view("p12_tramites_incidencias.notificaciones.N01_respuestaSolicitud", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }
    
    // INCIDENCIAS GRUPALES
    /*
     * T01 - INCIDENCIA GRUPAL - SELECCIONAR TIPO CAPTURA
     */
    public function incidenciaGrupalTipoCaptura(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            } 
            if ($this->guardarTareaT01IncidenciaGrupalTipoCaptura($tramiteIncidencia, $request)) {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02_GRUPAL_ALTA", "NUEVO");
                    $ruta = route("tramite.incidencia.grupal.alta", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("T02_GRUPAL_CANCELACION_INCIDENCIA", "NUEVO");
                    $ruta = route("tramite.incidencia.grupal.cancelacion.incidencia", [$tramiteIncidencia, $nuevaInstanciaTarea]);
                } 
                $instanciaTarea->updateEstatus("COMPLETADO");
                return redirect($ruta)->with("success", "La tarea finalizó correctamente.");
            } 
        }
        $tiposCaptura = TipoCaptura::activo()->whereIn("identificador", ["alta", "cancelacion"])->get();
        return view("p12_tramites_incidencias.tareas.incidencia_grupal.T01_seleccionarTipoCaptura", compact(
            "instanciaTarea", 
            "tramiteIncidencia", 
            "tiposCaptura"
        ));
    }

    public function incidenciaGrupalAlta(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            } 
            if ($this->guardarTareaT02GrupoIncidenciaAlta($tramiteIncidencia, $request)) {
                $tramiteIncidencia->update(["aprobado_por" => Auth::user()->id, "aprobado_at" => Carbon::now()]);
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea('T04_GRUPAL_AUTORIZAR', 'NUEVO');
                return redirect()->route('tareas')->with("success", "La solicitud se envió correctamente.");
            } 
        }
        $seccionesSindicales = Empleado::select(DB::raw('DISTINCT(CAST(seccion_sindical AS INT))'))
            ->where('seccion_sindical', '<>', 0)
            ->orderBy('seccion_sindical', 'ASC')
            ->get();
        $unidadesAdministrativas = UnidadAdministrativa::activo()
            ->whereHas("dependencia", function ($query) {
                $query->where("identificador", "secretaria_finanzas");
            })
            ->orderByRaw('identificador::integer')
            ->get();  
        $tiposIncidencias = TipoIncidencia::activo()
            ->where("tipo_dias", "NATURALES")
            ->whereDoesntHave("tipoJustificacion", function($query) {
                $query->whereIn("identificador", [
                    "baja",
                    "defuncion",
                    "licencia_medica",
                    "licencia_con_sueldo",
                    "licencia_sin_sueldo",
                    "nota_buena_inasistencia", 
                    "nota_buena_retardo_leve", 
                    "nota_buena_retardo_grave",
                ]);
            })
            ->with("tipoJustificacion")
            ->orderBy("tipo_justificacion_id")
            ->orderBy("articulo")
            ->get();
        $horarios = Horario::activo()->where([
            "es_horario_base" => false,
            "tipo_asignacion" => "SISTEMA",
        ])
        ->orderBy("entrada")
        ->get();
        return view("p12_tramites_incidencias.tareas.incidencia_grupal.T02_altaIncidencia", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "tiposIncidencias",
            "seccionesSindicales",
            "unidadesAdministrativas",
            "horarios"
        ));
    }
    
    public function incidenciaGrupalCancelacionIncidencia(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            } 

            if ($this->guardarTareaT02GrupoIncidenciaCancelacionIncidencia($tramiteIncidencia, $request)) {
                $instanciaTarea->updateEstatus("COMPLETADO");
                if ($tramiteIncidencia->tipo_cancelacion == "TOTAL") {
                    $incidenciasEmpleado = $tramiteIncidencia->tramiteAsociado
                        ->incidenciasEmpleado()
                        ->where([
                            "estatus" => "AUTORIZADO"
                        ])
                        ->get()
                        ->pluck("incidencia_empleado_id");
                    $tramiteIncidencia->incidenciasEmpleadoCancelacion()->attach($incidenciasEmpleado);
                    $tramiteIncidencia->update(["aprobado_por" => Auth::user()->id, "aprobado_at" => Carbon::now()]);
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T04_GRUPAL_AUTORIZAR', 'NUEVO');
                    return redirect()->route("tareas");
                } 
                $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('T03_GRUPAL_CANCELACION_EMPLEADOS', 'NUEVO');
                return redirect()->route('tramite.incidencia.grupal.cancelacion.empleados',  [$tramiteIncidencia, $nuevaInstanciaTarea])
                    ->with("success", "La tarea se completó correctamente.");
            } 
        }
        $tramitesIncidencias = TramiteIncidencia::where("tipo_tramite", "INCIDENCIA_GRUPAL")
            ->whereHas("incidenciasEmpleado", function ($query) {
                $query->where([
                    "estatus" => "AUTORIZADO"
                ])->whereDoesntHave("tramitesIncidenciasCancelacion", function ($subQuery) {
                    $subQuery->whereIn("estatus", ["EN_PROCESO", "COMPLETADO"]);
                });
            })
            ->with("tipoCaptura")
            ->orderBy("created_at", "DESC")
            ->get();

        return view("p12_tramites_incidencias.tareas.incidencia_grupal.T02_cancelacionIncidencia", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "tramitesIncidencias"
        ));
    }
   
    public function incidenciaGrupalCancelacionEmpleados(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $instanciaTarea->updateEstatus("CANCELADO");
                $tramiteIncidencia->updateEstatus("CANCELADO");
                return redirect()->route("tareas")
                    ->with("success", "El proceso se canceló correctamente.");
            } 
            if ($this->guardarTareaT03GrupoIncidenciaCancelacionEmpleados($tramiteIncidencia, $request)) {
                $tramiteIncidencia->update(["aprobado_por" => Auth::user()->id, "aprobado_at" => Carbon::now()]);
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea('T04_GRUPAL_AUTORIZAR', 'NUEVO');
                return redirect()->route('tareas')->with("success", "La solicitud se envió correctamente.");
            } 
        }
        $incidenciasEmpleado = $tramiteIncidencia->tramiteAsociado->incidenciasEmpleado()
            ->where([
                "estatus" => "AUTORIZADO"
            ])->whereDoesntHave("tramitesIncidenciasCancelacion", function ($subQuery) {
                $subQuery->whereIn("estatus", ["EN_PROCESO", "COMPLETADO"]);
            })
            ->orderBy("apellido_paterno")
            ->orderBy("apellido_materno")
            ->orderBy("nombre")
            ->get()
            ->map(function ($incidencia) {
                return [
                    "incidencia_empleado_id" => $incidencia->incidencia_empleado_id,
                    "nombre_completo" => $incidencia->nombre_completo,
                    "numero_empleado" => $incidencia->numero_empleado,
                    "rfc" => $incidencia->rfc,
                    "seccion_sindical" => $incidencia->seccion_sindical,
                    "unidad_administrativa" => $incidencia->unidad_administrativa,
                    "unidad_administrativa_nombre" => $incidencia->unidad_administrativa_nombre,
                    "nomina" => $incidencia->nomina,
                    "nivel_salarial" => $incidencia->nivel_salarial,
                    "tipo_empleado" => $incidencia->tipo_empleado,
                ];
            });
        return view("p12_tramites_incidencias.tareas.incidencia_grupal.T03_cancelacionEmpleados", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }
    
    public function incidenciaGrupalAutorizar(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if ($request->isMethod('post')) {
            if ($request->estatus == "RECHAZADO") {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update(["estatus" => "RECHAZADO_ADMIN"]);
                } 
                $instanciaTarea->update([
                    "autorizado_por_usuario" => Auth::user()->id,
                    "autorizado_por_area" => Auth::user()->area->area_id,
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]);
                $tramiteIncidencia->update([
                    "rechazado_por" => Auth::user()->id, 
                    "rechazado_at" => Carbon::now(),
                    "motivo_rechazo" => $request->motivo_rechazo,
                    "estatus" => "RECHAZADO"
                ]); 
            } else {
                if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
                    $tramiteIncidencia->incidenciasEmpleado()->update([
                        "folio_autorizacion" => $tramiteIncidencia->folio,
                        "estatus" => "AUTORIZADO"
                    ]);
                    $incidenciaEmpleado = $tramiteIncidencia->incidenciasEmpleado()->first();
                    if ($incidenciaEmpleado->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario") {
                        foreach ($tramiteIncidencia->incidenciasEmpleado as $incidenciaEmpleado) {
                            $horarioEmpleado = HorarioEmpleado::create([
                                "horario_id" => $incidenciaEmpleado->horario_id,
                                "rfc" => $incidenciaEmpleado->rfc,
                                "numero_empleado" => $incidenciaEmpleado->numero_empleado,
                                "fecha_inicio" => $incidenciaEmpleado->fecha_inicio,
                                "fecha_final" => $incidenciaEmpleado->fecha_final
                            ]);
                            $incidenciaEmpleado->horario_empleado_id = $horarioEmpleado->horario_empleado_id;
                            $incidenciaEmpleado->save();
                        }
                    }
                } else if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
                    $tramiteIncidencia->incidenciasEmpleadoCancelacion()->update([
                        "folio_cancelacion" => $tramiteIncidencia->folio,
                        "numero_documento_cancelacion" => $tramiteIncidencia->numero_documento, 
                        "motivo_cancelacion" => $tramiteIncidencia->motivo_cancelacion, 
                        "firmas_cancelacion" => $tramiteIncidencia->firmas, 
                        "estatus" => "CANCELADO"
                    ]);
                    $incidenciaEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()->first();
                    if ($incidenciaEmpleado->tipoIncidencia->tipoJustificacion->identificador == "cambio_horario") {
                        foreach ($tramiteIncidencia->incidenciasEmpleadoCancelacion as $incidenciaEmpleado) {
                            $incidenciaEmpleado->horarioEmpleado()->delete();
                        }
                    }   
                }
                $instanciaTarea->updateEstatus("COMPLETADO");
                $tramiteIncidencia->update([
                    "autorizado_por" => Auth::user()->id, 
                    "autorizado_at" => Carbon::now(),
                    "estatus" => "COMPLETADO"
                ]); 
            }
            $instancia->crearInstanciaTarea("N01_INCIDENCIA_GRUPAL_RESPUESTA", "NOTIFICACION_NO_LEIDO");
            return redirect()->route('tareas')->with("success", "La respuesta se envió correctamente.");
        }

        return view("p12_tramites_incidencias.tareas.incidencia_grupal.T04_autorizarIncidencia", compact(
            "instanciaTarea", 
            "tramiteIncidencia"
        ));
    }
   
    public function incidenciaGrupalRespuesta(Request $request, TramiteIncidencia $tramiteIncidencia, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteIncidencia->instancia;
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            return redirect()->route('notificaciones')->with("success", "La notificación de eliminó correctamente.");
        }
        if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario")
                ->get();
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario")
                ->get();
        }
        return view("p12_tramites_incidencias.notificaciones.N01_incidenciaGrupalRespuesta", compact(
            "instanciaTarea", 
            "tramiteIncidencia",
            "incidenciasEmpleado"
        ));
    }
    
    public function incidenciaGrupalGetIncidenciasEmpleados(Request $request, TramiteIncidencia $tramiteIncidencia) {
        if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->orderBy("apellido_paterno")
                ->orderBy("apellido_materno")
                ->orderBy("nombre")
                ->paginate($request->pageSize);
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                ->orderBy("apellido_paterno")
                ->orderBy("apellido_materno")
                ->orderBy("nombre")
                ->paginate($request->pageSize);
        }
        return $incidenciasEmpleado;
    }
        
    // FORMATOS

    /* 
    * Descargar formato de la solicitud
    */
    public function descargarFormatoSolicitud(Request $request, TramiteIncidencia $tramiteIncidencia) {
        if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($tramiteIncidencia->tramite_incidencia_asociado_id) {
                $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleadoCancelacion()
                    ->with("tramiteIncidencia.tipoCaptura", "tipoIncidencia.tipoJustificacion", "tipoCaptura", "horario", "notasBuenas")
                    ->get();
            } else {
                $incidenciasEmpleado = json_decode($tramiteIncidencia->tramite_incidencia_asociado_historico)->incidencias_empleado;
                $incidenciasEmpleado = collect($incidenciasEmpleado);
            }
        } else {
            $incidenciasEmpleado = $tramiteIncidencia->incidenciasEmpleado()
                ->with("tramiteIncidencia", "tipoIncidencia.tipoJustificacion", "horario", "notasBuenas")
                ->get();
        }
        $firmas = json_decode($tramiteIncidencia->firmas);
        if ($tramiteIncidencia->tipoCaptura->identificador == "alta") {
            $pdf = PDF::loadView('p12_tramites_incidencias.formatos.incidencia_alta', compact(
                "tramiteIncidencia",
                "incidenciasEmpleado",
                "firmas"
            ))->setPaper("legal")->output();
        } else if ($tramiteIncidencia->tipoCaptura->identificador == "alta_nb") {
            $pdf = PDF::loadView('p12_tramites_incidencias.formatos.incidencia_alta_nb', compact(
                "tramiteIncidencia",
                "incidenciasEmpleado",
                "firmas"
            ))->setPaper("legal")->output();
        } else if ($tramiteIncidencia->tipoCaptura->identificador == "cancelacion") {
            if ($incidenciasEmpleado->first()->tramiteIncidencia->tipoCaptura->identificador == "alta") {
                $pdf = PDF::loadView('p12_tramites_incidencias.formatos.incidencia_cancelacion_alta', compact(
                    "tramiteIncidencia",
                    "incidenciasEmpleado",
                    "firmas"
                ))->setPaper("legal")->output();
            } else {
                $pdf = PDF::loadView('p12_tramites_incidencias.formatos.incidencia_cancelacion_alta_nb', compact(
                    "tramiteIncidencia",
                    "incidenciasEmpleado",
                    "firmas"
                ))->setPaper("legal")->output();
            }
        } 
        
        $pdf = base64_encode($pdf);
        
        return response()->json([
            "estatus" => true,
            "pdf" => $pdf,
            "nombre" => "solicitud_incidencia_{$tramiteIncidencia->folio}.pdf"
        ]);
    }

    public function getNotasBuenas(Request $request, TramiteIncidencia $tramiteIncidencia) {
        $empleado = (object) [
            "rfc" => $tramiteIncidencia->rfc,
            "numero_empleado" => $tramiteIncidencia->numero_empleado
        ];
        $fechaMesAnioAtras = Carbon::now()->subYear()->startOfMonth();
        $fechaMesAnterior = Carbon::now()->subMonthsNoOverflow()->endOfMonth();
        try {
            $administrarNotasBuenas = new AdministrarNotasBuenasEmpleado($empleado, $fechaMesAnioAtras, $fechaMesAnterior);
            $notasBuenasDisponibles = $administrarNotasBuenas->getNotasBuenas(); 
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => "TramiteIncidenciaController::getNotasBuenas",
                "mensaje" => $e->getMessage(), 
            ]);
            if ($e->getCode() == 1) {
                $mensaje = "No se puede acceder a la información histórica en este momento. Por favor, intenta más tarde.";
            } else {
                $mensaje = $e->getMessage();
            }
            return response()->json([
                "estatus" => false,
                "mensaje" => $mensaje
            ]);
        }
        /* $fechaRetardosFaltas = $gestionAsistencia->getFechasRetardosFaltasEmpleado($empleado); */
        return response()->json([
            "estatus" => true,
            "notasBuenasDisponibles" => $notasBuenasDisponibles,
            "fechaRetardosFaltas" => []
        ]);
    }
    
    public function getTramitesIncidenciasEmpleado(Request $request, TramiteIncidencia $tramiteIncidencia) {
        $tramitesIncidencias = TramiteIncidencia::whereHas('incidenciasEmpleado', function ($query) use ($tramiteIncidencia) {
            $query->where([
                "rfc" => $tramiteIncidencia->rfc,
                "numero_empleado" => $tramiteIncidencia->numero_empleado,
                "estatus" => "AUTORIZADO"
            ]);
        })
        ->with([
            "incidenciasEmpleado" => function ($query) use ($tramiteIncidencia) {
                $query->where([
                    "rfc" => $tramiteIncidencia->rfc,
                    "numero_empleado" => $tramiteIncidencia->numero_empleado,
                ])->orderBy("created_at", "DESC");
            },
            "incidenciasEmpleado.tipoIncidencia.tipoJustificacion", 
            "incidenciasEmpleado.notasBuenas", 
            "tipoCaptura"])
        ->orderBy("created_at", "DESC")
        ->paginate($request->pageSize);

        return $tramitesIncidencias;
    }

    public function getIncidenciasEmpleado(Request $request, TramiteIncidencia $tramiteIncidencia) {
        $incidenciasHistorico = HistoricoIncidenciaEmpleado::whereHas("cardex", function ($query) use ($tramiteIncidencia) {
            $query->where(DB::raw("CONCAT(rfc, homoclave)"), "LIKE", "%{$tramiteIncidencia->rfc}%")
                ->where("numero_empleado", $tramiteIncidencia->numero_empleado);
        })->where([
            "status" => "ACTIVO"
        ])
        ->orderBy("fecha_inicio_justificacion", "DESC")
        ->with("tramiteIncidencia", "tipoIncidencia")
        ->get();

        $incidenciasLocal = IncidenciaEmpleado::where([
            "rfc" => $tramiteIncidencia->rfc,
            "numero_empleado" => $tramiteIncidencia->numero_empleado,
            "estatus" => "AUTORIZADO"
        ])
        ->with("tipoCaptura", "tipoIncidencia.tipoJustificacion", "horario", "notasBuenas")
        ->orderBy("created_at", "DESC")
        ->get();

        $incidenciasEmpleado = $incidenciasLocal->concat($incidenciasHistorico);

        return $incidenciasEmpleado; 
    }
        
    public function getEmpleadosCumplenCondicion(Request $request, TramiteIncidencia $tramiteIncidencia) {
        $empleados = Empleado::where(function($query) use ($request) {
            if ($request->unidad_administrativa_id) {
                $unidadAdministrativa = UnidadAdministrativa::find($request->unidad_administrativa_id);
                $query->where("unidad_administrativa", $unidadAdministrativa->identificador);
            }
            if ($request->sexo) {
                $query->where("sexo", $request->sexo);
            }
            if ($request->tipo_empleado) {
                if ($request->tipo_empleado == "SINDICALIZADO") {
                    $query->where("seccion_sindical", "<>", 0);
                } else if ($request->tipo_empleado == "NOMINA_8") {
                    $query->where("nomina", 8);
                } else if ($request->tipo_empleado == "ESTRUCTURA") {
                    $query->where("nivel_salarial", ">=", 20)
                        ->where("nivel_salarial", "<=", 48);
                } else if ($request->tipo_empleado == "NO_SINDICALIZADO") {
                    $query->where("seccion_sindical", 0)
                        ->where("nomina", "!=", 8)
                        ->where(function ($query) {
                            $query->where("nivel_salarial", "<", 20)
                                ->orWhere("nivel_salarial", ">", 48);
                        });
                }
            }
            if ($request->seccion_sindical) {
                $query->where("seccion_sindical", $request->seccion_sindical);
            }
            if ($request->numeros_empleados) {
                $numerosEmpleados = explode(",", $request->numeros_empleados);
                $query->whereIn("numero_empleado", $numerosEmpleados);
            }
        })
        ->orderBy('apellido_paterno')
        ->orderBy('apellido_materno')
        ->orderBy('nombre')
        ->get();
        
        return response()->json([
            "estatus" => true,
            "empleados" => $empleados
        ]);
    }

    public function getFechasPorEstatusIncidencia(Request $request, TramiteIncidencia $tramiteIncidencia) {
        if ($tramiteIncidencia->tipo_tramite == "INCIDENCIA_GRUPAL") {
            $fechas = collect();
            $periodo = CarbonPeriod::create($request->fechaInicio, $request->fechaFinal);
            foreach ($periodo as $fecha) {
                $fechas->add([
                    "fecha" => $fecha->toDateString(),
                    "estatus" => "VALIDO"
                ]);
            }
            return response()->json([
                "estatus" => true, 
                "fechas_por_estatus" => [
                    "VALIDO" => $fechas->pluck("fecha"),
                ],
                "fechas" => $fechas
            ]);
        }

        try {
            $tipoIncidencia = TipoIncidencia::find($request->tipoIncidenciaId);
            $empleado = Empleado::where(["rfc" => $tramiteIncidencia->rfc, "numero_empleado" => $tramiteIncidencia->numero_empleado])->first();
            $administrarAsistencia = new AdministrarAsistenciaEmpleado($empleado, $request->fechaInicio, $request->fechaFinal);
            $fechasPorEstatus = $administrarAsistencia->getFechasPorEstatus($tipoIncidencia->tipo_dias);

            return response()->json([
                "estatus" => true, 
                "fechas_por_estatus" => $fechasPorEstatus["fechas_por_estatus"],
                "fechas" => $fechasPorEstatus["fechas"],
            ]);
        } catch (Exception $e) {
            LogLocal::create([
                "tipo" => "ERROR", 
                "modulo" => __METHOD__,
                "mensaje" => $e->getMessage(), 
            ]);
            return response()->json([
                "estatus" => false,
                "mensaje" => "No se puede consultar los datos en este momento. Por favor, intente más tarde."
            ]); 
        }
    }
}
