<?php

namespace App\Http\Controllers\p08_solicita_servicios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServicioController;

use App\Http\Controllers\p08_solicita_servicios\ManejadorTareas;
use App\Models\InstanciaTarea;
use App\Models\p08_solicita_servicios\P08SolicitaServicio;
use App\Models\p08_solicita_servicios\P08DetalleSolicitaServicio;
use App\Models\p08_solicita_servicios\Servicio;
use App\Models\p08_solicita_servicios\ServicioGeneral;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Jobs\p08_solicita_servicios\JobSolicitaServicioSolicitada;
use Illuminate\Support\Facades\Notification;
use App\Notifications\p08_solicita_serivicios\CrearSolicitudServicio;

class SolicitaServicioController extends Controller
{
    use ManejadorTareas;

    var $serviciosActuales = ['MANTENIMIENTO' => 1, 'REPRODUCCION' => 2, 'VEHICULOS' => 3, 'TELEFONIA' => 4, 'LIMPIEZA' => 5, 'OTROS' => 6];
    var $roles = ['JUD_TRANSPORTE' => 'JUD_TRANSPORTE'];

    /**
     * DESCRIPCIÓN del P08
     */
    public function descripcion($tipo_servicio) {
        $servicio = ServicioGeneral::where('clave', $tipo_servicio)->where('activo', true)->first();
        return view('p08_solicita_servicios.tareas.descripcion', compact('servicio'));
    }

    /**
     * INICIA el P08, crea su tarea y su folio en la tabla de instancia
     */
    public function inicializarProceso($tipo_servicio) {
        // Crear registro de la Solicitud de Servicio
        $solicitaServicio = $this->crearSolicitudServicio($tipo_servicio);
        // Crea instancia
        $instancia = $this->crearInstancia('solicitud_servicios', $solicitaServicio, Auth::user()->area);
        // Crea la T01
        $instanciaTarea = $instancia->crearInstanciaTarea('SELECCION_DE_SERVICIO', 'NUEVO');
        // Redirigir a T01 del Proceso
        $mensaje = 'Se ha iniciado correctamente el proceso Solicitud de Servicios';
        return redirect()
                ->route('solicitud.servicio.seleccionar.servicio', ['solicitaServicio' => $solicitaServicio, 'instanciaTarea' => $instanciaTarea])
                ->with("success", $mensaje);
    }


