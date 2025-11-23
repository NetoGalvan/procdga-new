<?php
namespace App\Http\Controllers\p11_seleccion_candidatos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\p11_seleccion_candidatos\Candidato;
use App\Models\p11_seleccion_candidatos\SeleccionCandidatoEstructura;
use App\Models\p11_seleccion_candidatos\DetallesCandidato;
use App\Http\Controllers\ServicioController;
use App\Models\p24_directorio\Plaza;
use DB;
use Auth;

class SeleccionCandidatosController extends Controller
{
    use SeleccionCandidatoTrait;

    public function vistaSeleccionDescripcion ()
    {

        return view('p11_seleccion_candidatos.descripcion_candidatos');

    }

    // Metodo encargado de iniciar el P11 y redirige a la T01
    public function guardarSeleccionCandidatos ()
    {
        // Crear registro de Selección Candidato Estructura
        $candidatoEstructura = SeleccionCandidatoEstructura::create([]);
        // Crea instancia
        $instancia = $this->crearInstanciaSeleccionCandidatos($candidatoEstructura);
        // Crear la tarea T01
        $instanciaTarea = $instancia->crearInstanciaTarea('T01', 'NUEVO');
        // Crear folio del proceso
        $this->crearFolio($instancia, $instanciaTarea);
        // Redirigir a T01 - Selección de Candidatos
        return redirect()->route('seleccion.candidatos.cita.examen', $candidatoEstructura);

    }

    // T01 del P11 muestra el Formulario para capturar los candidatos
    public function vistaCitaExamenPsicometrico ( SeleccionCandidatoEstructura $candidatoEstructura )
    {

        if ( $candidatoEstructura->instancia->estatus == 'RECHAZADO') {
            return redirect('tareas');
        } else {
            $usuarios = Auth::user();
            $plazas = Plaza::where('activo', true)->get();
            // Se hace la consulta si existen Candidatos previamente cargados
            $seleccionCandidatos = DB::table('p11_seleccion_candidatos as seleccion')
                ->join('p11_detalles as detalles', 'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
                ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
                ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'detalles.observaciones_titular', 'candidatos.nombre_candidato',
                    'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc', 'candidatos.no_empleado',
                    'seleccion.seleccion_candidato_id', 'candidatos.candidato_id')
                ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
                ->get();
            // Validar si existen Candidatos previos
            $existenCandidatos = count($seleccionCandidatos) > 0 ? true : false;

            return view('p11_seleccion_candidatos.T01_solicitudCitaPsicometrico', compact('candidatoEstructura', 'usuarios', 'plazas', 'seleccionCandidatos', 'existenCandidatos'));
        }

    }

    public function consultarRfc ( $rfc )
    {

        $candidatos = DB::table('p11_candidatos')->where('rfc', '=', $rfc)->get();
        return response()->json($candidatos);

    }

    // Método que permite finalizar el PROCESO ANTICIPADAMENTE desde la T01
    public function finalizarProcesoSeleccionCandidatos( Request $request, SeleccionCandidatoEstructura $seleccionCandidatoEstructura ) {

        try {
            // Finalizar el Proceso desde la T01
            $instancia = $seleccionCandidatoEstructura->instancia;
            $instanciaTarea = $instancia->getInstanciaTarea('T01');
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            // Actualizamos el estatus en la Instancia que finaliza prematuramente
            $instancia->update(['estatus' => 'PREMATURAMENTE_FINALIZADO']);

            $respuesta = [
                'estatus' => true,
                'msj' => '¡El proceso se concluyó con exito!'
            ];
            return response()->json($respuesta);

        } catch (\Throwable $th) {

            $respuesta = [
                'estatus' => false,
                'data' => $th,
                'msj' => '¡El proceso No concluyó con exito, intente más tarde!'
            ];
            return response()->json($respuesta);

        }

    }

    // Método encargado de guardar los datos finalizar la T01
    public function guardarCandidatos ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {
        // Obtenemos los datos de la instancia
        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T01');

        // Pasamos los valores para su guardado
        $guardadoExitoso = $this->guardarTarea1CitaPsicometrico($request, $candidatoEstructura);

        if ( $guardadoExitoso ) {
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            $instancia->crearInstanciaTarea('TS02', 'NUEVO');
            return redirect('tareas')->with('mensaje', 'Se ha guardado correctamente');
        } else {
            // dd($guardadoExitoso);
            return redirect('tareas')->with('mensaje', $guardadoExitoso);
        }

    }

