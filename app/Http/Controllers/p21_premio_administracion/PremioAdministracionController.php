<?php

namespace App\Http\Controllers\p21_premio_administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\Models\p21_premio_administracion\PremioAdministracion;
use App\Http\Controllers\p21_premio_administracion\ManejadorTareas;
use Illuminate\Support\Facades\Auth;
use App\Models\InstanciaTarea;
use App\Models\Instancia;
use Illuminate\Support\Facades\Response;
use App\Models\Area;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Models\p21_premio_administracion\P21CandidatosPremio;
use App\Http\Controllers\p24_directorio\DirectorioController;
use App\Models\User;
use App\Http\Servicios\Empleado;

use function GuzzleHttp\Promise\all;

class PremioAdministracionController extends Controller
{
    use ManejadorTareas;
    use Empleado;

    public function descripcion(){
        return view('p21_premio_administracion.tareas.descripcion');
    }

    public function fecha(){
        $meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
            "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
        $nuevaFecha = Carbon::now();
        $cadenaFecha= $nuevaFecha->format('d') . ' de ' . $meses[$nuevaFecha->format('m')] . ' de ' . $nuevaFecha->format('Y');

        return $cadenaFecha;
    }

    public function inicializarProceso(Request $request){
        // Crear registro del Premio
        $premioAdministracion = PremioAdministracion::create([
            'estatus' => 'EN_PROCESO',
            'area_creadora_id' => Auth::user()->area->area_id,
            'creado_por' => Auth::user()->id,
            'creado_por_area' => Auth::user()->area->identificador,
            'creado_por_area_nombre' => Auth::user()->area->nombre,
            'creado_por_titulo' => Auth::user()->puesto
        ]);
        $instancia = $this->crearInstancia('premio_administracion', $premioAdministracion,  Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea('TPA01', 'NUEVO');
        $mensaje = 'Se ha iniciado correctamente el proceso, será dirigido a la primer tarea';
        return redirect()
                ->route('premio.administracion.inicio.convocatoria', [$premioAdministracion, $instanciaTarea])
                ->with("success", $mensaje);
    }

    public function inicioConvocatoria(PremioAdministracion $premioAdministracion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $premioAdministracion->instancia;

        $areas = Area::Activo()->where('area_principal_id', null)->get();
        // Obtén las áreas que tienen el rol OPER_PA_21
        $areasQueParticipan = Area::where('activo', true)
            ->where('area_principal_id', null)
            ->whereHas('users', function ($query) {
                $query->where('activo', true)
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('name', ['OPER_PA_21']);
                    });
            })
            ->get();

        $user = Auth::user();

        $meses=array("1"=>"ENERO","2"=>"FEBRERO","3"=>"MARZO","4"=>"ABRIL","5"=>"MAYO","6"=>"JUNIO","7"=>"JULIO", "8"=>"AGOSTO","9"=>"SEPTIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");

        $fechasConvocatorias = [];
        $fechasOcupadas = PremioAdministracion::select('anio_convocatoria')->get();

        $date = Carbon::now();
        $ghjg = [];

        for ( $i=1; $i<=$date->format('m'); $i++) {
            $fechasConvocatorias [] =   $meses[($i)] . ' ' . $date->format('Y') ;
        }

        foreach ($fechasOcupadas as $value) {
            $ghjg [] =  $value->anio_convocatoria;
        }

        $fechasDisponibles = array_diff($fechasConvocatorias, $ghjg);

