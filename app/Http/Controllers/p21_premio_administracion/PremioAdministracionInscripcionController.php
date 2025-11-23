<?php

namespace App\Http\Controllers\p21_premio_administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\Models\p21_premio_administracion\PremioAdministracion;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Http\Controllers\p21_premio_administracion\ManejadorTareasInscripcion;
use Illuminate\Support\Facades\Auth;
use App\Models\InstanciaTarea;

class PremioAdministracionInscripcionController extends Controller
{
    use ManejadorTareasInscripcion;

    public function descripcion(){
        return view('p21_premio_administracion.p21_premio_administracion_inscripcion.tareas.descripcion');
    }

    public function inicializarProceso(Request $request){

        try {
            $existeProceso = PremioAdministracion::where('estatus', 'EN_PROCESO')
                                ->where('area_id', Auth::user()->area->area_id)
                                ->orWhere('creado_por', Auth::user()->id)
                                ->exists();

            if (!$existeProceso) {
                return redirect()->back()->with("error", "¡No hay ninguna convocatoria abierta para esta área!");
            } else {

                DB::beginTransaction();
                // Validar esta manera de obtener el último proceso
                $premioAdmin = PremioAdministracion::where('estatus', 'EN_PROCESO')
                                ->where('area_id', Auth::user()->area->area_id)
                                ->orWhere('creado_por', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->first();

                // Validar si ya se inicio la inscripción
                $existeInscripcion = $premioAdmin->inscripcion;
                if ( $existeInscripcion ) {
                    return redirect()->back()->with("error", "¡Ya esta iniciado la inscripción para el premio con folio " . $premioAdmin->folio .  "!");
                }

                $instanciasTareasPremio = $premioAdmin->instancia->instanciasTareas;

                foreach ($instanciasTareasPremio as $key => $instanciasTareasPremio) {
                    if ($instanciasTareasPremio->estatus == "NUEVO" && $instanciasTareasPremio->tarea->identificador == 'TPA01') {
                        return redirect()->back()->with("error", "¡La convocatoria ya fue abierta, pero no ha sido completada en su totalidad, por lo que aún no es posible inscribir a ningún empleado!");
                    } else if ($instanciasTareasPremio->estatus == "COMPLETADO" && $instanciasTareasPremio->tarea->identificador == 'TPA02' ) {
                        return redirect()->back()->with("error", "¡La convocatoria ha sido cerrada, por lo que ya no es posible inscribir a ningún empleado!");
                    }
                }

                $inscripcion = P21Inscripcion::create([
                    'estatus' => 'EN_PROCESO',
                    'p21_premio_id' => $premioAdmin->p21_premio_id,
                    'area_id' => $premioAdmin->area_id,
                    'area_creadora_id' => Auth::user()->area->area_id,
                    'creado_por' => Auth::user()->id,
                    'creado_por_area' => Auth::user()->area->identificador,
                    'creado_por_area_nombre' => Auth::user()->area->nombre,
                    'creado_por_titulo' => Auth::user()->puesto
                ]);

                $instancia = $this->crearInstancia('premio_administracion_inscripcion', $inscripcion, $premioAdmin->area);
                $instanciaTarea = $instancia->crearInstanciaTarea('TPAI01', 'NUEVO');
                DB::commit();

                // Termina, redirige y envía mensaje de finalización de la tarea.
                $mensaje = '¡Se ha iniciado correctamente el proceso!';
                return redirect()->route('tareas')->with('success', $mensaje);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with("error", "¡Ocurrio un error, intente de nuevo más tarde!");
        }

    }

    public function fecha(){
        $meses=array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio",
            "08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
        $nuevaFecha = Carbon::now();
        $cadenaFecha= $nuevaFecha->format('d') . ' de ' . $meses[$nuevaFecha->format('m')] . ' de ' . $nuevaFecha->format('Y');

        return $cadenaFecha;
    }

    public function busquedaGeneracionFormatos(Request $request, P21Inscripcion $inscripcion, InstanciaTarea $instanciaTarea){

        $instancia =  $inscripcion->instancia;
        $usuario = Auth::user();
        $datosPremio = $inscripcion->premioAdministracion;

        if ($request->isMethod('post')) {
            if ($request->tipo == "guardarConvocatoria") {

                if ($datosPremio->fecha_cierre_convocatoria == null) {

                    if ($this->guardarTareaT01($inscripcion, $datosPremio)) {

                        return response()->json([ "estatus" => true, "mensaje" => "Información guardada correctamente, puede continuar con la tarea", "fecha_convocatoria" => $datosPremio->anio_convocatoria, "comentario_admin" => $datosPremio->comentarios_admin_pa_21, "fecha_inicio" => $datosPremio->fecha_inicio_evaluacion_pa, "fecha_fin" => $datosPremio->fecha_fin_evaluacion_pa ]);

                    }else {
                        return response()->json([ "estatus" => false, "fallo_por" => 'error', "mensaje" => 'Ocurrio un error, intente de nuevo más tarde.']);
                    }

                } else {
                    return response()->json([ "estatus" => false, "fallo_por" => 'cerrada', "title" => 'La convocatoria a la que intenta inscribir al empleado ha sido cerrada.', "mensaje" => 'Puede inscribirlo en alguna otra si existe o bien puede cancelar el proceso']);
                }
            } else if ($request->tipo == "finalizarTarea") {

                try {
                    if ($datosPremio->fecha_cierre_convocatoria == null) {

                        $datos_empleado = json_decode($request->datos_empleado);

                        $existeEmpleado = $datosPremio->candidatosPremio->where('numero_empleado', $datos_empleado->numero_empleado);

                        if (count($existeEmpleado) == 0) {
                            $guardo = $this->guardarTareaT01Finalizar($inscripcion, $request, $datos_empleado);
                            if ( $guardo['estatus'] ) {

                                $instanciaTarea->updateEstatus('COMPLETADO');
                                $regresa = $instancia->crearInstanciaTarea('TPAI02', 'NUEVO');

                                $key = "ruta";
                                $valor = route('inscripcion.premio.administracion.captura.evaluacion.cursos', [$inscripcion, $regresa->instancia_tarea_id ] );

                                $guardo[$key] = $valor;

                                return response()->json($guardo);
                            }else {
                                return response()->json($guardo);
                            }
                        }else{
                            return response()->json([ "estatus" => false, "mensaje" => "El empleado que intenta registrar ya ha sido registrado previamente en esta convocatoria"]);
                        }

                    } else {
                        return response()->json([ "estatus" => false,  "mensaje" => 'La convocatoria ya fue cerrada, por lo que ya no es posible agregar a ningún empleado. Por favor, cancele este proceso.']);
                    }
                } catch (\Throwable $th) {

                    return response()->json([ "estatus" => false, "mensaje" => "Error: " . $th]);
                }
            }
        }
        return view('p21_premio_administracion.p21_premio_administracion_inscripcion.tareas.T01_busquedaGeneracionFormatos', compact('inscripcion', 'instanciaTarea', 'instancia', 'datosPremio'));
    }

    public function validarEmpleadoInscripcion(Request $request){

        try {

            $empleado = json_decode($request->datos_empleado);
            return response()->json([ "estatus" => true, "empleado" => $empleado ]);

        } catch (\Throwable $th) {
            return response()->json([ "estatus" => false, "mensaje" => $th ]);
        }
    }

    public function cancelarProceso(Request $request){

        $cancelar_todo = $this->cancelarTodo($request);

        if ($cancelar_todo) {

            return response()->json([ "estatus" => true, "mensaje" => 'Proceso cancelado correctamente.' , "ruta" => route('tareas') ]);

        } else {
            return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error, intente de nuevo más tarde.']);
        }

    }

    public function descargarPropuestaCandidato($rfc){

        $datosEmpleado = DB::table('empleados')->where('rfc', $rfc)->first();
        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.p21_premio_administracion_inscripcion.formatos.pdf_propuesta_candidato', compact('cadenaFecha', 'datosEmpleado') )
                            ->download('Propuesta-Candidato-'.$rfc.'.pdf');
    }

    public function descargarCedulaDesempeno($rfc){

        $datosEmpleado = DB::table('empleados')->where('rfc', $rfc)->first();
        $cadenaFecha = $this->fecha();
        return $pdf = \PDF::loadView('p21_premio_administracion.p21_premio_administracion_inscripcion.formatos.pdf_cedula_desempeno', compact('cadenaFecha', 'datosEmpleado') )
                            ->download('Cedula-Desempeno-'.$rfc.'.pdf');
    }

    public function descargarCedulaCursos($rfc){

        $datosEmpleado = DB::table('empleados')->where('rfc', $rfc)->first();
        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.p21_premio_administracion_inscripcion.formatos.pdf_cedula_cursos', compact('cadenaFecha', 'datosEmpleado') )
                            ->setPaper('a4', 'landscape') // Para que la hoja sea de forma horizontal
                            ->download('Cedula-Cursos-'.$rfc.'.pdf');
    }

    public function descargarControlPuntualidadAsistencia($rfc){

        $datosEmpleado = DB::table('empleados')->where('rfc', $rfc)->first();
        $cadenaFecha = $this->fecha();

        return $pdf = \PDF::loadView('p21_premio_administracion.p21_premio_administracion_inscripcion.formatos.pdf_control_puntualidad_asistencia', compact('cadenaFecha', 'datosEmpleado') )
                            ->setPaper('a4', 'landscape') // Para que la hoja sea de forma horizontal
                            ->download('Control-Puntualidad-Asistencia-'.$rfc.'.pdf');
    }

    public function capturaEvaluacionCursos(P21Inscripcion $inscripcion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $inscripcion->instancia;
        $datosPremio = $inscripcion->premioAdministracion;

        $tipoNombramiento = ["BASE", "LISTA DE RAYA / BASE", "TECNICO OPERATIVO" ];
        $propuestoPor = ["SUPERIOR JERARQUICO", "AUTO PROPUESTA", "COMPAÑEROS DE LABORES"];
        $evaluaciones = ["E" => "EXCELENTE", "MB" => "MUY BIEN", "B" => "BIEN", "R" => "REGULAR", "D" => "DEFICIENTE"];
        $aplicacionDiaria = ["10%", "20%", "30%", "40%", "50%", "60%", "70%", "80%", "90%", "100%"];

        if ($request->isMethod('post')) {
            try {
                $finalizado = $this->guardarTareaT02Finalizar($inscripcion, $request);
                if ($finalizado['estatus']) {
                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('TPAI03', 'NUEVO');
                    // Termina, redirige y envía mensaje de finalización de la tarea.
                    $mensaje = '¡Se ha finalizado correctamente la tarea!';
                    return redirect()->route('tareas')->with('success', $mensaje);
                }else {
                    return redirect()->back()->with("error", "¡Ocurrio un error al guardar información, intente de nuevo más tarde!");
                }
            } catch (\Throwable $th) {
                return redirect()->back()->with("error", "¡Ocurrio un error, intente de nuevo más tarde!");
            }
        }
        return view('p21_premio_administracion.p21_premio_administracion_inscripcion.tareas.T02_capturaEvaluacionCursos', compact('inscripcion', 'instanciaTarea', 'instancia', 'tipoNombramiento', 'propuestoPor', 'evaluaciones', 'aplicacionDiaria', 'datosPremio'));
    }

    public function validacionCursos(P21Inscripcion $inscripcion, Request $request, InstanciaTarea $instanciaTarea){

        $instancia =  $inscripcion->instancia;

        $cursos_empleado = json_decode( $inscripcion->json_cursos);
        $estadosValidacion = ["VALIDO", "NO VALIDO"];
        $user = Auth::user();

        $datosPremio = $inscripcion->premioAdministracion;
        $instanciaPremio = $datosPremio->instancia;
        $instanciasTareasPremio = $instanciaPremio->instanciasTareas;


        // Validar si ya finalizo la T02 del Premio
        foreach ($instanciasTareasPremio as $key => $instanciaTareaPremio) {
            if ( $instanciaTareaPremio->tarea->identificador == 'TPA02' && $instanciaTareaPremio->estatus == 'NUEVO' ) {
                $mensaje = 'La convocatoria sigue abierta, por lo que aún no es posible ingresar a esta tarea';
                return redirect()->route('tareas')->with('error', $mensaje);
            }
        }

        if ($request->isMethod('post')) {

            try {

                if ($cursos_empleado != null) {

                    foreach ($cursos_empleado as $key => $value) {
                        $value->estado = $request->estado_curso[$key];
                        $value->comentario = $request->com_oper_cap[$key];
                    }

                    $guardo = $this->guardarTareaT03FinalizarConCursos($inscripcion, $request, $cursos_empleado);

                    if ( $guardo['estatus'] ) {
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        $inscripcion->estatus = "COMPLETADO";
                        $inscripcion->save();

                        $mensaje = '¡El candidato ha quedado inscrito exitosamente. Ha finalizado el proceso de manera satisfactoria!';
                        return redirect()->route('tareas')->with('success', $mensaje);
                    } else {
                        return redirect()->back()->with("error", "¡Error al guardar información, intente más tarde!");
                    }

                } else {

                    $guardo = $this->guardarTareaT03FinalizarSinCursos($inscripcion, $request);

                    if ( $guardo['estatus'] ) {
                        $instanciaTarea->updateEstatus('COMPLETADO');
                        $inscripcion->estatus = "COMPLETADO";
                        $inscripcion->save();

                        $mensaje = '¡Ha finalizado el proceso de manera satisfactoria!';
                        return redirect()->route('tareas')->with('success', $mensaje);
                    } else {
                        return redirect()->back()->with("error", "¡Error al guardar información, intente más tarde!");
                    }
                }
            } catch (\Throwable $th) {
                return redirect()->back()->with("error", "¡Ocurrió un error, intente más tarde!");
            }
        }

        return view('p21_premio_administracion.p21_premio_administracion_inscripcion.tareas.T03_validacionCursos', compact('inscripcion', 'instanciaTarea', 'cursos_empleado', 'estadosValidacion', 'datosPremio'));
    }
}