    // TS02 del P11 muestra el Formulario para validar a el/los Candidatos
    public function vistaValidacionPropuestas ( SeleccionCandidatoEstructura $candidatoEstructura )
    {
        dd('Aquí se debe Iniciar la fucnionalidad para crear y llevar a cabo la TS02');
        if ( $candidatoEstructura->instancia->estatus == 'RECHAZADO') {
            return redirect('tareas');
        } else {
            $aceptacionSrio = 0;
            $usuario = Auth::user();
            $seleccionCandidatos = DB::table('p11_seleccion_candidatos as seleccion')
                ->join('p11_detalles as detalles', 'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
                ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
                ->select('seleccion.created_at', 'seleccion.seleccion_candidato_id',
                    'detalles.tipo_movimiento', 'detalles.observaciones_titular', 'detalles.aceptacion_srio',
                    'candidatos.nombre_candidato', 'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato',
                    'candidatos.rfc', 'candidatos.candidato_id')
                ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
                ->get();

            // Se recorre para validar si ya fue Validado por el SRIO
            foreach ($seleccionCandidatos as $key => $selecCan) {
                $aceptacionSrio += isset($selecCan->aceptacion_srio) ? 1 : 0 ;
            }

            return view('p11_seleccion_candidatos.TS02_validacionPropuestas',
                    compact('candidatoEstructura', 'usuario', 'seleccionCandidatos', 'aceptacionSrio') );
        }
    }

    // TS02 del P11 Guarda los datos del Formulario para validar a el/los Candidatos
    public function guardarValidacionPropuestas ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('TS02');

        // Usamos el método del Trait para guardar la información
        $guardado = $this->guardarValidacionCandidatos($request->all(), $candidatoEstructura);

        // Si se valido algún candidato se crea la T02 y continua el Proceso
        if ( $guardado['validado'] >= 1 ) {

            // Actualizamos el estatus de la tarea actual
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            // Creamos la nueva tarea
            $instancia->crearInstanciaTarea('T02', 'NUEVO');
            // Despues del guardado, se manda la respuesta
            $respuesta = [ 'estatus' => true, 'msj' => '¡La información se envío exitosamente!' ];
            return response()->json($respuesta);

        } else {

            // Actualizamos el estatus en la Instancia que finaliza por RECHAZO a todos los candidatos
            $instancia->update(['estatus' => 'RECHAZADO']);
            // Actualiamos el estatus de la tarea
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            // Se rechazaron todo los Candidatos Finaliza el Proceso y se manda Notificación
            $candidatoEstructura->instancia->crearInstanciaTarea('TNOTA02', 'NOTIFICACION_NO_LEIDO');
            // Despues del guardado, se manda la respuesta
            $respuesta = [ 'estatus' => false, 'msj' => '¡La tarea finalizo, ningun candidato fue aceptado. Se notificará al área!' ];
            return response()->json($respuesta);

        }

    }

    // T02 del P11 muestra el Formulario para Asignar fecha de Examen del Candidato
    public function vistaAsignacionFechaExamen ( SeleccionCandidatoEstructura $candidatoEstructura )
    {
        if ( $candidatoEstructura->instancia->estatus == 'RECHAZADO') {
            return redirect('tareas');
        } else {
            $fechaAsiganda = 0;
            $usuario = Auth::user();
            $seleccionCandidato = DB::table('p11_seleccion_candidatos as seleccion')
                ->join('p11_detalles as detalles', 'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
                ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
                ->select('seleccion.created_at', 'seleccion.seleccion_candidato_id',
                    'detalles.tipo_movimiento', 'detalles.observaciones_titular',
                    'detalles.fecha_cita', 'detalles.hora_cita', 'detalles.lugar_cita',
                    'candidatos.nombre_candidato', 'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato',
                    'candidatos.rfc', 'candidatos.candidato_id')
                ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
                ->where('detalles.aceptacion_srio', 'VALIDADO')
                ->get();

            // Se recorre para validar si ya fue Validado por el SRIO
            foreach ($seleccionCandidato as $key => $selecCan) {
                $fechaAsiganda += isset($selecCan->fecha_cita) ? 1 : 0 ;
            }

            return view('p11_seleccion_candidatos.T02_asignacionFechaPsicometricos',
                    compact('usuario', 'candidatoEstructura', 'seleccionCandidato', 'fechaAsiganda') );
        }

    }

    public function datosDelCandidato ( $seleccionCandidatoId, $CandidatoId )
    {

        $candidatos = Candidato::where([
                [
                        'candidato_id',
                        '=',
                        $CandidatoId
                ]
        ])->first();
        return response()->json($candidatos);

    }

    // T02 del P11 Guarda los datos del Formulario para Asignar fecha de Examen del Candidato
    public function guardarFechaExamen ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T02');

        // Usamos el método del Trait para guardar la información
        $fechaGuardada = $this->guardarFechas($request, $candidatoEstructura);

        // Si se guardo correctamente la fecha, se crea la T03 y continua el Proceso
        if ( $fechaGuardada['estatus'] ) {
            // Actualizamos el estatus de la tarea actual
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            // Creamos la notificación de aviso al INI_CAND de que fecha se asigno al Candidato
            $instancia->crearInstanciaTarea('TNOTA01', 'NOTIFICACION_NO_LEIDO');
            // Creamos la nueva tarea
            $instancia->crearInstanciaTarea('T03', 'NUEVO');
            // Despues del guardado, se manda la respuesta
            $respuesta = [ 'estatus' => true, 'msj' => '¡La fecha fue asignada exitosamente!' ];
            return response()->json($respuesta);
        } else {
            // Si hubo algún error, se manda la respuesta
            $respuesta = [ 'estatus' => false, 'msj' => '¡Ocurrió un error, la fecha no fue asiganda, intente más tarde!' ];
            return response()->json($respuesta);
        }

    }

