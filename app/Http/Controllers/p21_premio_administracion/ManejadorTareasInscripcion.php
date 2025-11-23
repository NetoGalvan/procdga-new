<?php

namespace App\Http\Controllers\p21_premio_administracion;

use App\Http\Traits\RegistroInstancias;
use App\Models\Proceso;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Models\p21_premio_administracion\P21CandidatosPremio;
use DB;
use Illuminate\Support\Facades\Auth;

trait ManejadorTareasInscripcion{

    use RegistroInstancias;

    public function cancelarTodo($request){

        try {

            DB::beginTransaction();
                $inscripcion    = P21Inscripcion::find($request->p21_inscripcion_id);
                $instancia      = $inscripcion->instancia;
                $instanciasTareas = $inscripcion->instancia->instanciasTareas;

                $inscripcion->update(['estatus' => 'CANCELADO',
                'activo' => false]);

                foreach ($instanciasTareas as $key => $instanciaTarea) {
                    $instanciaTarea->update(['estatus' => 'CANCELADO',
                    'motivo_rechazo' => 'CANCELACIÓN EN T01 INSCRIPCIÓN']);
                }
            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarTareaT01($inscripcion, $datosPremio){

        try {
            DB::beginTransaction();

                //Datos de p21_inscripcion
                $inscripcion->folio_premio = $datosPremio->folio;
                $inscripcion->tarea_convocatoria = $datosPremio->tarea_convocatoria;
                $inscripcion->anio_convocatoria = $datosPremio->anio_convocatoria;
                $inscripcion->comentarios_admin_pa_21 = $datosPremio->comentarios_admin_pa_21;
                $inscripcion->fecha_inicio_evaluacion_pa = $datosPremio->fecha_inicio_evaluacion_pa;
                $inscripcion->fecha_fin_evaluacion_pa = $datosPremio->fecha_fin_evaluacion_pa;

            DB::commit();

            return $inscripcion->save();

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarTareaT01Finalizar($inscripcion, $request, $datos_empleado) {

        try {
            DB::beginTransaction();

                $inscripcion->area_creadora_id = Auth::user()->area->area_id;
                $inscripcion->creado_por = Auth::user()->id;
                $inscripcion->creado_por_area = Auth::user()->area->identificador;
                $inscripcion->creado_por_area_nombre = Auth::user()->area->nombre;
                $inscripcion->creado_por_titulo = Auth::user()->puesto;


                $inscripcion->comentarios_oper_pa_21 = $request->comentarios;
                $inscripcion->numero_empleado = $datos_empleado->numero_empleado;
                $inscripcion->nombre_empleado = $datos_empleado->nombre;
                $inscripcion->apellido_paterno = $datos_empleado->apellido_paterno;
                $inscripcion->apellido_materno = $datos_empleado->apellido_materno;
                $inscripcion->rfc = $datos_empleado->rfc;
                $inscripcion->seccion_sindical = $datos_empleado->seccion_sindical;
                $inscripcion->nivel_salarial = $datos_empleado->nivel_salarial;
                $inscripcion->fecha_ingreso = $datos_empleado->fecha_alta_empleado;
                $inscripcion->codigo_puesto = $datos_empleado->codigo_puesto;
                $inscripcion->puesto = $datos_empleado->puesto;

                $inscripcion->unidad_administrativa_id = $datos_empleado->unidad_administrativa;
                $inscripcion->unidad_administrativa = $datos_empleado->unidad_administrativa_nombre;
                $inscripcion->subunidad_id = $datos_empleado->subunidad;
                $inscripcion->json_puntualidad_asistencia = json_encode($request->datosTabla[0]);

                $inscripcion->save();
            DB::commit();

            return [ 'estatus' => true, 'mensaje' => 'Tarea finalizada exitosamente' ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrió un error, intente más tarde' . $th];
        }
    }

    public function guardarTareaT02Finalizar($inscripcion, $request){

        $json_desempenio = [
            "Productividad" => $request->productividad,
            "Alcance de objetivos" => $request->alcanceObjetivos,
            "Trabajo bajo presion" => $request->trabajoBajoPresion,
            "Calidad" => $request->calidad,
            "Responsabilidad" => $request->responsabilidad,
            "Planeacion" => $request->planeacion,
            "Conocimiento" => $request->conocimiento,
            "Organización" => $request->organizacion,
            "Prevision" => $request->prevision,
            "Iniciativa" => $request->iniciativa,
            "Trabajo independiente" => $request->trabajoIndependiente,
            "Rapidez" => $request->rapidez,
            "cooperacion" => $request->cooperacion,
            "Relaciones interpersonales" => $request->relacionesInterpersonales,
            "Confiabilidad y discrecion" => $request->confiabilidadDiscrecion,
            "Criterio" => $request->criterio
        ];
        $code_json_desempenio = json_encode($json_desempenio);
        try {
            DB::beginTransaction();
                $inscripcion->antiguedad_puesto_actual = $request->antiguedad;
                $inscripcion->domicilio_laboral = $request->domicilioTrabajo;
                $inscripcion->telefono_laboral = $request->telefonoTrabajo;
                $inscripcion->ext_telefono_laboral = $request->extension;
                $inscripcion->denominacion_puesto = $request->denominacionPuesto;
                $inscripcion->nombre_jefe = $request->nombreJefe;
                $inscripcion->cargo_jefe = $request->cargoJefe;
                $inscripcion->fecha_evaluacion_desempenio = $request->fechaEvaluacion;
                $inscripcion->tipo_nombramiento = $request->tipoNombramiento;
                $inscripcion->propuesto_por = $request->propuestoPor;
                $inscripcion->grupo = $request->grupo;
                $inscripcion->descripcion_actividades = $request->descripcionActividades;
                $inscripcion->json_desempenio = $code_json_desempenio;
                $inscripcion->json_cursos = $request->data_tabla_cursos;
                $inscripcion->evaluado_por = Auth::user()->id;
                $inscripcion->evaluado_por_area = Auth::user()->area->identificador;
                $inscripcion->evaluado_por_area_nombre = Auth::user()->area->nombre;
                $inscripcion->evaluado_por_titulo = Auth::user()->puesto;
                $inscripcion->evaluado_fecha = now();
                $inscripcion->save();
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'Tarea finalizada exitosamente' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrió un error, intente más tarde' ];
        }
    }

    public function guardarTareaT03FinalizarSinCursos($inscripcion, $request){

        try {

            DB::beginTransaction();
                $inscripcion->update([
                    'comentarios_oper_cap_21' => $request->comentarios_oper_cap_21,
                    'validado_por' =>  Auth::user()->id,
                    'validado_por_area' => Auth::user()->area->identificador,
                    'validado_por_area_nombre' => Auth::user()->area->nombre,
                    'validado_por_titulo' => Auth::user()->puesto,
                    'validado_fecha' => now()
                ]);

                P21CandidatosPremio::where([
                    'numero_empleado', $request->num_empleado,
                    'folio_inscripcion', $request->folio_inscripcion
                ])
                ->update([
                    'comentarios_oper_cap_21' => $request->comentarios_oper_cap_21,
                    'validado_por' =>  Auth::user()->id,
                    'validado_por_area' => Auth::user()->area->identificador,
                    'validado_por_area_nombre' => Auth::user()->area->nombre,
                    'validado_por_titulo' => Auth::user()->puesto,
                    'validado_fecha' => now(),
                    'estatus_tiempo' => "EN TIEMPO",
                    'estatus_origen' => "PROCESO"
                ]);

            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'El candidato ha quedado inscrito exitosamente. Ha finalizado el proceso de manera satisfactoria' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Fallo: ' .$th ];
        }
    }

    public function guardarTareaT03FinalizarConCursos($inscripcion, $request, $cursos_empleado){
        $json_cursos = json_encode($cursos_empleado);

        try {

            DB::beginTransaction();
                $inscripcion->update([
                    'comentarios_oper_cap_21' => $request->comentarios_oper_cap_21,
                    'json_cursos' => $json_cursos,
                    'validado_por' =>  Auth::user()->id,
                    'validado_por_area' => Auth::user()->area->identificador,
                    'validado_por_area_nombre' => Auth::user()->area->nombre,
                    'validado_por_titulo' => Auth::user()->puesto,
                    'validado_fecha' => now()
                ]);

                P21CandidatosPremio::where([
                        'numero_empleado' => $request->num_empleado,
                        'folio_inscripcion' => $request->folio_inscripcion
                    ])
                    ->update([
                        'comentarios_oper_cap_21' => $request->comentarios_oper_cap_21,
                        'json_cursos' => $json_cursos,
                        'validado_por' =>  Auth::user()->id,
                        'validado_por_area' => Auth::user()->area->identificador,
                        'validado_por_area_nombre' => Auth::user()->area->nombre,
                        'validado_por_titulo' => Auth::user()->puesto,
                        'validado_fecha' => now(),
                        'estatus_tiempo' => "EN TIEMPO",
                        'estatus_origen' => "PROCESO"
                    ]);

            DB::commit();

            return [ 'estatus' => true, 'mensaje' => 'El candidato ha quedado inscrito exitosamente. Ha finalizado el proceso de manera satisfactoria' ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrió un error, intente más tarde' ];
        }
    }

}