        if ($request->isMethod('post')) {
            try {

                // Validamos si ya existe un premio en curso para esta area
                $existePremioArea = PremioAdministracion::where('estatus', 'EN_PROCESO')->where('area_id', $request->area_id)->exists();
                if (!$existePremioArea)
                {
                    // Validamos en mes elegido
                    $existeMesElegido = PremioAdministracion::where('estatus', 'EN_PROCESO')->where('anio_convocatoria', $request->fecha_convocatoria)->where('area_id', $request->area_id)->exists();
                    if (!$existeMesElegido)
                    {
                        $user = Auth::user();
                        $paraElArea = Area::where('area_id', $request->area_id)->first();

                        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio);
                        $fecha_fin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin);

                        $diferenciaEnAños = $fecha_inicio->diffInYears($fecha_fin);

                        if ( $diferenciaEnAños === 1 ) {

                            $guardo = $this->guardarTareaTPA01($premioAdministracion, $request, $paraElArea);

                            if ( $guardo['estatus'] ) {
                                $instanciaTarea->updateEstatus('COMPLETADO');
                                $instancia->crearInstanciaTarea('TPA02', 'NUEVO');
                                $this->crearNotificacionArea($instancia, $paraElArea, 'TNOTA01');
                                // Termina, redirige y envía mensaje de finalización de la tarea.
                                $mensaje = '¡La tarea finalizó correctamente!';
                                return redirect()->route('tareas')->with('success', $mensaje);
                            } else {
                                return redirect()->back()->with("error", "¡Ocurrió un error al guardar la información, intente más tarde!");
                            }

                        }
                        else
                        {
                            return redirect()->back()->with("error", "Las fechas proporcionadas no cubren un periodo de 12 meses completos.");
                        }
                    }
                    else
                    {
                        return redirect()->back()->with("error", "Ya existe un trámite para esta fecha para esta área .");
                    }
                }
                else
                {
                    return redirect()->back()->with("error", "El área seleccionada ya tiene un trámite en curso.");
                }

            } catch (\Throwable $th) {
                return redirect()->back()->with("error", "¡Ocurrió un error, intente más tarde!");
            }
        }

        return view('p21_premio_administracion.tareas.TPA01_inicioConvocatoria', compact('premioAdministracion', 'instanciaTarea' , 'areasQueParticipan', 'fechasDisponibles'));
    }

    public function calcularFechaFin(Request $request){
        try {

            $date = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio);
            $fin = $date->addYear();
            $final = $fin->format('Y-m-d');

            return response()->json([ "estatus" => true, "fecha_fin" => $final]);

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => 'Error al calcular la fecha fin de manera automatica, por favor, ingresela manualmente.' ]);
        }
    }

    public function eliminacionSolicitudes(PremioAdministracion $premioAdministracion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $premioAdministracion->instancia;
        $inscripcionExiste = $premioAdministracion->inscripcion;

        $candidatos = P21Inscripcion::where('activo', true)->where('p21_premio_id', $premioAdministracion->p21_premio_id)->whereNotNull('numero_empleado')->get();

        foreach ($candidatos as $candidato) {
            $cpre  = P21CandidatosPremio::select('estatus_declinacion', 'comentarios_declinacion')->where('p21_inscripcion_id', $candidato->p21_inscripcion_id)->where('activo', true)->first();
            $cpre = json_decode( $cpre );
            $candidato->candiPremio = $cpre;
        }

        $opcionesEstado  = ["SOLICITADO" => "SOLICITADO", "DECLINADO" => "DECLINADO"];

        if ($request->isMethod('post')) {
            try {
                $this->cierreConvocatoria($premioAdministracion);
                $instanciaTarea->updateEstatus('COMPLETADO');
                $instancia->crearInstanciaTarea('TPA03', 'NUEVO');

                // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = '¡La tarea finalizó correctamente!';
                return redirect()->route('tareas')->with('success', $mensaje);
            } catch (\Throwable $th) {
                return redirect()->back()->with("error", "¡Ocurrió un error, intente más tarde!");
            }
        }

        return view('p21_premio_administracion.tareas.TPA02_eliminacionSolicitudes', compact('premioAdministracion', 'instanciaTarea', 'candidatos', 'opcionesEstado', 'inscripcionExiste' ));
    }

    public function guardarAvanceEliminacionSolicitudes(PremioAdministracion $premioAdministracion, Request $request) {
        if( $this->guardarDatosEstado($premioAdministracion, $request) ) {
            return response()->json([ "estatus" => true, "mensaje" => 'Información guardada correctamente', "premio" => $premioAdministracion->p21_premio_id ]);
        }else{
            return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error, por favor intente de nuevo más tarde']);
        }
    }

    public function descargarListaCandidatos($premio_id){

        $datosPremio = PremioAdministracion::where('p21_premio_id', $premio_id)->first();
        $empleados = $datosPremio->candidatosPremio;

        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_lista_candidatos', compact('cadenaFecha', 'empleados', 'datosPremio') )
                            ->download('Lista-candidatos-premio-'.$premio_id.'.pdf');
    }

    public function asignacionPremios(PremioAdministracion $premioAdministracion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $premioAdministracion->instancia;

        $candidatos = P21CandidatosPremio::where('activo', true)->where('p21_premio_id', $premioAdministracion->p21_premio_id)->orderBy('puntaje_total_inicial', 'desc')->get();
        $tipoNombramiento = ["BASE", "CONFIANZA", "LISTA DE RAYA/BASE" ];
        $puntajes = [ "10","20","30","40","50","60","70","80","90","100" ];
        $premios = [ "ESTÍMULO", "RECOMPENSA", "AMBOS", "NINGUNO" ];

        $inscripcion = $premioAdministracion->inscripcion;

        if (!$inscripcion) {
            $mensaje = 'No han iniciado procesos de inscripcion, por lo que aún no es posible ingresar a esta tarea';
            return redirect()->route('tareas')->with('error', $mensaje);
        }

        $instanciaInscripcion = $inscripcion->instancia;
        $instanciasTareasInscripcion = $instanciaInscripcion->instanciasTareas;

        foreach ($instanciasTareasInscripcion as $key => $instanciaTareaInscripcion) {
            if ($instanciaTareaInscripcion->estatus == 'NUEVO') {
                $mensaje = 'Existen procesos de inscripcion que no han finalizados, por lo que aún no es posible ingresar a esta tarea';
                return redirect()->route('tareas')->with('error', $mensaje);
            }
        }

        if ($request->isMethod('post')) {

            $user = Auth::user();
            if ( $request->tipo_fin == 'continuar_tarea' ) {

                try {
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('TPA04', 'NUEVO');
                    // Termina, redirige y envía mensaje de finalización de la tarea.
                    $mensaje = '¡La tarea finalizó correctamente!';
                    return redirect()->route('tareas')->with('success', $mensaje);
                } catch (\Throwable $th) {
                    return redirect()->back()->with("error", "¡Ocurrió un error al guardar la información, intente más tarde!");
                }

            } else if ( $request->tipo_fin == 'cancelar_tarea' ) {

                if ($this->finalizarProcesoConvocatoria($premioAdministracion, $instanciaTarea, $request)) {
                    // Termina, redirige y envía mensaje de finalización de la tarea.
                    $mensaje = '¡Proceso se cancelo correctamente!';
                    return redirect()->route('tareas')->with('success', $mensaje);
                } else {
                    return redirect()->back()->with("error", "¡Ocurrió un error al cancelar el proceso, intente más tarde!");
                }

            } else if ( $request->tipo_fin == 'finalizar_tarea' ) {

                if ( $this->finalizarProceso($premioAdministracion) ) {
                    $paraElArea = $premioAdministracion->area;
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('TNOTA02', 'NOTIFICACION_NO_LEIDO');  // Para el area creadora
                    $this->crearNotificacionArea($instancia, $paraElArea, 'TNOTA02');   // Para la unidad que se creo la convocatoria
                    // Termina, redirige y envía mensaje de finalización de la tarea.
                    $mensaje = '¡Proceso finalizo correctamente!';
                    return redirect()->route('tareas')->with('success', $mensaje);
                } else {
                    return redirect()->back()->with("error", "¡Ocurrió un error al finalizar el proceso, intente más tarde!");
                }

            }

        }

        return view('p21_premio_administracion.tareas.TPA03_asignacionPremios', compact('premioAdministracion', 'instanciaTarea', 'candidatos', 'tipoNombramiento', 'puntajes', 'premios'));

    }

    public function asignacionPremiosGuardarCandidatos(PremioAdministracion $premioAdministracion, Request $request) {
        if($this->guardarPuntajePremio($premioAdministracion, $request)){
            return response()->json([ "estatus" => true, "mensaje" => 'Información guardada correctamente' ]);
        }else{
            return response()->json([ "estatus" => false, "mensaje" => 'Error al guardar el puntaje y premio.']);
        }
    }

    public function asignacionPremiosGuardarNuevoCandidato(PremioAdministracion $premioAdministracion, Request $request) {
        $empledoExiste = P21CandidatosPremio::where('p21_premio_id', $premioAdministracion->p21_premio_id)->where('numero_empleado', $request['datosTabla'][0]['numero_empleado'])->exists();
        if (!$empledoExiste) {
            $guardo = $this->guardarNuevoCandidatoConvocatoria($premioAdministracion, $request);
            if ( $guardo['estatus'] ) {
                return response()->json($guardo);
            }else {
                return response()->json($guardo);
            }
        }else{
            return response()->json([ "estatus" => false, "mensaje" => "El empleado que intenta registrar ya ha sido registrado previamente en esta convocatoria."]);
        }
    }

    public function descargarCedulaDesempenoActualizada($rfc, $premio){

        $cadenaFecha = $this->fecha();
        $datosDesempenio = P21Inscripcion::where('p21_premio_id', $premio)->where('rfc', $rfc)->get();
        $datosDesempenioJson = json_decode( $datosDesempenio[0]->json_desempenio);

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_cedula_desempeno_actualizada', compact('cadenaFecha', 'datosDesempenioJson', 'datosDesempenio') )
                            ->download('Cedula-Desempeno-'.$rfc.'.pdf');
    }

    public function descargarCedulaCursosActualizada($rfc, $premio_id){

        $cadenaFecha = $this->fecha();
        $datosCursos = P21Inscripcion::where('p21_premio_id', $premio_id)->where('rfc', $rfc)->get();
        $datosCursosJson = json_decode( $datosCursos[0]->json_cursos);

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_cedula_cursos_actualizada', compact('cadenaFecha', 'datosCursosJson', 'datosCursos') )
                            ->download('Cedula-Cursos-'.$rfc.'.pdf');
    }

    public function descargarListadoCandidatosFinales($premio_id){

        $datosPremio = PremioAdministracion::where('p21_premio_id', $premio_id)->get();
        $empleados = P21CandidatosPremio::where('p21_premio_id', $premio_id)->orderBy('puntaje_total_inicial', 'desc')->get();
        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_listado_candidatos_finales', compact('cadenaFecha', 'empleados', 'datosPremio') )
                            ->download('Listado-candidatos-finales-premio-'.$premio_id.'.pdf');
    }

    public function recepcionInconformidades(PremioAdministracion $premioAdministracion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $premioAdministracion->instancia;

        $candidatos = P21CandidatosPremio::where('activo', true)->where('p21_premio_id', $premioAdministracion->p21_premio_id)->orderBy('puntaje_total_inicial', 'desc')->get();
        $opciones = ["ACEPTADO", "DECLINADO", "INCONFORMIDAD" ];

        if ($request->isMethod('post')) {

            if ( $this->guardarComite($premioAdministracion) ) {
                $instanciaTarea->updateEstatus('COMPLETADO');
                $instancia->crearInstanciaTarea('TPA03', 'NUEVO');
                // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = '¡La tarea finalizó correctamente!';
                return redirect()->route('tareas')->with('success', $mensaje);
            } else {
                return redirect()->back()->with("error", "¡Ocurrió un error al guardar la información, intente más tarde!");
            }

        }

        return view('p21_premio_administracion.tareas.TPA04_recepcionInconformidades', compact('premioAdministracion', 'instanciaTarea', 'candidatos', 'opciones' ));

    }

    public function descargarListadoCandidatosFinalesInconformidades($premio_id){

        $datosPremio = PremioAdministracion::where('p21_premio_id', $premio_id)->get();
        $empleados = P21CandidatosPremio::where('activo', true)->where('p21_premio_id', $premio_id)->orderBy('puntaje_total_inicial', 'desc')->get();
        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.formatos.pdf_listado_candidatos_finales_inconformidades', compact('cadenaFecha', 'empleados', 'datosPremio') )
                            ->download('Listado-candidatos-finales-inconformidades-premio-'.$premio_id.'.pdf');
    }

    public function validarEmpleadoConvocatoria(Request $request){

        try {

            $empleado = json_decode($request->datos_empleado);

            return response()->json([ "estatus" => true, "empleado" => $empleado ]);

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => $th ]);
        }
    }

    public function guardarRecepcionInconformidades(PremioAdministracion $premioAdministracion, Request $request) {
        if($this->guardarStatusComentario($premioAdministracion, $request)){
            return response()->json([ "estatus" => true, "mensaje" => 'Información guardada correctamente' ]);
        }else{
            return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error, por favor intente de nuevo más tarde']);
        }
    }

    // Notificaciones
    public function notificarInicioProceso(Request $request, PremioAdministracion $premioAdministracion, InstanciaTarea $instanciaTarea){
        $instancia = $premioAdministracion->instancia;
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

        return view('p21_premio_administracion.notificaciones.TNOTA01_notificacionInicioProceso', compact('premioAdministracion', 'instanciaTarea'));
    }

    public function notificarListadoFinalGanadores(Request $request, PremioAdministracion $premioAdministracion, InstanciaTarea $instanciaTarea){

        $instancia = $premioAdministracion->instancia;
        // Actualizar estatus a LEIDO
        if (!Auth::user()->hasRole("SUPER_ADMIN")) {
            $instanciaTarea->updateEstatus('NOTIFICACION_LEIDO');
        }

        if ($request->isMethod('post')) {
                $instanciaTarea->updateEstatus('NOTIFICACION_ELIMINADA');
                $mensaje = 'Notificación eliminada correctamente.';
                return redirect()->route('notificaciones')->with('success', $mensaje);
        }

        return view('p21_premio_administracion.notificaciones.TNOTA02_notificacionListadoFinalGanadores', compact('premioAdministracion', 'instanciaTarea'));
    }

}