    public function vistaNotificacionFechaCita ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')->join('p11_detalles as detalles',
                'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'detalles.fecha_cita',
                'detalles.hora_cita', 'detalles.lugar_cita')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'VALIDADO')
            ->get();
        return view('p11_seleccion_candidatos.TNOTA01', compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    public function guardarNotificacionExamen ( SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('TNOTA01');
        $this->actualizarEstatusTarea($instanciaTarea, 'LEIDO');
        return redirect()->route('tareas');

    }

    public function guardarNotificacionRechazoCandidatosGuardar ( SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('TANOTA02');
        $this->actualizarEstatusTarea($instanciaTarea, 'LEIDO');
        return redirect()->route('tareas');

    }

    public function guardarNotificacionRechazoCandidatosGuardarSrios (
            SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('TANOTA03');
        $this->actualizarEstatusTarea($instanciaTarea, 'LEIDO');
        return redirect()->route('tareas');

    }

    public function guardarNotificacionRechazoValidaciones ( SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('TANOTA04');
        $this->actualizarEstatusTarea($instanciaTarea, 'LEIDO');
        return redirect()->route('tareas');

    }

    public function vistaNotificacionRechazoCandidatos ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')->join('p11_detalles as detalles',
                'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'detalles.fecha_cita',
                'detalles.hora_cita', 'detalles.lugar_cita')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'RECHAZADO')
            ->get();
        return view('p11_seleccion_candidatos.TNOTA02', compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    public function vistaNotificacionRechazoCandidatosSrios ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')
            ->join('p11_detalles as detalles','seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'detalles.fecha_cita',
                'detalles.hora_cita', 'detalles.lugar_cita')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'RECHAZADO')
            ->get();
        return view('p11_seleccion_candidatos.TNOTA03', compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    public function vistaNotificacionRechazoValidaciones ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')->join('p11_detalles as detalles',
                'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'detalles.fecha_cita',
                'detalles.hora_cita', 'detalles.lugar_cita')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'RECHAZADO')
            ->get();
        return view('p11_seleccion_candidatos.TNOTA04', compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    // T03 del P11 muestra el Formulario para Capturar Resultados del Candidato
    public function vistaCapturaResultados ( SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $usuario = Auth::user();

        $seleccionCandidato = DB::table('p11_seleccion_candidatos as seleccion')
            ->join('p11_detalles as detalles', 'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.*',
                'detalles.*',
                'candidatos.*')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'VALIDADO')
            ->first();

        $seleccionCandidato->plaza = $candidatoEstructura->plaza;
        $seleccionCandidato->unidad = $candidatoEstructura->plaza->plazaUnidad->nombre_unidad;


        /*
        if ( $seleccionCandidato != "" && $seleccionCandidato != null ) {
            foreach ( $seleccionCandidato as $candidato ) {
                $candidato->plaza = $candidatoEstructura->plaza;
                $candidato->unidad = $candidatoEstructura->plaza->plazaUnidad->nombre_unidad;
            }
        } */
        // dd($seleccionCandidato);
        dd('Me quede aquí, ya reestructure la consulta para mostrar la tabla y cargar los datos en el Modal, Revisar esa parte, es la T03_capturaResultadosExamne');
        return view('p11_seleccion_candidatos.T03_capturaResultadosExamen', compact('candidatoEstructura', 'usuario', 'seleccionCandidato'));

    }

    public function guardarDatosEmpleados ( SeleccionCandidatoEstructura $candidatoEstructura, Request $request )
    {

        if ( $this->validarFormDatosEmpleadosT03($request) ) {
            $this->guardarDatos($request, $candidatoEstructura);
        }

    }

    public function guardarDatosEvaluacion ( SeleccionCandidatoEstructura $candidatoEstructura, Request $request )
    {

        $this->guardarDatosEvaluaciones($request, $candidatoEstructura);
        return $request->all();

    }

    public function guardarResultadosExamenEvaluacion ( Request $request,
            SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T03');
        if ( true ) {
            $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
            $instancia->crearInstanciaTarea('T04', 'NUEVO');
        }
        return redirect()->route('tareas');

    }

    public function vistaSeleccionCandidatoOcuparPlaza ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')->join('p11_detalles as detalles',
                'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'detalles.observaciones_titular',
                'detalles.aceptacion_eval')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'VALIDADO')
            ->get();
        return view('p11_seleccion_candidatos.T04_seleccionCandidatoOcuparPlaza',
                compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    public function vistaSeleccionCandidatosComentarios ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $candidatoSeleccionado = DetallesCandidato::where(
                [
                        [
                                'seleccion_candidato_id',
                                '=',
                                $candidatoEstructura->seleccion_candidato_id
                        ],
                        [
                                'aceptacion_titular',
                                '=',
                                'ACEPTADO'
                        ]
                ])->first();
        $usuarios = Auth::user();
        return view('p11_seleccion_candidatos.T05_seleccionCandidatosComentariosPlaza',
                compact('candidatoEstructura', 'usuarios', 'candidatoSeleccionado'));

    }

    public function vistaSeleccionCandidatosAutorizaciones ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $candidatoSeleccionado = DetallesCandidato::where(
                [
                        [
                                'seleccion_candidato_id',
                                '=',
                                $candidatoEstructura->seleccion_candidato_id
                        ],
                        [
                                'aceptacion_titular',
                                '=',
                                'ACEPTADO'
                        ]
                ])->first();
        $usuarios = Auth::user();
        return view('p11_seleccion_candidatos.T06_seleccionCandidatosAutorizaciones',
                compact('candidatoEstructura', 'usuarios', 'seleccion', 'candidatoSeleccionado'));

    }

    public function vistaSeleccionCandidatosFechaIngresos1 ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $candidatoSeleccionado = DetallesCandidato::where(
                [
                        [
                                'seleccion_candidato_id',
                                '=',
                                $candidatoEstructura->seleccion_candidato_id
                        ],
                        [
                                'aceptacion_titular',
                                '=',
                                'ACEPTADO'
                        ]
                ])->first();
        $usuarios = Auth::user();
        return view('p11_seleccion_candidatos.T07_seleccionCandidatosFechaIngresos',
                compact('candidatoEstructura', 'usuarios', 'seleccion', 'candidatoSeleccionado'));

    }

    public function vistaSeleccionGeneracionNumeroValidacion ( $seleccionCandidatoId )
    {

        $candidatoEstructura = SeleccionCandidatoEstructura::find($seleccionCandidatoId);
        $usuarios = Auth::user();
        $seleccion = DB::table('p11_seleccion_candidatos as seleccion')->join('p11_detalles as detalles',
                'seleccion.seleccion_candidato_id', '=', 'detalles.seleccion_candidato_id')
            ->join('p11_candidatos as candidatos', 'detalles.candidato_id', '=', 'candidatos.candidato_id')
            ->select('seleccion.created_at', 'detalles.tipo_movimiento', 'candidatos.nombre_candidato',
                'candidatos.apellido_paterno_candidato', 'candidatos.apellido_materno_candidato', 'candidatos.rfc',
                'seleccion.seleccion_candidato_id', 'candidatos.candidato_id', 'seleccion.aceptacion_srio',
                'detalles.fecha_alta')
            ->where('seleccion.seleccion_candidato_id', $candidatoEstructura->seleccion_candidato_id)
            ->where('detalles.aceptacion_srio', 'ACEPTADO')
            ->get();
        return view('p11_seleccion_candidatos.T08_generacionNumeroValidacion',
                compact('candidatoEstructura', 'usuarios', 'seleccion'));

    }

    public function guardarCandidatoPlazaOcupar ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $arrValidaciones = $this->validarFormCandidatosEmpleadosT04($request);
        $instanciaTarea = $instancia->getInstanciaTarea('T04');
        if ( $arrValidaciones[0] ) {
            $plazaOcupar = $this->guardarPlazaOcupar($request, $candidatoEstructura);
            if ( $plazaOcupar ) {
                $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
                $instancia->crearInstanciaTarea('T05', 'NUEVO');
                return redirect()->route('tareas')->with('mensaje', 'Se ha guardado correctamente');
            }
        }
        else {
            if ( count($arrValidaciones) > 3 ) {
                $arregloErrores = array_merge($arrValidaciones['mensajesForm0']->errors()->getmensajes(),
                        $arrValidaciones['mensajesForm1']->errors()->getmensajes());
                return redirect()->route('seleccion.candidatos.candidato.ocupar.plaza', $candidatoEstructura)->withErrors(
                        $arregloErrores);
            }
            else {
                $arregloErrores = $arrValidaciones['mensajesForm0'];
                return redirect()->route('seleccion.candidatos.candidato.ocupar.plaza', $candidatoEstructura)->withErrors(
                        $arregloErrores);
            }
        }

    }

    public function guardarComentariosDga ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {
//         dd($request);
        $instancia = $candidatoEstructura->instancia;
//         dd($instancia);
        $instanciaTarea = $instancia->getInstanciaTarea('T05');
//         dd($instanciaTarea);
        if ( $this->validarFormT05($request) ) {
            $comentarios = $this->guardarComentarios($request, $candidatoEstructura);
            if ( $comentarios ) {
                $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
                $instancia->crearInstanciaTarea('T06', 'NUEVO');
                return redirect()->route('tareas');
            }
        }

    }

    public function guardarAutorizaciones ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T06');
        // dd($request);
        if ( $this->validarFormT06($request) ) {
            $candidatos = $this->guardarAutorizacionCandidatos($request, $candidatoEstructura);
            if ( $candidatos[0] ) {
                $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
                if ( ! $candidatos[1] ) {
                    // dd($instancia);
                    $instancia->crearInstanciaTarea('T07', 'NUEVO');
                }
                return redirect()->route('tareas');
            }
            else {
                return redirect()->route('tareas');
            }
        }

    }

    public function guardarFechasIngresos ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura,
            DetallesCandidato $candidatoSeleccionado )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T07');
        if ( $this->validarFormT07($request) ) {
            $fechasIn = $this->guardarFechasIngresosIn($request, $candidatoSeleccionado);
            if ( $fechasIn ) {
                $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
                $instancia->crearInstanciaTarea('T08', 'NUEVO');
                return redirect()->route('tareas');
            }
        }

    }

    public function guardarNumeroValidacion ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $instancia = $candidatoEstructura->instancia;
        $instanciaTarea = $instancia->getInstanciaTarea('T08');
        $this->actualizarEstatusTarea($instanciaTarea, 'COMPLETADO');
        return redirect()->route('tareas')->with('mensaje', 'Se ha guardado correctamente');

    }

    // Metodo encargado de consultar por RFC y No. Empleado los datos en la DB o Usa el Servicio. Es parte de la T01
    public function consultaDatosEmpleados ( Request $request )
    {

        try {
            // Instancia la clase para usar el Servicio para consultar empleados
            $servicios = new ServicioController();
            // Consulta la BD
            $candidato = DB::table('p11_candidatos')->where('rfc', '=', $request->rfc)->where('no_empleado', '=', $request->numero_empleado)->first();
            // Verificamos de donde viene la respuesta
            $seBuscoEn = '';
            if ( $candidato ) {
                // Si existe candidato en la DB convierte de objeto a array para la validación
                $candidato =  (array) $candidato;
                $seBuscoEn = 'db';
            } else {
                // Si no hay candidato con esos datos en la BD, entonces consume el servicio
                $candidato = $servicios->getDatosEmpleado($request);
                $seBuscoEn = 'ws';
                // La respuesta del servicio se obtiene el json y se convierte en array para validar la información
                $candidato = json_decode($candidato->content(), true);
            }

            // Si NO encontro información manda en la BD y el Servicio Regresa un Error responde esto
            if ( $candidato == null || isset($candidato['error']) ) {
                $respuesta = ['estatus'=> false, 'data' => null , 'msj' => 'No se encontro información, capture manualmente'];
            } else {
                // Antes de regresarlo lo convertimos a Objeto nuevamente
                $candidato = (object) $candidato;
                $respuesta = ['estatus'=> true, 'data' => $candidato, 'msj' => 'Información Encontrada', 'dondeSebusco' => $seBuscoEn];
            }

            return response()->json($respuesta);

        } catch (\Throwable $th) {

            $respuesta = ['estatus'=> false, 'data' => $th , 'msj' => 'Ocurrió un problema, intente más tarde'];
            return response()->json($respuesta);
        }

    }
}