    /**
     * T01 del P08
     *Es usado por el usuario JUD_RM y corresponde a la T01
     */
    public function seleccionarServicio(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $usuario = Auth::user();

        $instancia = $solicitaServicio->instancia;

        $serviciosGenerales = ServicioGeneral::select('*')
        ->where('servicio_general_id', $solicitaServicio->servicio_general_id)
        ->where('activo', true)
        ->get();

        $tiposServicios = $solicitaServicio->servicioGeneral->servicios->where('activo', true)->where('nombre_servicio','!=' , 'NO HAY MATERIAL/PERSONA');

        if ($request->isMethod('post')) {

            $correos = [];
            // Si se valido correctamente los campos entra al switch
            switch ($request['servicio_general_id']) {

                case $this->serviciosActuales['MANTENIMIENTO']:

                    // Se obtiene al jud responsable de este servicio para envío de correo
                    $jud = User::role('JUD_MTTO')->first();

                    // Si es servicio de Mantenimiento se guarda
                    if ( $this->guardarTareaT01($solicitaServicio, $request ) ) {

                        // Finaliza la tarea T01
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        // Crear la tarea T02 la cual esta asignada al JUD_MTTO
                        $instancia->crearInstanciaTarea('DESGLOSE_DE_SERVICIO_MTTO', 'NUEVO');

                        // Ya que se realizo todo el flujo se obtiene detalles del servicio
                        $solicitaServicio->servicioGeneral;
                        // Se agreando los correos de los involucrados (JUD, CREADOR, RECEPTOR DEL SERVICIO)
                        array_push($correos, $usuario->email, $solicitaServicio->contacto_correo);
                        // Datos del Servicio, Correos a quien se envía copia y JUD quien atiende el Servicio
                        // JobSolicitaServicioSolicitada::dispatch($solicitaServicio, $correos, $jud->email);
                        // Notification::route("mail", $jud->email)->notify((new CrearSolicitudServicio($solicitaServicio, $correos)));

                        // Termina, redirige y envía mensaje de finalización de la tarea.
                        $mensaje = 'La tarea "Seleccionar servicio" finalizó correctamente';
                        return redirect()->route('tareas')->with('success', $mensaje);
                    }

                    break;

                case $this->serviciosActuales['REPRODUCCION']:

                    // Se obtiene al jud responsable de este servicio para envío de correo
                    $jud = User::role('JUD_IMPRE')->first();

                    // Si es servicio de Reproducción se guarda
                    if ( $this->guardarTareaT01($solicitaServicio, $request ) ) {

                        // Finaliza la tarea T01
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        // Crear la tarea T02 la cual esta asignada al JUD_IMPRE
                        $instancia->crearInstanciaTarea('DESGLOSE_DE_SERVICIO_IMPRESION', 'NUEVO');

                        // Ya que se realizo todo el flujo se obtiene detalles del servicio
                        $solicitaServicio->servicioGeneral;
                        // Se agreando los correos de los involucrados (JUD, CREADOR, RECEPTOR DEL SERVICIO)
                        array_push($correos, $usuario->email, $solicitaServicio->contacto_correo);
                        // Datos del Servicio, Correos a quien se envía copia y JUD quien atiende el Servicio
                        // JobSolicitaServicioSolicitada::dispatch($solicitaServicio, $correos, $jud->email);
                        // Notification::route("mail", $jud->email)->notify((new CrearSolicitudServicio($solicitaServicio, $correos)));

                        // Termina, redirige y envía mensaje de finalización de la tarea.
                        $mensaje = 'La tarea "Seleccionar servicio" finalizó correctamente';
                        return redirect()->route('tareas')->with('success', $mensaje);

                    }

                    break;

                case $this->serviciosActuales['VEHICULOS']:

                    // Se obtiene al jud responsable de este servicio para envío de correo
                    $jud = User::role('JUD_TRANSPORTE')->first();

                    // Si es servicio de Transporte entra aquí y se guarda.
                    if ( $this->guardarTareaT01( $solicitaServicio, $request ) ) {

                        // Finaliza la tarea T01
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        // Crear la tarea T02 la cual esta asignada al JUD_TRANSPORTE
                        $instancia->crearInstanciaTarea('DESGLOSE_DE_SERVICIO_TRANSPORTE', 'NUEVO');

                        // Ya que se realizo todo el flujo se obtiene detalles del servicio
                        $solicitaServicio->servicioGeneral;
                        // Se agreando los correos de los involucrados (JUD, CREADOR, RECEPTOR DEL SERVICIO)
                        array_push($correos, $usuario->email, $solicitaServicio->contacto_correo);
                        // Datos del Servicio, Correos a quien se envía copia y JUD quien atiende el Servicio
                        // JobSolicitaServicioSolicitada::dispatch($solicitaServicio, $correos, $jud->email);
                        // Notification::route("mail", $jud->email)->notify((new CrearSolicitudServicio($solicitaServicio, $correos)));

                        // Enviar mensaje de finalización de la tarea.
                        $mensaje = 'La tarea "Seleccionar servicio" finalizó correctamente';
                        return redirect()->route('tareas')->with('success', $mensaje);
                    }

                    break;

                case $this->serviciosActuales['TELEFONIA']:

                    // Se obtiene al jud responsable de este servicio para envío de correo
                    $jud = User::role('JUD_TELEFONIA')->first();

                    // Si es servicio de Telefonia entra aquí y se guarda.
                    if ( $this->guardarTareaT01( $solicitaServicio, $request ) ) {

                        // Finaliza la tarea T01
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        // Crear la tarea T02 la cual esta asignada al JUD_TELEFONIA
                        $instancia->crearInstanciaTarea('DESGLOSE_DE_SERVICIO_TELEFONIA', 'NUEVO');

                        // Ya que se realizo todo el flujo se obtiene detalles del servicio
                        $solicitaServicio->servicioGeneral;
                        // Se agreando los correos de los involucrados (JUD, CREADOR, RECEPTOR DEL SERVICIO)
                        array_push($correos, $usuario->email, $solicitaServicio->contacto_correo);
                        // Datos del Servicio, Correos a quien se envía copia y JUD quien atiende el Servicio
                        // JobSolicitaServicioSolicitada::dispatch($solicitaServicio, $correos, $jud->email);
                        // Notification::route("mail", $jud->email)->notify((new CrearSolicitudServicio($solicitaServicio, $correos)));

                        // Termina, redirige y envía mensaje de finalización de la tarea.
                        $mensaje = 'La tarea "Seleccionar servicio" finalizó correctamente';
                        return redirect()->route('tareas')->with('success', $mensaje);

                    }

                    break;

                case $this->serviciosActuales['LIMPIEZA']:

                    // Se obtiene al jud responsable de este servicio para envío de correo
                    $jud = User::role('JUD_LIMPIEZA')->first();

                    // Si es servicio de Limpieza se guarda
                    if ( $this->guardarTareaT01($solicitaServicio, $request ) ) {

                        // Finaliza la tarea T01
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        // Crear la tarea T02 la cual esta asignada al JUD_LIMPIEZA
                        $instancia->crearInstanciaTarea('DESGLOSE_DE_SERVICIO_LIMPIEZA', 'NUEVO');

                        // Ya que se realizo todo el flujo se obtiene detalles del servicio
                        $solicitaServicio->servicioGeneral;
                        // Se agreando los correos de los involucrados (JUD, CREADOR, RECEPTOR DEL SERVICIO)
                        array_push($correos, $usuario->email, $solicitaServicio->contacto_correo);
                        // Datos del Servicio, Correos a quien se envía copia y JUD quien atiende el Servicio
                        // JobSolicitaServicioSolicitada::dispatch($solicitaServicio, $correos, $jud->email);
                        // Notification::route("mail", $jud->email)->notify((new CrearSolicitudServicio($solicitaServicio, $correos)));

                        // Termina, redirige y envía mensaje de finalización de la tarea.
                        $mensaje = 'La tarea "Seleccionar servicio" finalizó correctamente';
                        return redirect()->route('tareas')->with('success', $mensaje);
                    }

                    break;

                case $this->serviciosActuales['OTROS']:

                    break;
            }

        }

        return view('p08_solicita_servicios.tareas.T01_seleccionaServicio', ['solicitaServicio' => $solicitaServicio, 'serviciosGenerales' => $serviciosGenerales, 'tiposServicios' => $tiposServicios, 'usuario' => $usuario, 'instanciaTarea' => $instanciaTarea ]);
    }

