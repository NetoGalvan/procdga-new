<?php
namespace App\Http\Controllers\p07_pago_prestaciones;

use App\Http\Controllers\Controller;
use App\Models\p07_pago_prestaciones\PagoPrestacion;
use App\Models\p07_pago_prestaciones\SubProcesoPrestacion;
use App\Models\p07_pago_prestaciones\CandidatoPrestacion;
use App\Models\p07_pago_prestaciones\TipoPrestacion;
use App\Exports\p07_pago_prestaciones\NominaExport;
use App\Http\Traits\RegistroInstancias;
use App\Models\Area;
use App\Models\User;
use App\Models\InstanciaTarea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel as Excel;
use App\Models\p01_movimientos_personal\Sexo;

class PagoPrestacionController extends Controller
{
    use RegistroInstancias;
    use ManejadorTareas;

    public function descripcion() {
        return view('p07_pago_prestaciones.descripcion');
    }

    public function inicializarProceso() {
        $pagoPrestacion = PagoPrestacion::create([
            "estatus" => "EN_PROCESO"
        ]);
        $instancia = $this->crearInstancia("pago_prestaciones", $pagoPrestacion, Auth::user()->area);
        $instanciaTarea = $instancia->crearInstanciaTarea('CREAR_ESQUEMA_DE_DATOS', 'NUEVO');
        return redirect()->route('pago.prestacion.esquema.datos', [$pagoPrestacion, $instanciaTarea])
            ->with("success", "El proceso se creó correctamente.");
    }

    public function crearEsquemaDatos(Request $request, PagoPrestacion $pagoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $pagoPrestacion->instancia;
        $areasRH = Area::whereHas("users.roles", function($q) {
            $q->where("name", "JUD_RH");
        })
        ->get();
        if ($request->isMethod('post')) {
            $pagoPrestacion->fecha_limite = $request->fecha_limite;
            $pagoPrestacion->observaciones = $request->observaciones;
            $pagoPrestacion->tipo_prestacion_id = $request->tipo_prestacion_id;
            $pagoPrestacion->estructura_concurrente = $request->estructura_concurrente;
            $pagoPrestacion->save();
            foreach ($areasRH as $area) {
                $subproceso = new SubProcesoPrestacion();
                $subproceso->estatus = "EN_PROCESO";
                $subproceso->ultima_modificacion = now();
                $subproceso->fecha_limite = $pagoPrestacion->fecha_limite;
                $subproceso->pago_prestacion_id = $pagoPrestacion->pago_prestacion_id;
                $subproceso->tipo_prestacion_id = $pagoPrestacion->tipo_prestacion_id;
                $subproceso->estructura_concurrente = json_encode($pagoPrestacion->estructura_concurrente);
                $subproceso->save();

                $instanciaSubproceso = $this->crearInstancia("subproceso_pago_prestaciones", $subproceso, $area, $instancia);
                $instanciaSubproceso->crearInstanciaTarea('CAPTURA_CANDIDATOS', 'NUEVO', $area->area_id);
            }

            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea('ENVIAR_NOMINA_A_VALIDACION', 'NUEVO');
            return redirect('tareas')->with('success', 'Se ha guardado correctamente');
        }

        $tiposPrestaciones = TipoPrestacion::activo()->get();

        return view('p07_pago_prestaciones.T01_creacionEsquemaDatos', compact(
            'pagoPrestacion',
            'tiposPrestaciones',
            'areasRH',
            'instanciaTarea'
        ));
    }

    public function enviarAprobacion(Request $request, PagoPrestacion $pagoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $pagoPrestacion->instancia;
        if ($request->isMethod('post')) {
            // CANCELAR SUBPROCESOS QUE NO FUERON FINALIZADOS
            foreach ($pagoPrestacion->subprocesos as $key => $subproceso) {
                if ($subproceso->estatus == "EN_PROCESO") {
                    $subproceso->estatus = "CANCELADO";
                    $subproceso->save();
                    // Aqui mismo se eliminaran los candidatos asociados al subproceso que ya habían capturado, ya que no serán tomados en cuenta para el pago de la prestación
                    CandidatoPrestacion::where("subproceso_id", $subproceso->subproceso_id)->delete();
                    // Cancelar tareas
                    foreach ($subproceso->instancia->instanciasTareas as $key => $instanciaTareaSubproceso) {
                        if ($instanciaTareaSubproceso->estatus == "NUEVO" || $instanciaTareaSubproceso->estatus == "EN_CORRECCION") {
                            $instanciaTareaSubproceso->motivo_rechazo = "CANCELADO DESDE T02 POR NO FINALIZAR A TIEMPO";
                            $instanciaTareaSubproceso->save();
                            $instanciaTareaSubproceso->updateEstatus("CANCELADO");
                        }
                    }
                }
            }
            $instanciaTarea->updateEstatus("COMPLETADO");
            $instancia->crearInstanciaTarea("VALIDAR_NOMINA_UNIDADES_ADMINISTRATIVAS", "NUEVO");
            return redirect("tareas")->with("success", "La tarea finalizó correctamente.");
        }

        $subInstancias = $instancia->subInstancias;

        return view('p07_pago_prestaciones.T02_enviarAprobacion', compact(
            'instanciaTarea',
            'pagoPrestacion',
            'subInstancias'
        ));
    }

