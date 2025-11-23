<?php

namespace App\Http\Controllers\p32_tramites_kerdex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\p32_tramites_kerdex\ManejadorTareas;
use App\Models\InstanciaTarea;
use App\Models\User;
use App\Models\Area;
use App\Models\Catalogo;
use App\Models\Formato;
use App\Models\p32_tramites_kardex\TramiteKardex;
use App\Models\p32_tramites_kardex\TipoTramiteKardex;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TramitesKardexController extends Controller
{
    use ManejadorTareas;

    /**
     * Método que muestra la descripcion del P32
    */
    public function descripcion() {
        return view('p32_tramites_kardex.tareas.descripcion');
    }

    /**
     * Método que inicia el P32, crea su tarea y su folio en la tabla de instancia
    */
    public function iniciarProceso(Request $request){
        // Crear registro del trámite Kardex
        $tramiteKardex = TramiteKardex::create([
            "estatus" => "EN_PROCESO"
        ]);
        // Crear instancia
        $instancia = $this->crearInstancia('tramites_kardex', $tramiteKardex, Auth::user()->area);
        // Crear la tarea T01
        $instanciaTarea = $instancia->crearInstanciaTarea('SOLICITUD_DE_TRAMITE', 'NUEVO');
        // Redirigir a T01 SOLICITUD DE TRÁMITE del Proceso
        $mensaje = 'Se ha iniciado correctamente el proceso Trámites Kardex';
        return  redirect()
                ->route('tramites.kardex.solicitud.tramites', [$tramiteKardex, $instanciaTarea])
                ->with("success", $mensaje);
    }

    /**
     * T01 SOLICITUD DE TRÁMITE P32
    */
    public function seleccionarSolicitudTramiteKardex(Request $request, TramiteKardex $tramiteKardex, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteKardex->instancia;
        $tiposTramitesKardex = TipoTramiteKardex::where('activo', true)->get();
        $entidades = DB::select('SELECT entidad_federativa_id, nombre
                                 FROM entidades_federativas
                                 WHERE activo = TRUE
                                 ORDER BY entidad_federativa_id;');

        if ($request->isMethod('post')) {
            $datosEmpleado  = json_decode($request->datos_empleado);
            $existeTramiteEnProceso = TramiteKardex::where('numero_empleado', $datosEmpleado->numero_empleado)
                                                    ->where('estatus', 'EN_PROCESO')
                                                    ->where('tipo_tramite_kardex_id', $request->tipo_tramite_kardex_id)
                                                    ->exists();
            $tipoTramite = TipoTramiteKardex::where('tipo_tramite_kardex_id', $request->tipo_tramite_kardex_id)->first();
            // Si existe un trámite en curso de este empleado regresa mensaje
            if ( $existeTramiteEnProceso ) {
                return back()->withInput()->withErrors(['mensaje_tramite' => 'El empleado capturado tiene un trámite </br><b>'. $tipoTramite->nombre .'</b> en proceso, no puedes crear uno nuevo hasta que concluya el anterior']);
            }

            // Guarda los datos de la T01
            if ($this->guardarTareaT01($tramiteKardex, $request)) {
                // Finaliza la tarea T01
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea TH02
                $instanciaTarea = $instancia->crearInstanciaTarea('ASIGNACION_DE_TRAMITE', 'NUEVO');
                // Enviar mensaje de confirmación.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p32_tramites_kardex.tareas.T01_seleccionarSolicitudTramiteKardex', compact('tramiteKardex', 'instanciaTarea', 'tiposTramitesKardex', 'entidades'));
    }

    /**
     * T02 ASIGNACIÓN DE TRÁMITES P32
     */
    public function asignacionTramitesKardex(Request $request, TramiteKardex $tramiteKardex, InstanciaTarea $instanciaTarea) {
        $instancia =  $tramiteKardex->instancia;
        $tramiteKardex->tipoTramiteKardex;
        $tramiteKardex->area;
        $documentosVerificados = json_decode($tramiteKardex->documentos);
        $tecnicosOperativosKardex = User::select('users.*')
                                    ->from('users')
                                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                    ->where('roles.name', 'TECNICO_OPERATIVO_KARDEX')
                                    ->where('users.activo', true)
                                    ->get();

        if ($request->isMethod('post')) {
            // Guarda los datos de la T02
            if ($this->guardarTareaT02($tramiteKardex, $request)) {
                // Se obtine el usuario (Técnico operativo kardex)
                $tecnicoOperativoKardex = User::find($request->tecnico_operativo_kardex);
                // Finaliza la tarea T02
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T03 y se asigna a la Instancia Tarea
                if ($tramiteKardex->tipoTramiteKardex->clave == 'hojas_de_servicio') {
                    $instanciaTarea = $instancia->crearInstanciaTarea('GENERACION_DE_DOCUMENTO_HOJAS_SERVICIO', 'NUEVO', null, null, $tecnicoOperativoKardex);
                } else if ($tramiteKardex->tipoTramiteKardex->clave == 'comprobantes_de_servicio') {
                    $instanciaTarea = $instancia->crearInstanciaTarea('GENERACION_DE_DOCUMENTO_COMPROBANTES_SERVICIO', 'NUEVO', null, null, $tecnicoOperativoKardex);
                }
                // Enviar mensaje de confirmación.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }

        }

        return view('p32_tramites_kardex.tareas.T02_asignacionTramiteKardex', compact('tramiteKardex', 'instanciaTarea', 'documentosVerificados', 'tecnicosOperativosKardex'));
    }

    /**
     * T03 GENERACIÓN DE DOCUMENTO HOJAS DE SERVICIO P32
    */
    public function generacionDocumentoTramiteKardexHojasServicio(Request $request, TramiteKardex $tramiteKardex, InstanciaTarea $instanciaTarea)  {
        $instancia =  $tramiteKardex->instancia;
        $tramiteKardex->tipoTramiteKardex;
        $tramiteKardex->area;
        $documentosVerificados = json_decode($tramiteKardex->documentos);
        $seguimientos  = isset($tramiteKardex->seguimientos) ? json_decode($tramiteKardex->seguimientos) : [];
        $detalles  = isset($tramiteKardex->detalles) ? json_decode($tramiteKardex->detalles) : [];

        if ($request->isMethod('post')) {
            // Guarda los datos
            if ($this->guardarTareaT03HojasServicio($tramiteKardex, $request)) {
                // Finaliza la tarea T03
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T04
                $instanciaTarea = $instancia->crearInstanciaTarea('DESCARGAR_DOCUMENTO', 'NUEVO');
                // Enviar mensaje de confirmación.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }
        }

        return view('p32_tramites_kardex.tareas.T03_generacionDocumentoTramiteKardexHojasServicio', compact('tramiteKardex', 'instanciaTarea', 'documentosVerificados', 'seguimientos', 'detalles'));
    }

    /**
     * T03 GENERACIÓN DE DOCUMENTO COMPROBANTES DE SERVICIO P32
    */
    public function generacionDocumentoTramiteKardexComprobantesServicio(Request $request, TramiteKardex $tramiteKardex, InstanciaTarea $instanciaTarea)  {
        $instancia =  $tramiteKardex->instancia;
        $tramiteKardex->tipoTramiteKardex;
        $tramiteKardex->area;
        $documentosVerificados = json_decode($tramiteKardex->documentos);
        $seguimientos  = isset($tramiteKardex->seguimientos) ? json_decode($tramiteKardex->seguimientos) : [];
        $detalles  = isset($tramiteKardex->detalles) ? json_decode($tramiteKardex->detalles) : [];
        $areas = Area::where('activo', true)->get();

        if ($request->isMethod('post')) {
            // Guarda los datos
            if ($this->guardarTareaT03ComprobantesServicio($tramiteKardex, $request)) {
                // Finaliza la tarea T03
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Crear la tarea T04
                $instanciaTarea = $instancia->crearInstanciaTarea('DESCARGAR_DOCUMENTO', 'NUEVO');
                // Enviar mensaje de confirmación.
                $mensaje = 'La tarea finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                // Si surge un error los manda a las tareas nuevamente.
               $mensaje = 'Error, No se finalizó la tarea, intentalo más tarde';
               return redirect()->route('tareas')->with('error', $mensaje);
            }
        }

        return view('p32_tramites_kardex.tareas.T03_generacionDocumentoTramiteKardexComprobantesServicio', compact('tramiteKardex', 'instanciaTarea', 'documentosVerificados', 'seguimientos', 'detalles', 'areas'));
    }

    // GUARDAR SEGUIMIENTOS PARTE DE T03 GENERACIÓN DE DOCUMENTO P32
    public function guardarSeguimientos(Request $request) {

        try {
            $tramiteKardex = TramiteKardex::find($request->tramite_kardex_id);
            $seguimientos  = isset($tramiteKardex->seguimientos) ? json_decode($tramiteKardex->seguimientos) : [];

            $seguimiento = count($seguimientos) > 0 ? max($seguimientos) : 1;

            $comentarioSeguimiento = [
                'seguimiento_id' => isset($seguimiento->seguimiento_id) ? ($seguimiento->seguimiento_id + 1) : $seguimiento,
                'comentario_seguimiento' => $request->comentario_seguimiento,
                'fecha_seguimiento' => Carbon::now()->format('d-m-Y H:i'),

            ];
            array_push($seguimientos, $comentarioSeguimiento);

            $tramiteKardex->seguimientos = json_encode($seguimientos);
            $tramiteKardex->save();

            $respuesta = [
                'estatus' => true,
                'mensaje' => '¡Seguimiento guardado exitosamente!',
                'data' =>  $seguimientos,
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

    // ELIMINAR SEGUIMIENTOS PARTE DE T03 GENERACIÓN DE DOCUMENTO P32
    public function eliminarSeguimientos(Request $request) {

        try {
            $tramiteKardex = TramiteKardex::find($request->tramite_kardex_id);
            $seguimientos  = isset($tramiteKardex->seguimientos) ? json_decode($tramiteKardex->seguimientos) : [];
            $id = $request->seguimiento_id;

            $seguimientosFiltrados = array_filter($seguimientos, function($elemento) use ($id) {
                return $elemento->seguimiento_id !== (int)$id;
            });

            $seguimientosFinales = array_values($seguimientosFiltrados);
            $tramiteKardex->seguimientos = json_encode($seguimientosFinales);
            $tramiteKardex->save();

            $respuesta = [
                'estatus' => true,
                'mensaje' => '¡Seguimiento eliminado exitosamente!',
                'data' =>  $seguimientosFinales,
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

    // GUARDAR DETALLES PARTE DE T03 GENERACIÓN DE DOCUMENTO P32
    public function guardarDetalles(Request $request) {

        try {
            $tramiteKardex = TramiteKardex::find($request->tramite_kardex_id);
            $detalles  = isset($tramiteKardex->detalles) ? json_decode($tramiteKardex->detalles) : [];

            $detalle = count($detalles) > 0 ? max($detalles) : 1;

            if ($tramiteKardex->tipoTramiteKardex->clave == 'hojas_de_servicio') {
                $comentarioSeguimiento = [
                    'detalle_id' => isset($detalle->detalle_id) ? ($detalle->detalle_id + 1) : $detalle,
                    'tipo_detalle' => $request->detalle_aportacion == 'baja' ? 'BAJA' : 'APORTACIÓN',
                    'motivo_baja' => $request->detalle_aportacion == 'baja' ? $request->motivo_baja : 'N/A',
                    'fecha_desde' => $request->fecha_desde,
                    'fecha_hasta' => $request->fecha_hasta,
                    'puesto' => $request->puesto,
                    'codigo_puesto' => $request->codigo_puesto,
                    'nivel_salarial' => $request->nivel_salarial,
                    'pagaduria' => $request->pagaduria,
                    'sueldo_cotizable' => $request->sueldo_cotizable,
                    'quinquenios' => $request->quinquenios,
                    'otras_percepciones' => $request->otras_percepciones,
                    'total' => ($request->sueldo_cotizable + $request->quinquenios + $request->otras_percepciones),

                ];
            } else if ($tramiteKardex->tipoTramiteKardex->clave == 'comprobantes_de_servicio') {
                $comentarioSeguimiento = [
                    'detalle_id' => isset($detalle->detalle_id) ? ($detalle->detalle_id + 1) : $detalle,
                    'fecha_detalle_inicio' => $request->fecha_detalle_inicio,
                    'fecha_detalle_termino' => $request->fecha_detalle_termino,
                    'comentario' => $request->comentario,
                ];
            }
            array_push($detalles, $comentarioSeguimiento);

            $tramiteKardex->detalles = json_encode($detalles);
            $tramiteKardex->save();

            $respuesta = [
                'estatus' => true,
                'mensaje' => '¡Detalle guardado exitosamente!',
                'data' =>  $detalles,
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

    // ELIMINAR DETALLES PARTE DE T03 GENERACIÓN DE DOCUMENTO P32
    public function eliminarDetalles(Request $request) {

        try {
            $tramiteKardex = TramiteKardex::find($request->tramite_kardex_id);
            $detalles  = isset($tramiteKardex->detalles) ? json_decode($tramiteKardex->detalles) : [];
            $id = $request->detalle_id;

            $detallesFiltrados = array_filter($detalles, function($elemento) use ($id) {
                return $elemento->detalle_id !== (int)$id;
            });

            $detallesFinales = array_values($detallesFiltrados);
            $tramiteKardex->detalles = json_encode($detallesFinales);
            $tramiteKardex->save();

            $respuesta = [
                'estatus' => true,
                'mensaje' => '¡Detalle eliminado exitosamente!',
                'data' =>  $detallesFinales,
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

    /**
     * T04 DESCARGA DE DOCUMENTO P32
    */
    public function descargarDocumentoTramiteKardex(Request $request, TramiteKardex $tramiteKardex, InstanciaTarea $instanciaTarea)  {
        $instancia =  $tramiteKardex->instancia;
        $tramiteKardex->tipoTramiteKardex;
        $tramiteKardex->area;
        $documentosVerificados = json_decode($tramiteKardex->documentos);
        $seguimientos  = isset($tramiteKardex->seguimientos) ? json_decode($tramiteKardex->seguimientos) : [];
        $detalles  = isset($tramiteKardex->detalles) ? json_decode($tramiteKardex->detalles) : [];
        $firmas = json_decode($tramiteKardex->firmas);

        if ($request->isMethod('post')) {

            // Si ya estan las firmas guardadas
            if ($request->firmado) {
                // Guarda los datos y finaliza el proceso
                if ($this->guardarTareaT04($tramiteKardex, $request)) {
                    // Finaliza la tarea T04
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    // Enviar mensaje de confirmación.
                    $mensaje = '¡El proceso finalizó correctamente!';
                    //Redirige a la vista de Tareas
                    return redirect()->route('tareas')->with('success', $mensaje);
                }
            } else {
                // Guarda las firmas antes
                if ($this->guardarTareaT04Firmas($tramiteKardex, $request)) {
                    $mensaje = '¡Guardado exitoso, ahora ya puedes descargar los formatos!';
                    //Redirige a la vista de Tareas
                    return redirect()->route('tramites.kardex.descargar.documento', [$tramiteKardex, $instanciaTarea])->with('success', $mensaje);
                } else {
                    $mensaje = '¡Debes captura las firmas para continuar!';
                    return redirect()
                            ->back()
                            ->with("error", $mensaje);
                }
            }
        }

        return view('p32_tramites_kardex.tareas.T04_descarganDocumentoTramiteKardex', compact('tramiteKardex', 'instanciaTarea', 'documentosVerificados', 'seguimientos', 'detalles', 'firmas'));
    }

    // DESCARGAR SEGUIMIENTOS PARTE DE T04 DESCARGA DE DOCUMENTO P32
    public function descargarDocumentoTramiteKardexSeguimientos(Request $request, TramiteKardex $tramiteKardex)  {

        $tramiteKardex->tipoTramiteKardex;

        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        $tramites = TramiteKardex::where('tipo_tramite_kardex_id', $tramiteKardex->tipo_tramite_kardex_id)
                                    ->where('numero_empleado', $tramiteKardex->numero_empleado)
                                    ->where('activo', true)
                                    ->orderBy('fecha_elaboracion_tramite', 'desc')
                                    ->get();

        $seguimientos = [];
        foreach ($tramites as $i => $tramite) {
            $seguimiento = json_decode($tramite->seguimientos);
            if ( isset($seguimiento) ) {
                foreach ($seguimiento as $key => $seguimientoDetalle) {
                    $seguimientoDetalle->folio = $tramite->folio;
                    $seguimientoDetalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                    $seguimientoDetalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                    $seguimientos[] = $seguimientoDetalle;
                }
            }
        }

        $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoSeguimientosKardex', compact('fechaCompleta', 'tramiteKardex', 'seguimientos'))->setPaper('a4', 'landscape')->output();

        $pdf = base64_encode($pdf);

        return response()->json([
            "estatus" => true,
            "pdf" => $pdf,
            "nombre" => "seguimientos_".$tramiteKardex->tramite_kardex_id."_tramite_kardex.pdf"
        ]);

    }

    // DESCARGAR DETALLES PARTE DE T04 DESCARGA DE DOCUMENTO P32
    public function descargarDocumentoTramiteKardexDetalles(Request $request, TramiteKardex $tramiteKardex)  {

        $tramiteKardex->tipoTramiteKardex;

        $fechaCompleta = convertirFechaFormatoMX(Carbon::now());

        $tramites = TramiteKardex::where('tipo_tramite_kardex_id', $tramiteKardex->tipo_tramite_kardex_id)
                                    ->where('numero_empleado', $tramiteKardex->numero_empleado)
                                    ->where('activo', true)
                                    ->orderBy('fecha_elaboracion_tramite', 'desc')
                                    ->get();
        $firmas = json_decode($tramiteKardex->firmas);

        if ($tramiteKardex->tipoTramiteKardex->clave == 'hojas_de_servicio') {

            $detallesBajas = [];
            $detallesAportaciones = [];
            foreach ($tramites as $i => $tramite) {
                $detalles = json_decode($tramite->detalles);
                if ( isset($detalles) ) {
                    foreach ($detalles as $key => $detalle) {
                        $detalle->folio = $tramite->folio;
                        $detalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                        $detalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                        if ( $detalle->tipo_detalle == 'BAJA' ) {
                            $detallesBajas[] = $detalle;
                        } else {
                            $detallesAportaciones[] = $detalle;
                        }
                    }
                }
            }

            $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoDetallesHojasServicio', compact('fechaCompleta', 'tramiteKardex', 'detallesBajas', 'detallesAportaciones', 'firmas'))->setPaper('a4', 'landscape')->output();

        } else if ($tramiteKardex->tipoTramiteKardex->clave == 'comprobantes_de_servicio') {

            $camposExtra = json_decode($tramiteKardex->campos_extra);

            $detallesKardex = [];
            foreach ($tramites as $i => $tramite) {
                $detalles = json_decode($tramite->detalles);
                if ( isset($detalles) ) {
                    foreach ($detalles as $key => $detalle) {
                        $detalle->folio = $tramite->folio;
                        $detalle->tipo_tramite = $tramite->tipoTramiteKardex->nombre;
                        $detalle->fecha_elaboracion_tramite = $tramite->fecha_elaboracion_tramite;
                        $detallesKardex[] = $detalle;
                    }
                }
            }

            $pdf = \PDF::loadView('p32_tramites_kardex.formatos.formatoDetallesComprobantesServicio', compact('fechaCompleta', 'tramiteKardex', 'detallesKardex', 'camposExtra', 'firmas'))->setPaper('a4', 'portrait')->output();
        }

        $pdf = base64_encode($pdf);

        return response()->json([
            "estatus" => true,
            "pdf" => $pdf,
            "nombre" => "detalles_".$tramiteKardex->tramite_kardex_id."_tramite_kardex.pdf"
        ]);
    }

    /**
    * LISTADO DE TRAMITES
    */
    public function tramiteKardexDetallesProcesoListado(Request $request) {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        foreach ($roles as $key => $rol) {
            if ( $rol == 'SUPER_ADMIN' || $rol == 'ADMIN_KARDEX' ) {
                $tramitesKardex = TramiteKardex::where('activo', true)
                                    ->whereNotNull('tipo_tramite_kardex_id')
                                    ->with('tipoTramiteKardex')
                                    ->with('asignadoAUsuario')
                                    ->orderBy('tramite_kardex_id', 'desc')
                                    ->get();
            } else {
                $tramitesKardex = TramiteKardex::where('activo', true)
                                    ->whereNotNull('tipo_tramite_kardex_id')
                                    ->where('revisado_por_usuario', $user->id)
                                    ->OrWhere('asignado_a_usuario', $user->id)
                                    ->with('tipoTramiteKardex')
                                    ->with('asignadoAUsuario')
                                    ->orderBy('tramite_kardex_id', 'desc')
                                    ->get();
            }
        }

        return view('p32_tramites_kardex.tramites.listadoTramites', compact('tramitesKardex'));
    }

    /**
    * VER DETALLE DEL LISTADO DE TRAMITES
    */
    public function tramiteKardexVerDetallesProceso(Request $request, TramiteKardex $tramiteKardex) {
        $documentosVerificados = json_decode($tramiteKardex->documentos);

        $instancia = $tramiteKardex->instancia;
        $instanciasTareas = $instancia->instanciasTareas;
        $tareaAsigancionTramiteExiste = false;
        // Si es igual a 3, significa que va en la tarea 3 donde se asigno al Técnico Operativo
        if (count($instanciasTareas) == 3) {
            $tareaAsigancionTramiteExiste = true;
            foreach ($instanciasTareas as $key => $instanciaT) {
                if ( $instanciaT->estatus == 'NUEVO') {
                    $instanciaTarea = $instanciaT;
                }
            }
        }

        $tecnicosOperativosKardex = User::select('users.*')
                                    ->from('users')
                                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                    ->where('roles.name', 'TECNICO_OPERATIVO_KARDEX')
                                    ->where('users.activo', true)
                                    ->get();

        if ($request->isMethod('post')) {
            // Actualizar datos
            if ( $this->guardarTramiteReasignacion($tramiteKardex, $request) ) {
                // Se actualiza en la Instancia Tarea también
                $instanciaTarea->update(['asignado_al_usuario' => $request->tecnico_operativo_kardex]);
                // Enviar mensaje de confirmación.
                $mensaje = '¡Se reasigno exitosamente el trámite!';
                // Redirige al listado de Tramites
                return redirect()->route('tramites.kardex.detalles.proceso')->with('success', $mensaje);
            }
        }

        return view('p32_tramites_kardex.tramites.verDetalleTramite', compact('tramiteKardex', 'documentosVerificados', 'tecnicosOperativosKardex', 'tareaAsigancionTramiteExiste'));
    }

    public function indexFormatoPrincipal() {
        $catalogo = Catalogo::where("identificador", "catalogo_formato_kardex_principal")->first();
        $sizeHeader = "140px";
        $pdf = Pdf::loadView('p32_tramites_kardex.formatos.pdf')->output();
        $pdf = base64_encode($pdf);
        $formato = Formato::where("identificador", "formato_kardex_principal")->first();
        return view('p32_tramites_kardex.catalogos.formato_principal.index', compact(
            "catalogo", 
            "pdf", 
            "formato"
        ));
    }

    public function guardarAtributosFormatoPrincipal(Request $request) {
        $formato = Formato::where("identificador", "formato_kardex_principal")->first();

        if (!empty($request->formato_logo_primario)) {
            $rutaImagen = "images/logos/logo_" .  strtolower($request->tipo_imagen) . "_" . Carbon::now()->timestamp . ".png";
            $seGuardoImagen = Storage::disk('public')->put($rutaImagen, base64_decode(str_replace("data:image/png;base64,", "", $request->formato_logo_primario)));
            if ($seGuardoImagen) {
                if ($request->tipo_imagen == 'PRINCIPAL_HEADER') {
                    $formato->logo_principal = "storage/" . $rutaImagen;
                } else if ($request->tipo_imagen == 'SECUNDARIO_HEADER') {
                    $formato->logo_secundario = "storage/" . $rutaImagen;
                } else if ($request->tipo_imagen == 'FOOTER') {
                    $formato->logo_pie = "storage/" . $rutaImagen;
                } else {
                    return response()->json([ "estatus" => true, "mensaje" => "Error al guardar imagen, no existe la opción seleccionada"]);
                }
            }
        }
        $formato->texto_encabezado = $request->formato_header;
        $formato->texto_pie = $request->formato_footer;
        $formato->save();

        $pdf = PDF::loadView('p32_tramites_kardex.formatos.pdf')->output();
        $pdf = base64_encode($pdf);

        return response()->json([
            "estatus" => true,
            "formato" => $formato,
            "formatoBase" => $pdf
        ]);
    }
}
