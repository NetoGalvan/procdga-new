<?php

namespace App\Http\Controllers\p01_movimientos_personal;

use App\Exports\p01_movimientos_personal\MovimientosExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServicioController;
use App\Http\Traits\RegistroInstancias;
use App\Models\p01_movimientos_personal\Banco;
use App\Models\EntidadFederativa;
use App\Models\InstanciaTarea;
use App\Models\p01_movimientos_personal\EstadoCivil;
use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\p01_movimientos_personal\NivelEstudio;
use App\Models\p01_movimientos_personal\RegimenIssste;
use App\Models\p01_movimientos_personal\Sexo;
use App\Models\p01_movimientos_personal\SituacionEmpleado;
use App\Models\p01_movimientos_personal\TipoCalificacionPsicometrico;
use App\Models\p01_movimientos_personal\TipoMovimiento;
use App\Models\p01_movimientos_personal\TipoPago;
use App\Models\p01_movimientos_personal\Turno;
use App\Models\p01_movimientos_personal\ZonaPagadora;
use App\Models\NivelSalarial;
use App\Models\Plaza;
use App\Models\SituacionPlaza;
use App\Models\Universo;
use App\Models\TipoDocumento;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MovimientoPersonalController extends Controller {
    
    use RegistroInstancias;
    use ManejadorTareas;

    public function descripcion() {
        return view('p01_movimientos_personal.tareas.descripcion');
    }

    public function inicializarProceso() {
        $movimientoPersonal =  MovimientoPersonal::create([
            "estatus" => "EN_PROCESO",
            "area_id" => Auth::user()->area->area_id
        ]);
        $instancia = $this->crearInstancia("movimientos_personal", $movimientoPersonal, Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea("T01", "NUEVO"); 
        return redirect()->route("movimiento.personal.seleccionar.movimiento", [$movimientoPersonal, $instanciaTarea])
            ->with("success", "El proceso se creó correctamente.");
    }

    /**
     * T01 - SELECCIONAR MOVIMIENTO
     */
    public function seleccionarMovimiento(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            $this->guardarTareaT01($movimientoPersonal, $request);
            $tareaSiguiente = $this->seleccionCodigos($movimientoPersonal);
            if ($instanciaTarea->estatus == "NUEVO") {
                $nuevaInstanciaTarea = $instancia->crearInstanciaTarea($tareaSiguiente["nombreTarea"], "NUEVO");
            } else if ($instanciaTarea->estatus == "EN_CORRECCION") {
                $nuevaInstanciaTarea = $instancia->crearInstanciaTarea($tareaSiguiente["nombreTarea"], "EN_CORRECCION");
            }
            // FINALIZAR TAREA ACTUAL
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instanciaTarea->setUsuarioAutorizador(Auth::user());
            return redirect()->route($tareaSiguiente['url'], [$movimientoPersonal, $nuevaInstanciaTarea])
                ->with("success", "La tarea finalizó correctamente.");
        }
        $tiposMovimientos = TipoMovimiento::activo()->get()->groupBy('tipo');
        return view('p01_movimientos_personal.tareas.T01_seleccionarMovimiento', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'tiposMovimientos'
        ));
    }

    /**
     * TA02 - CAPTURAR PROPUESTA
     */
    public function capturarPropuesta(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTA02($movimientoPersonal, $request)) {
                if ($instanciaTarea->estatus == "NUEVO") {
                    $request->merge(["examen_psicometrico" => $request->has("examen_psicometrico")]);
                    if ($movimientoPersonal->tipoMovimiento->codigo == "102") {
                        if ($request->examen_psicometrico) {
                            $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('TA03', 'NUEVO');
                            $rutaRedirect = route("tareas");
                        } else {
                            $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('TA05', 'NUEVO');
                            $rutaRedirect = route("movimiento.personal.altas.alimentario", [$movimientoPersonal, $nuevaInstanciaTarea]);
                        }
                    } else {
                        $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('TA03', 'NUEVO');
                        $rutaRedirect = route("tareas");
                    }
                } else if ($instanciaTarea->estatus == "EN_CORRECCION") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea("TA05", "EN_CORRECCION");
                    $rutaRedirect = route("movimiento.personal.altas.alimentario", [$movimientoPersonal, $nuevaInstanciaTarea]);
                }
                // FINALIZAR TAREA ACTUAL
                $instanciaTarea->updateEstatus('COMPLETADO');
                $instanciaTarea->setUsuarioAutorizador(Auth::user());
                return redirect($rutaRedirect)
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $unidadAdministrativa = $movimientoPersonal->area->unidadAdministrativa->identificador;
        
        if ($movimientoPersonal->tipo_plaza == 'TECNICO_OPERATIVO') {
            $plazas = Plaza::where('unidad_administrativa', $unidadAdministrativa)
                ->where(function($query) {
                    $query->where('nivel_salarial', '<=', 199)
                        ->orWhere('nivel_salarial', '>=', 500);
                })
                ->get();
        } else {
            $plazas = Plaza::where('unidad_administrativa', $unidadAdministrativa)
                ->whereHas(function($query) {
                    $query->where('nivel_salarial', '>', 199)
                        ->orWhere('nivel_salarial', '<', 500);
                })
                ->get();
        }
        $nivelesEstudio = NivelEstudio::activo()->get();
        return view('p01_movimientos_personal.tareas.TA02_propuesta', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'nivelesEstudio',
            'plazas'
        ));
    }

    /**
     * TA03 - CITA EXAMEN PSICOMÉTRICO
     */
    public function crearCitaExamen(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTA03($movimientoPersonal, $request->all())) {
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea("TANOTA01", "NOTIFICACION_NO_LEIDO");
                $instancia->crearInstanciaTarea("TA04", "NUEVO");
                return redirect()->route("tareas")
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        return view('p01_movimientos_personal.tareas.TA03_citaPsicometrico', compact(
            'instanciaTarea',
            'movimientoPersonal'
        ));
    }

    /**
     * TANOTA01 - NOTIFICACIÓN CITA DE EXAMEN
     */
    public function notificarCitaExamen(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            return redirect()->route('notificaciones');
        }
        $usuarioEvaluador = User::role('COO_EVAL')->first();
        return view('p01_movimientos_personal.notificaciones.TANOTA01_notificacionCitaPsicometrico', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'usuarioEvaluador'
        ));
    }

    /**
     * TA04 - ASIGNAR CALIFICACIÓN DE EXAMEN
     */
    public function asignarCalificacionExamen(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTA04($movimientoPersonal, $request)) {
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea("TA05", "NUEVO");
                return redirect()->route("tareas")
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $tiposCalificaciones = TipoCalificacionPsicometrico::activo()->get();
        return view('p01_movimientos_personal.tareas.TA04_calificacionPsicometrico', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'tiposCalificaciones'
        ));
    }

    /**
     * TA05 - CAPTURAR ALIMENTARIO
     */
    public function capturarAlimentarioAltas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTA05($movimientoPersonal, $request)) {
                if ($instanciaTarea->estatus == "NUEVO") {
                    $nuevaInstanciaTarea = $instancia->crearInstanciaTarea('TA06', 'NUEVO');
                    $rutaRedirect = route("movimiento.personal.altas.lista.documentacion", [$movimientoPersonal, $nuevaInstanciaTarea]);
                } else if ($instanciaTarea->estatus == "EN_CORRECCION") {
                    $rutaRedirect = route("tareas");
                    $instancia->crearInstanciaTarea("TA07", 'EN_CORRECCION');
                    $movimientoPersonal->estatus_sun = "LISTO";
                    $movimientoPersonal->save();
                }
                // FINALIZAR TAREA ACTUAL
                $instanciaTarea->updateEstatus('COMPLETADO');
                return redirect($rutaRedirect)
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $usersDGA = User::activo()->with("roles")->whereHas("roles", function($q) {
            $q->whereIn("name", ["DGA"]);
        })->get();
        $usersTitulares = User::activo()
            ->where("area_id", Auth::user()->area_id)
            ->whereHas("roles", function($q) {
                $q->whereIn("name", ["TITULAR_EA"]);
            })->get();
        $entidades = EntidadFederativa::activo()->get();
        $bancos = Banco::activo()->get();
        $regimen = RegimenIssste::activo()->get();
        $sexos = Sexo::activo()->get();
        $situacionEmpleado = SituacionEmpleado::activo()->get();
        $tipoPago = TipoPago::activo()->get();
        $turnos = Turno::activo()->get();
        $estadosCiviles = EstadoCivil::activo()->orderBy("estado_civil_id")->get();
        $zonasPagadoras = ZonaPagadora::activo()->get();
        return view('p01_movimientos_personal.tareas.TA05_alimentarioAltas', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'entidades',
            'bancos',
            'regimen',
            'sexos',
            'situacionEmpleado',
            'tipoPago',
            'turnos',
            'estadosCiviles',
            'zonasPagadoras',
            'usersDGA',
            'usersTitulares'
        ));
    }

    /**
     * TA06 - LISTAR DOCUMENTACIÓN
     */
    public function listarDocumentacion(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTA06($movimientoPersonal)) {
                $instancia->crearInstanciaTarea('TA07', 'NUEVO');
                $instanciaTarea->updateEstatus('COMPLETADO');
                return redirect()->route('tareas')
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $tiposDocumentos = TipoDocumento::activo()->grupo("movimientos_personal")->get();
        return view('p01_movimientos_personal.tareas.TA06_listaDocumentos', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'tiposDocumentos'
        ));
    }

    /**
     * TA07 - FINALIZAR MOVIMIENTO DE ALTAS 
     */
    public function finalizarMovimientoAltas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($request->estatus == "COMPLETADO") {
                $movimientoPersonal->numero_empleado = $request->numero_empleado;
                $movimientoPersonal->numero_expediente = $request->numero_empleado;
                $movimientoPersonal->fecha_elaboracion = $request->fecha_elaboracion;
                $movimientoPersonal->anio_procesado = $request->anio_procesado;
                $movimientoPersonal->qna_procesado = $request->qna_procesado;
                $movimientoPersonal->estatus = "COMPLETADO";
                $movimientoPersonal->estatus_sun = "COMPLETADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea('TA08', 'NUEVO');
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            } else {
                $movimientoPersonal->motivo_rechazo = $request->motivo_rechazo;
                $movimientoPersonal->estatus = "RECHAZADO";
                $movimientoPersonal->estatus_sun = "RECHAZADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("RECHAZADO");
                $instanciaTarea->motivo_rechazo = $request->motivo_rechazo;
                $instanciaTarea->save();
                $instancia->crearInstanciaTarea('T01', 'EN_CORRECCION');                    
                return redirect()->route('tareas')->with("success", "El movimiento se envió a corrección.");
            }
        }
        return view('p01_movimientos_personal.tareas.TA07_finalizacionMovimientoAltas', compact(
            'instanciaTarea',
            'movimientoPersonal'
        ));
    }
    
    /**
     * TA08 - GENERAR DOCUMENTO DE ALTAS 
     */
    public function generarDocumentoAltas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea){
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            return redirect()->route('tareas')
                ->with("success", "El proceso finalizó correctamente.");
        }
        return view('p01_movimientos_personal.tareas.TA08_generarDocumentoAltas', compact(
            'instanciaTarea',
            'movimientoPersonal'
        ));
    }

    /**
     * TB02 - CAPTURAR ALIMENTARIO BAJAS
     */
    public function capturarAlimentarioBajas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTB02($movimientoPersonal, $request)) {
                if ($instanciaTarea->estatus == "NUEVO") {
                    $instancia->crearInstanciaTarea('TB03', 'NUEVO');
                } else if ($instanciaTarea->estatus == "EN_CORRECCION") {
                    $instancia->crearInstanciaTarea("TB03", 'EN_CORRECCION');
                }
                // FINALIZAR TAREA ACTUAL
                $instanciaTarea->updateEstatus('COMPLETADO');
                $instanciaTarea->setUsuarioAutorizador(Auth::user());
                return redirect("tareas")
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $usersDGA = User::activo()->with("roles")->whereHas("roles", function($q) {
            $q->whereIn("name", ["DGA"]);
        })->get();
        $usersTitulares = User::activo()
            ->where("area_id", Auth::user()->area_id)
            ->whereHas("roles", function($q) {
                $q->whereIn("name", ["TITULAR_EA"]);
            })->get();
        $entidades = EntidadFederativa::activo()->get();
        $situacionesPlaza = SituacionPlaza::activo()->get();
        $nivelesSalariales = NivelSalarial::activo()->get();
        $universos = Universo::activo()->get();
        return view('p01_movimientos_personal.tareas.TB02_alimentarioBajas', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'entidades',
            'situacionesPlaza',
            'nivelesSalariales',
            'universos',
            'usersDGA',
            'usersTitulares'
        ));
    }

    /**
     * TB03 - FINALIZAR MOVIMIENTO BAJAS
     */
    public function finalizarMovimientoBajas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->setUsuarioAutorizador(Auth::user());
            if ($request->estatus == "COMPLETADO") {
                $movimientoPersonal->fecha_elaboracion = $request->fecha_elaboracion;
                $movimientoPersonal->anio_procesado = $request->anio_procesado;
                $movimientoPersonal->qna_procesado = $request->qna_procesado;
                $movimientoPersonal->estatus = "COMPLETADO";
                $movimientoPersonal->estatus_sun = "COMPLETADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea('TB04', 'NUEVO');
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            } else {
                $movimientoPersonal->motivo_rechazo = $request->motivo_rechazo;
                $movimientoPersonal->estatus = "RECHAZADO";
                $movimientoPersonal->estatus_sun = "RECHAZADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("RECHAZADO");
                $instanciaTarea->motivo_rechazo = $request->motivo_rechazo;
                $instanciaTarea->save();
                $instancia->crearInstanciaTarea('T01', 'EN_CORRECCION');                    
                return redirect()->route('tareas')->with("success", "El movimiento se envió a corrección.");
            }
        }
        return view('p01_movimientos_personal.tareas.TB03_finalizacionMovimientoBajas', compact(
            "instanciaTarea",
            "movimientoPersonal"
        ));
    }

    /**
     * TB04 - GENERAR DOCUMENTO BAJAS
     */
    public function generarDocumentoBajas(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instanciaTarea->setUsuarioAutorizador(Auth::user());
            return redirect()->route('tareas')
                ->with("success", "El proceso finalizó correctamente.");
        }
        return view('p01_movimientos_personal.tareas.TB04_generarDocumentoBajas', compact(
            "instanciaTarea",
            "movimientoPersonal"
        ));
    }

    /**
     * TR02 - CAPTURAR ALIMENTARIO REANUDACIONES
     */
    public function capturarAlimentarioReanudaciones(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($this->guardarTareaTR02($movimientoPersonal, $request)) {
                if ($instanciaTarea->estatus == "NUEVO") {
                    $instancia->crearInstanciaTarea('TR03', 'NUEVO');
                } else if ($instanciaTarea->estatus == "EN_CORRECCION") {
                    $instancia->crearInstanciaTarea("TR03", 'EN_CORRECCION');
                }
                // FINALIZAR TAREA ACTUAL
                $instanciaTarea->updateEstatus('COMPLETADO');
                return redirect("tareas")
                    ->with("success", "La tarea finalizó correctamente.");
            }
        }
        $usersDGA = User::activo()->with("roles")->whereHas("roles", function($q) {
            $q->whereIn("name", ["DGA"]);
        })->get();
        $usersTitulares = User::activo()
            ->where("area_id", Auth::user()->area_id)
            ->whereHas("roles", function($q) {
                $q->whereIn("name", ["TITULAR_EA"]);
            })->get();
        $unidadAdministrativa = Auth::user()->area->unidadAdministrativa->identificador;  
        if ($movimientoPersonal->tipo_plaza == 'TECNICO_OPERATIVO') {
            $plazas = Plaza::where('unidad_administrativa', $unidadAdministrativa)
                ->where(function($query) {
                    $query->where('nivel_salarial', '<=', 199)
                        ->orWhere('nivel_salarial', '>=', 500);
                })
                ->get();
        } else {
            $plazas = Plaza::where('unidad_administrativa', $unidadAdministrativa)
                ->whereHas(function($query) {
                    $query->where('nivel_salarial', '>', 199)
                        ->orWhere('nivel_salarial', '<', 500);
                })
                ->get();
        }
        $entidades = EntidadFederativa::activo()->get();
        $situacionesPlaza = SituacionPlaza::activo()->get();
        $nivelesSalariales = NivelSalarial::activo()->get();
        $universos = Universo::activo()->get();
        return view('p01_movimientos_personal.tareas.TR02_alimentarioReanudaciones', compact(
            'instanciaTarea',
            'movimientoPersonal',
            'entidades',
            'plazas',
            'situacionesPlaza',
            'nivelesSalariales',
            'universos',
            'usersDGA',
            'usersTitulares'
        ));
    }

    /**
     * TR03 - FINALIZAR MOVIMIENTO REANUDACIONES
     */
    public function finalizarMovimientoReanudaciones(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            if ($request->estatus == "COMPLETADO") {
                $movimientoPersonal->fecha_elaboracion = $request->fecha_elaboracion;
                $movimientoPersonal->anio_procesado = $request->anio_procesado;
                $movimientoPersonal->qna_procesado = $request->qna_procesado;
                $movimientoPersonal->estatus = "COMPLETADO";
                $movimientoPersonal->estatus_sun = "COMPLETADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("COMPLETADO");
                $instancia->crearInstanciaTarea('TR04', 'NUEVO');
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            } else {
                $movimientoPersonal->motivo_rechazo = $request->motivo_rechazo;
                $movimientoPersonal->estatus = "RECHAZADO";
                $movimientoPersonal->estatus_sun = "RECHAZADO";
                $movimientoPersonal->save();
                $instanciaTarea->updateEstatus("RECHAZADO");
                $instanciaTarea->motivo_rechazo = $request->motivo_rechazo;
                $instanciaTarea->save();
                $instancia->crearInstanciaTarea('T01', 'EN_CORRECCION');                    
                return redirect()->route('tareas')->with("success", "El movimiento se envió a corrección.");
            }
        }
        return view('p01_movimientos_personal.tareas.TR03_finalizacionMovimientoReanudaciones', compact(
            "instanciaTarea",
            "movimientoPersonal"
        ));
    }

    /**
     * TR04 - GENERAR DOCUMENTO REANUDACIONES
     */
    public function generarDocumentoReanudaciones(Request $request, MovimientoPersonal $movimientoPersonal, InstanciaTarea $instanciaTarea) {
        $instancia = $movimientoPersonal->instancia;
        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            return redirect()->route('tareas')
                ->with("success", "El proceso finalizó correctamente.");
        }
        return view('p01_movimientos_personal.tareas.TR04_generarDocumentoReanudaciones', compact(
            "instanciaTarea",
            "movimientoPersonal"
        ));
    }

    public function generarArchivosSun() {
        $movimientos = MovimientoPersonal::where("estatus_sun", "LISTO")->with("tipoMovimiento")->get();
        $movimientos = $movimientos->groupBy("tipoMovimiento.tipo");

        return view('p01_movimientos_personal.archivos_sun.archivos_sun', compact("movimientos"));
    }

    public function descargarListaDocumentacion(Request $request, MovimientoPersonal $movimientoPersonal) {
        $listaDocumentos = json_decode($request->listaDocumentos);
        $pdf = PDF::loadView('p01_movimientos_personal.formatos.lista_documentacion', compact(
            "movimientoPersonal",
            "listaDocumentos"
        ))->setPaper("legal");
        return response()->json([
            "status" => true,
            "nombre_pdf" => "lista_documentacion.pdf",
            "pdf" => base64_encode($pdf->output())
        ]);
    }

    public function descargarAlimentarioAltas(Request $request, MovimientoPersonal $movimientoPersonal) {    
        $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_altas', compact(
            "movimientoPersonal"
        ))->setPaper("legal");
        return $pdf->download('documento_alimentario_alta.pdf');
    }

    public function descargarAlimentarioBajas(Request $request, MovimientoPersonal $movimientoPersonal) {
        $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_bajas', compact(
            "movimientoPersonal"
        ))->setPaper("letter", "landscape");
        return $pdf->download('documento_alimentario_baja.pdf');
    }

    public function descargarAlimentarioReanudaciones(Request $request, MovimientoPersonal $movimientoPersonal) {
        $pdf = PDF::loadView('p01_movimientos_personal.formatos.alimentario_reanudaciones', compact(
            "movimientoPersonal"
        ));
        return $pdf->download('documento_alimentario_reanudacion.pdf');
    }

    public function descargarArchivosSun($tipoMovimiento) {
        $movimientos = MovimientoPersonal::where("estatus_sun", "LISTO")
            ->whereHas("tipoMovimiento", function ($query) use ($tipoMovimiento) {
                $query->where("tipo", $tipoMovimiento);
            })->get();
        return Excel::download(new MovimientosExport($tipoMovimiento, $movimientos), "p01v2_Agregado_$tipoMovimiento.xlsx");
    }

    public function getDatosEmpleadoMovimientosPersonal(Request $request) {
        $servicio = new ServicioController();
        $usuario = MovimientoPersonal::select('nombre_empleado', 'apellido_paterno', 'apellido_materno', 'rfc')
                        ->where('rfc', $request->rfc )
                        ->where('numero_empleado', $request->numero_empleado)
                        ->latest()
                        ->first();

        if (!is_null($usuario)) {
            return response()->json([
                'nombre_empleado' => $usuario->nombre_empleado,
                'primer_apellido' => $usuario->primer_apellido,
                'segundo_apellido' => $usuario->segundo_apellido,
                'rfc' => $usuario->rfc
            ]);
        }
        return $servicio->getDatosEmpleado($request);
    }
}