    // T03 Validar nómina de las unidades administrativas
    public function validarNominaUnidades(Request $request, PagoPrestacion $pagoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $pagoPrestacion->instancia;

        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea('APROBAR_NOMINA_UNIDADES_ADMINISTRATIVAS', 'NUEVO');
            return redirect('tareas')->with('success', 'La tarea ha finalizado correctamente');
        }

        $arrayCandidatos = collect();
        foreach ($pagoPrestacion->subprocesos()->where("estatus", "COMPLETADO")->get() as $key => $subproceso) {
            $candidatos = $subproceso
                ->candidatos()
                ->get();
            foreach ($candidatos as $key => $candidato) {
                $candidato->area;
                $candidato->usuarioCapturo;
                $candidato->usuarioAutorizo;
                $arrayCandidatos->add($candidato);
            }
        }

        return view('p07_pago_prestaciones.T03_validarNominaUnidades', compact(
            'pagoPrestacion',
            'instanciaTarea',
            'arrayCandidatos'
        ));
    }

    // T04 Aprobar nómina de las unidades administrativas
    public function aprobarNominaUnidades(Request $request, PagoPrestacion $pagoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $pagoPrestacion->instancia;

        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $instancia->crearInstanciaTarea('EXPORTAR_NOMINA', 'NUEVO');
            return redirect('tareas')->with('success', 'La tarea ha finalizado correctamente');
        }

        $arrayCandidatos = collect();
        foreach ($pagoPrestacion->subprocesos()->where("estatus", "COMPLETADO")->get() as $key => $subproceso) {
            $candidatos = $subproceso
                ->candidatos()
                ->get();
            foreach ($candidatos as $key => $candidato) {
                $candidato->area;
                $candidato->usuarioCapturo;
                $candidato->usuarioAutorizo;
                $arrayCandidatos->add($candidato);
            }
        }

        return view('p07_pago_prestaciones.T04_aprobarNominaUnidades', compact(
            'pagoPrestacion',
            'instanciaTarea',
            'arrayCandidatos'
        ));
    }

    // T05 Exportación de datos para creación de la nómina de prestaciones
    public function exportarNomina(Request $request, PagoPrestacion $pagoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $pagoPrestacion->instancia;

        if ($request->isMethod('post')) {
            $instanciaTarea->updateEstatus('COMPLETADO');
            $pagoPrestacion->updateEstatus('COMPLETADO');
            return redirect('tareas')->with('success', 'El proceso ha finalizado exitósamente');
        }

        return view('p07_pago_prestaciones.T05_exportarNomina', compact(
            'pagoPrestacion',
            'instanciaTarea'
        ));
    }

    // ST01 Subproceso
    public function capturarCandidatos(Request $request, SubProcesoPrestacion $subProcesoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $subProcesoPrestacion->instancia;

        $sexos = Sexo::where('activo', true)->get();

        if ($request->isMethod('post')) {
            // Si la tarea es nueva, creamos la tarea ST02
            if ($instanciaTarea->estatus == 'NUEVO') {
                $instancia->crearInstanciaTarea('APROBAR_CANDIDATOS', 'NUEVO');
            }
            // Si la tarea fue rechazada, buscamos la tarea ST02 y actualizamos su estatus a CORREGIDO
            else if ($instanciaTarea->estatus == 'EN_CORRECCION') {
                $instancia->crearInstanciaTarea('APROBAR_CANDIDATOS', 'EN_CORRECCION');
            }
            // Finalizar tarea ST01 y asignar al usuario que autorizó la tarea
            $instanciaTarea->updateEstatus('COMPLETADO');
            // $instanciaTarea->setUsuarioAutorizador(Auth::user()); // Comentado por que truena con esta linea
            return redirect('tareas')->with('success', 'Se ha guardado correctamente');
        }

        return view('p07_pago_prestaciones.ST01_capturarCandidatos', compact(
            'subProcesoPrestacion',
            'instanciaTarea',
            'sexos'
        ));
    }

    // Parte de la ST01 Subproceso
    public function agregarCandidato(Request $request, SubProcesoPrestacion $subProcesoPrestacion) {

        $user = Auth::user();
        $empleado    = json_decode($request->datos_empleado);

        if (CandidatoPrestacion::where("pago_prestacion_id", $subProcesoPrestacion->pago_prestacion_id)->where("rfc", $empleado->rfc)->doesntExist()) {

            try {
                $candidatoPrestacion = new CandidatoPrestacion();
                $candidatoPrestacion->pago_prestacion_id = $subProcesoPrestacion->pago_prestacion_id;
                $candidatoPrestacion->subproceso_id = $subProcesoPrestacion->subproceso_id;
                $candidatoPrestacion->numero_empleado = $empleado->numero_empleado;
                $candidatoPrestacion->nombre_empleado = $empleado->nombre;
                $candidatoPrestacion->apellido_paterno = $empleado->apellido_paterno;
                $candidatoPrestacion->apellido_materno = $empleado->apellido_materno;
                $candidatoPrestacion->rfc = $empleado->rfc;
                $candidatoPrestacion->curp = $empleado->curp;
                $candidatoPrestacion->seccion_sindical = $empleado->seccion_sindical;
                $candidatoPrestacion->identificador_unidad = $empleado->unidad_administrativa;
                $candidatoPrestacion->unidad_administrativa = $empleado->unidad_administrativa;
                $candidatoPrestacion->unidad_administrativa_nombre = $empleado->unidad_administrativa_nombre;
                $candidatoPrestacion->area_id = $user->area->area_id;
                $candidatoPrestacion->usuario_capturo_id = $user->id;
                $candidatoPrestacion->campos_adicionales = $request->fieldsValue;

                if ($candidatoPrestacion->save()) {
                    return response()->json([
                        "status" => true,
                        "candidato" => $candidatoPrestacion,
                        "mensaje" => "El candidato se ha guardado correctamente"
                    ]);
                }
            } catch (\Throwable $th) {

                return response()->json([
                    "status" => false,
                    "mensaje" => "Ha ocurrido un error, verifique los datos del empleado e intente más tarde"
                ]);
            }

        } else {
            return response()->json([
                "status" => false,
                "mensaje" => "El candidato con el RFC {$empleado->rfc} ya fue agregado por esta u otra área."
            ]);
        }

        return response()->json([
            "status" => false,
            "mensaje" => "Ha ocurrido un error, intente más tarde"
        ]);
    }

    // Parte de la ST01 Subproceso
    public function eliminarRegistroST01(Request $request) {
        try {
            // Eliminamos el candidato
            CandidatoPrestacion::where('candidato_prestacion_id', $request->id)->delete();

            return response()->json([
                "estatus" => true,
                "id" => $request->id,
                "mensaje" => '¡El registro fue eliminado con éxito!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "estatus" => false,
                "mensaje" => '¡Surgió un error al intentar finalizar el proceso, por favor intentelo más tarde!'
            ]);
        }
    }

    // TS02 Subproceso
    public function aprobarCandidatos(Request $request, SubProcesoPrestacion $subProcesoPrestacion, InstanciaTarea $instanciaTarea) {
        $instancia = $subProcesoPrestacion->instancia;

        if ($request->isMethod('post')) {
            if (isset($request->estatus_aprobacion)) {
                foreach ($subProcesoPrestacion->candidatos as $key => $candidato) {
                    $candidato->usuario_autorizo_id = Auth::user()->id;
                    $candidato->save();
                }
                $instanciaTarea->updateEstatus('COMPLETADO');
                $subProcesoPrestacion->updateEstatus('COMPLETADO');
                $fechaLimiteSubida = new Carbon($subProcesoPrestacion->fecha_limite);
                $fechaAprobacionCandidatos = Carbon::now();
                $subProcesoPrestacion->completado_a_tiempo = $fechaAprobacionCandidatos->lessThan($fechaLimiteSubida);
                $subProcesoPrestacion->save();
            } else {
                $instanciaTarea->updateEstatus('RECHAZADO');
                $instanciaTarea->motivo_rechazo = $request->comentarios_rechazo;
                $instanciaTarea->save();

                $instancia->crearInstanciaTarea('CAPTURA_CANDIDATOS', 'EN_CORRECCION');

                $subProcesoPrestacion->estatus_aprobacion = isset($request->estatus_aprobacion);
                $subProcesoPrestacion->comentarios_rechazo = $request->comentarios_rechazo;
                $subProcesoPrestacion->save();
            }
            return redirect('tareas')->with('success', 'La tarea ha finalizado correctamente');
        }
        return view('p07_pago_prestaciones.ST02_aprobarCandidatos', compact(
            'subProcesoPrestacion',
            'instanciaTarea',
        ));
    }

    // Editar candidato en la tarea T03 y T04
    public function editarCandidato(Request $request) {

        $candidato = CandidatoPrestacion::find($request->candidato_prestacion_id);

        $request->request->remove('candidato_prestacion_id');
        $candidato->campos_adicionales = json_encode($request->all());

        if ($candidato->save()) {
            $candidato = CandidatoPrestacion::where("candidato_prestacion_id", $candidato->candidato_prestacion_id)
                ->with("unidadAdministrativa")
                ->with("subproceso.instancia.instanciasTareas.usuarioAutorizador")
                ->first();
            return response()->json([
                "status" => true,
                "candidato" => $candidato
            ]);
        }

        return response()->json([
            "status" => false,
            "mensaje" => "No se pudo actualizar al candidato, intente más tarde"
        ]);
    }

    public function descargarExcelNomina(PagoPrestacion $pagoPrestacion) {
        $fechaHoy = Carbon::now()->format('d-m-Y.H_i');
        return Excel::download(new NominaExport($pagoPrestacion), "{$pagoPrestacion->tipoPrestacion->identificador}_{$fechaHoy}.xlsx");
    }
}