    /**
     * Guardar las imagenes de la T01 del P08 Solicitar Servicio
     *Es usado por el usuario JUD_RM y corresponde a la T01
     */
    public function seleccionarServicioGuardarImagenes(Request $request, P08SolicitaServicio $solicitaServicio) {
        if ( $this->guardarImagenesTareaT01($solicitaServicio, $request) ) {
            return response()->json([
                'estatus' => true,
                'mensaje' => '!Imágenes guardadas exitosamente¡'
            ]);
        } else {
            return response()->json([
                'estatus' => false,
                'mensaje' => '!Error al guardar imágenes, intente más tarde¡'
            ]);
        }
    }

    /**
     * Guardar los pdfs de la T01 del P08 Solicitar Servicio
     *Es usado por el usuario JUD_RM y corresponde a la T01
     */
    public function seleccionarServicioGuardarPDFs(Request $request, P08SolicitaServicio $solicitaServicio) {
        if ( $this->guardarPDFsTareaT01($solicitaServicio, $request) ) {
            return response()->json([
                'estatus' => true,
                'mensaje' => '!pdf guardado exitosamente¡'
            ]);
        } else {
            return response()->json([
                'estatus' => false,
                'mensaje' => '!Error al guardar pdf, intente más tarde¡'
            ]);
        }
    }


    /**
     * T02 del P08
     * Método donde se hace el Desglose del servicio.
     * Es usado por el usuario JUD_MTTO, JUD_TRANSPORTE, JUD_TELEFONIO, JUD_IMPRESIONES, JUD_LIMPIEZA
     */
    public function desgloseServicio(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {

        $instancia =  $solicitaServicio->instancia;

        $vehiculos = null;
        if ( $solicitaServicio->servicioGeneral->clave == 'vehiculos' ) {
            $vehiculos = DB::table('p08_vehiculos')
                            // ->join('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                            // ->select( 'p08_vehiculos.*', 'areas.nombre', 'areas.identificador' )
                            ->select( '*' )
                            ->where('p08_vehiculos.activo', true)
                            // ->where('areas.area_id', $solicitaServicio->area_id )
                            ->orderBy('marca', 'asc')
                            ->get();
        }

        //Se obtienen los servicios relacionados al servicio general capturado en la T01
        $servicio = Servicio::select('*')
                            ->where('servicio_general_id', $solicitaServicio->servicio_general_id)
                            ->where('activo', true)
                            ->orderby('servicio_id')
                            ->get();

        //Esta consulta se usa cuando la tarea es devuelta, y así mostrar los detalles capturados previamente
        $detalleSolicitaServicio = P08DetalleSolicitaServicio::select('*')
                                    ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
                                    ->with('servicio')
                                    ->orderby('p08_solicita_servicio_id', 'asc')
                                    ->get();

        $imagenes = isset($solicitaServicio->imagenes) ? json_decode($solicitaServicio->imagenes) : [];

        if ($request->isMethod('post')) {
            //Guarda los datos
            if ( $this->guardarTareaT02($solicitaServicio, $request) ) {

                // Finaliza T02 y se Crea la tarea T03 DIRECTO
                switch ($solicitaServicio->servicio_general_id) {

                    case $this->serviciosActuales['MANTENIMIENTO']:
                        $instancia->crearInstanciaTarea('EJECUCION_DE_SERVICIO_MTTO', 'NUEVO');
                        break;

                    case $this->serviciosActuales['REPRODUCCION']:
                        $instancia->crearInstanciaTarea('EJECUCION_DE_SERVICIO_IMPRESION', 'NUEVO');
                        break;

                    case $this->serviciosActuales['VEHICULOS']:
                        $instancia->crearInstanciaTarea('EJECUCION_DE_SERVICIO_TRANSPORTE', 'NUEVO');
                        break;

                    case $this->serviciosActuales['TELEFONIA']:
                        $instancia->crearInstanciaTarea('EJECUCION_DE_SERVICIO_TELEFONIA', 'NUEVO');
                        break;

                    case $this->serviciosActuales['LIMPIEZA']:
                        $instancia->crearInstanciaTarea('EJECUCION_DE_SERVICIO_LIMPIEZA', 'NUEVO');
                        break;

                    case $this->serviciosActuales['OTROS']:

                        break;
                }

                // Despues de guardar datos del la T02 Crear la tarea T03 DIRECTO y se notifica al JUD_RM que su solicitud se va a atender
                $instancia->crearInstanciaTarea('NOTIFICACION_ACEPTADA_SOLICITUD_SERVICIO_JUD', 'NOTIFICACION_NO_LEIDO');
                // Finaliza la tarea T02
                $instanciaTarea->updateEstatus('COMPLETADO');

                //Enviar mensaje de confirmación.
                $mensaje = 'La tarea "Desglose de servicios" finalizó correctamente';
                return redirect()->route('tareas')->with('success', $mensaje);
            }
        }

        return view('p08_solicita_servicios.tareas.T02_desgloseServicio', ['solicitaServicio' => $solicitaServicio, 'servicio' => $servicio, 'detalleSolicitaServicio' => $detalleSolicitaServicio, 'vehiculos' => $vehiculos, 'instanciaTarea' => $instanciaTarea, 'imagenes' => $imagenes]);
    }

    // Este método busca el nombre de un 'servicio' a través de su id y en relación a id del 'servicioGeneral' que se agrego en la T02 del P08
    public function getServicios(Request $request, P08SolicitaServicio $solicitaServicio) {
        if ( $request->ajax() ) {
            $servicio = Servicio::select('nombre_servicio')
            ->where('servicio_id', $request->servicio_id)
            ->where('servicio_general_id', $solicitaServicio->servicio_general_id)
            ->where('activo', true)
            ->get();
            return response()->json($servicio);
        }
    }

    // Este método busca el id de un 'detalleServicio' y lo elimina. forma parte de la T02 del P08
    public function deleteServicio(Request $request ) {
        if ( $request->ajax() ) {
            $borrado = DB::table('p08_detalle_solicita_servicios')->where('p08_detalle_solicita_servicio_id', '=', $request->id)->delete();

            return response()->json($borrado);
        }
    }

    // Método para finalizar prematuramente la T02 del P08
    public function finalizarPrematuramenteDesgloseServicio(Request $request) {

        $instanciaTarea = InstanciaTarea::find($request->instancia_tarea_id);
        $solicitaServicio = P08SolicitaServicio::find($request->solicita_servicio_id);
        $instancia      =  $solicitaServicio->instancia;

        try {
            // Actualizamos el estatus del la Solicitud de Servicio
            $solicitudServicioFinalizadoPrematura = $solicitaServicio->update([
                'estatus' => 'RECHAZADO',
                'comentarios_rechazo' => $request->motivo_rechazo
            ]);

            // Actualizamos datos de la Instancia e Instancia
            $instanciaTarea->motivo_rechazo = $request->motivo_rechazo;
            $instanciaTarea->save();
            $instanciaTarea->updateEstatus('RECHAZADO');
            $instancia->update(['estatus' => 'RECHAZADO']);

            // Crear Notificación de RECHAZO de Servicio se envía al JUD_RM que la solicito
            $instanciaTarea = $instancia->crearInstanciaTarea('NOTIFICACION_RECHAZADA_SOLICITUD_SERVICIO_JUD', 'NOTIFICACION_NO_LEIDO');

            return response()->json([
                "finalizado" => $solicitudServicioFinalizadoPrematura,
                "estatus" => true,
                "mensaje" => 'El proceso con folio ' . $solicitaServicio->folio . ' fue cancelado con éxito',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "estatus" => false,
                "mensaje" => 'Surgió un error al intentar finalizar el proceso, por favor intentelo más tarde'
            ]);
        }

    }


    /**
     * T03 del P08
     * Método donde se captura los avances del servicio hecho por los JUDs
     * Esta tarea es usada por los JUDs y corresponde a la T03 del P08.
     */
    public function ejecucionServicio(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $instancia =  $solicitaServicio->instancia;

        // Esta consulta se usa cuando la tarea es devuelta, y así mostrar los detalles capturados previamente
        $detalleSolicitaServicio = P08DetalleSolicitaServicio::select('*')
                                                            ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
                                                            ->with('servicio')
                                                            ->orderby('servicio_id', 'asc')
                                                            ->get();

        $imagenes = isset($solicitaServicio->imagenes) ? json_decode($solicitaServicio->imagenes) : [];


        if ($request->isMethod('post')) {
            // Guarda los datos
            if ($this->guardarTareaT03($solicitaServicio, $request)) {
                //Finaliza la tarea T03
                $instanciaTarea->updateEstatus('COMPLETADO');
                // Actualiza el estatus de la instancia
                $instancia->update(['estatus' => 'COMPLETADO']);
                // Finalmente se notifica al JUD_RM que su solicitud fue completada
                $instancia->crearInstanciaTarea('NOTIFICACION_COMPLETADA_SOLICITUD_SERVICIO_JUD', 'NOTIFICACION_NO_LEIDO');

                //Enviar mensaje de confirmación.
                $mensaje = 'El proceso de "Solicitar servicio" finalizó correctamente.';
                return redirect()->route('tareas')->with('success', $mensaje);
            }

        }

        return view('p08_solicita_servicios.tareas.T03_ejecucionServicio', ['solicitaServicio' => $solicitaServicio, 'detalleSolicitaServicio' => $detalleSolicitaServicio, 'instanciaTarea' => $instanciaTarea, 'imagenes' => $imagenes]);
    }

    /**
     * Parte de la T03
     * Este método busca el id de un 'detalleServicio' y lo actualiza.
     * Forma parte de la T03 del P08.
     * Y es respuesta a una petición AJAX del Guardar Avance.
     * */
    public function guardarAvancesServicio(Request $request){

        if ( $request->ajax() ) {

            $detalleServicio = P08DetalleSolicitaServicio::
            where('p08_detalle_solicita_servicio_id', $request->id)
            ->update(['fecha_entrega' => $request->fecha_entrega,
                      'estatus_detalle' => $request->estatus_detalle,
                      'comentarios_servicio' => $request->comentarios_servicio,
                      'asignado_a' => $request->asignado_a ? $request->asignado_a : 'N/A',
                      'confirmado_por' => $request->confirmado_por ? $request->confirmado_por : 'N/A',
                    ]);

            if ( $detalleServicio ){
                return response()->json([ 'mensaje' => '¡El avance fue guardado exitosamente!' ]);
            }else{
                return response()->json([ 'error' => 'Surgió un problema intente mas tarde' ]);
            }
        }
    }


    /**
     * T04 del P08
     * Método donde se hace acepta los servicios a recibir por parte de los JUDs.
     * Esta tarea es usada por el usuario JUD_RM y corresponde a la T04 del P08.
     */
    public function confirmacionServicio(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $instancia =  $solicitaServicio->instancia;

        $detalleSolicitaServicio = P08DetalleSolicitaServicio::select('*')
        ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
        ->orderby('servicio_id', 'asc')
        ->get();

        $registros = count($detalleSolicitaServicio);
        $i= 1;

        $imagenes = isset($solicitaServicio->imagenes) ? json_decode($solicitaServicio->imagenes) : [];

        if ($request->isMethod('post')) {

            // Si se autoriza
            if ( $request->interruptorEntregable ) {
                // Guarda los datos
                if ($this->guardarTareaT04($solicitaServicio, $request)) {
                    //Finaliza la tarea T04 y así termina el P08
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    // Actualiza el estatus de la instancia
                    $instancia->update(['estatus' => 'COMPLETADO']);
                    //Enviar mensaje de confirmación.
                    $mensaje = 'El proceso de "Solicitar servicio" finalizó correctamente.';
                    return redirect()->route('tareas')->with('success', $mensaje);
                }
            } else {
                if ( $this->rechazaT04yRegresaAT03($solicitaServicio, $request) ) {
                    // Si fueron rechazados los entregables asignados se finaliza la tarea 6.
                    $instanciaTarea->updateEstatus('RECHAZADO');
                    $instanciaTarea->motivo_rechazo = ( $request->textarea_comentarios_rechazo ) ? $request->textarea_comentarios_rechazo : '';
                    $instanciaTarea->save();
                    // Y se activa nuevamente la T03 que previamente se creó
                    switch ($solicitaServicio->servicio_general_id) {

                        case $this->serviciosActuales['MANTENIMIENTO']:
                            $nombreTarea = 'EJECUCION_DE_SERVICIO_MTTO';
                            break;

                        case $this->serviciosActuales['REPRODUCCION']:
                            $nombreTarea = 'EJECUCION_DE_SERVICIO_IMPRESION';
                            break;

                        case $this->serviciosActuales['VEHICULOS']:
                            $nombreTarea = 'EJECUCION_DE_SERVICIO_TRANSPORTE';
                            break;

                        case $this->serviciosActuales['TELEFONIA']:
                            $nombreTarea = 'EJECUCION_DE_SERVICIO_TELEFONIA';
                            break;

                        case $this->serviciosActuales['LIMPIEZA']:
                            $nombreTarea = 'EJECUCION_DE_SERVICIO_LIMPIEZA';
                            break;

                        case $this->serviciosActuales['OTROS']:

                            break;
                    }
                    $instancia->crearInstanciaTarea($nombreTarea, 'EN_CORRECCION');

                    $mensaje = 'La tarea "Confirmación de servicio" regreso al área correspondiente para su corrección.';
                    return redirect()->route('tareas')->with('success', $mensaje);
                }

            }

        }

        return view('p08_solicita_servicios.tareas.T04_confirmacionServicio', ['solicitaServicio' => $solicitaServicio, 'detalleSolicitaServicio' => $detalleSolicitaServicio, 'registros' => $registros, 'i' => $i, 'instanciaTarea' => $instanciaTarea, 'imagenes' => $imagenes]);
    }

    public function generarDescargarDetalleServicios($solicitudServicioId){

        $servicio = P08SolicitaServicio::where('p08_solicita_servicio_id', $solicitudServicioId)->first();

        $cadenaFecha = convertirFechaFormatoMX(Carbon::now());

        $pdf = \PDF::loadView('p08_solicita_servicios.formatos.pdf_detalle_solicita_servicio', compact('servicio','cadenaFecha') )->setPaper('a4', 'portrait')->output();

        $pdf = base64_encode($pdf);
        return response()->json([
            "estatus" => true,
            "pdf" => $pdf,
            "nombre" => "Detalle-Solicitud-Servicio-".$solicitudServicioId.".pdf"
        ]);
    }

    /**
     * Notificación: NUEVA SOLICITUD SERVICIO INICIADA
     * Método donde se muestra la notificación de la Solicitud de servicio.
     * Esta Notificacion se envía despues de crear la T01 por el usuario JUD_RM.
     * Aplica en la tareas que No requiere autorización y son enviadas al usuario SUB_CONS.
     */
    public function notificarSolicitudServicioJud(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitaServicio->instancia;
        // Actualizar estatus a LEIDO
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Notificación eliminada correctamente.';
            return redirect()->route('notificaciones')->with('success', $mensaje);
        }
        return view('p08_solicita_servicios.notificaciones.notificacionNuevaSolicitudServicioIniciadaJud', compact('solicitaServicio', 'instanciaTarea'));
    }

    /**
     * Notificación: RECHAZADO SOLICITUD SERVICIO
     * Método donde se muestra la notificación de la Solicitud de servicio Rechazada.
     * Esta Notificacion se envía al JUD_RM si es que el la T02 fue RECHAZADA por el JUD.
     */
    public function notificarRechazadaSolicitudServicioJud(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $instancia = $solicitaServicio->instancia;
        // Actualizar estatus a LEIDO
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Notificación eliminada correctamente.';
            return redirect()->route('notificaciones')->with('success', $mensaje);
        }
        return view('p08_solicita_servicios.notificaciones.notificarRechazadaSolicitudServicioJud', compact('solicitaServicio', 'instanciaTarea'));
    }

    /**
     * Notificación: ACEPTACIÓN SOLICITUD SERVICIO
     * Método donde se muestra la notificación de la Solicitud de servicio serás atendida.
     * Esta Notificacion se envía al JUD_RM si es que el la T02 la solicitud será atendida por el JUD.
     */
    public function notificarAceptadoSolicitudServicioJud(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {
        $instancia =  $solicitaServicio->instancia;

        $detalleSolicitaServicio = P08DetalleSolicitaServicio::select('*')
            ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
            ->orderby('servicio_id', 'asc')
            ->get();

        $registros = count($detalleSolicitaServicio);
        $i= 1;

        $imagenes = isset($solicitaServicio->imagenes) ? json_decode($solicitaServicio->imagenes) : [];

        // Actualizar estatus a LEIDO
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Notificación eliminada correctamente.';
            return redirect()->route('notificaciones')->with('success', $mensaje);
        }

        return view('p08_solicita_servicios.notificaciones.notificarAceptadaSolicitudServicioPorJud', compact('solicitaServicio', 'instanciaTarea', 'detalleSolicitaServicio', 'registros', 'i', 'imagenes'));
    }

    /**
     * Notificación: COMPLETADA SOLICITUD SERVICIO
     * Método donde se muestra la notificación de la Solicitud de servicio serás atendida.
     * Esta Notificacion se envía al JUD_RM si es que el la T02 la solicitud será atendida por el JUD.
     */
    public function notificarCompletadaSolicitudServicioJud(Request $request, P08SolicitaServicio $solicitaServicio, InstanciaTarea $instanciaTarea) {

        $instancia =  $solicitaServicio->instancia;

        $detalleSolicitaServicio = P08DetalleSolicitaServicio::select('*')
        ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
        ->orderby('servicio_id', 'asc')
        ->get();

        $registros = count($detalleSolicitaServicio);
        $i= 1;

        $imagenes = isset($solicitaServicio->imagenes) ? json_decode($solicitaServicio->imagenes) : [];

        // Actualizar estatus a LEIDO
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }
        if ($request->isMethod('post')) {
            // Actualizar estatus a ELIMINADO
            $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
            $mensaje = 'Notificación eliminada correctamente.';
            return redirect()->route('notificaciones')->with('success', $mensaje);
        }

        return view('p08_solicita_servicios.notificaciones.notificarCompletadaSolicitudServicioPorJud', compact('solicitaServicio', 'instanciaTarea', 'detalleSolicitaServicio', 'registros', 'i', 'imagenes'));
    }

}
