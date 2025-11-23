<?php

namespace App\Http\Controllers\p21_premio_administracion;

use App\Http\Traits\RegistroInstancias;
use App\Models\Proceso;
use DB;
use Illuminate\Support\Carbon;
use App\Models\UnidadAdministrativa;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Request;
use App\Models\Instancia;
use App\Models\p21_premio_administracion\P21CandidatosPremio;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Models\p24_directorio\AlfabeticoMain;
use Illuminate\Support\Facades\Auth;

trait ManejadorTareas{

    use RegistroInstancias;

    public function crearNotificacionArea($instancia, $area, $nombre_notificacion) {
        $instancia->crearInstanciaTarea($nombre_notificacion, 'NOTIFICACION_NO_LEIDO', $area);
    }

    public function crearTareasParaElAreaSeleccionada($instancia, $paraElArea) {

        $instancia->crearInstanciaTarea('TPA02', 'NUEVO', $paraElArea);

        return true;
    }

    public function guardarTareaTPA01($premioAdministracion, $request, $paraElArea){

        try {
            DB::beginTransaction();
                //Datos de la área
                $premioAdministracion->area_id = $paraElArea->area_id;
                $premioAdministracion->anio_convocatoria = $request->fecha_convocatoria;
                $premioAdministracion->fecha_inicio_evaluacion_pa = $request->fecha_inicio;
                $premioAdministracion->fecha_fin_evaluacion_pa = $request->fecha_fin;
                $premioAdministracion->comentarios_admin_pa_21 = $request->comentarios;
                $premioAdministracion->save();
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'La tarea ha finalizado exitosamente', "ruta" => route('tareas') ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }

    }

    public function guardarDatosEstado($premioAdministracion, $request){

        foreach ($request->estado_candidatos as $estado) {
            $dataEstado[] = explode(",", $estado);
        }

        foreach ($dataEstado as $emple) {
            $datosInscripcion[] = P21Inscripcion::where('numero_empleado', $emple[1])->where('p21_premio_id', $premioAdministracion->p21_premio_id)->first();
        }

        foreach ($datosInscripcion as $key => $value) {

            $razon = $request->razon[$key];
            $value->razon_estatus = $razon;

                foreach ($dataEstado as $k => $v) {
                    $estadoSt = $request->estado_candidatos[$key];
                    $estadoSt = explode(",", $estadoSt);
                    $value->estado_estatus = $estadoSt[0];
                }

            $value->existe = P21CandidatosPremio::where('p21_inscripcion_id', $value->p21_inscripcion_id)->exists();
        }

        try {

            foreach ($datosInscripcion as $empleado) {

                if ($empleado->existe) {
                    DB::beginTransaction();

                        DB::table('p21_candidatos_premio')
                        ->where('p21_inscripcion_id', $empleado->p21_inscripcion_id)
                        ->update([
                            'estatus_declinacion' => $empleado->estado_estatus,
                            'comentarios_declinacion' => mb_strtoupper($empleado->razon_estatus),
                            'folio_inscripcion' => $empleado->folio,
                            'estatus_inscripcion' => $empleado->estatus,
                            'comentarios_oper_pa_21' => $empleado->comentarios_oper_pa_21,
                            'comentarios_oper_cap_21' => $empleado->comentarios_oper_cap_21,
                            'numero_empleado' => $empleado->numero_empleado,
                            'nombre_empleado' => $empleado->nombre_empleado,
                            'apellido_paterno' => $empleado->apellido_paterno,
                            'apellido_materno' => $empleado->apellido_materno,
                            'rfc' => $empleado->rfc,
                            'seccion_sindical' => $empleado->seccion_sindical,
                            'nivel_salarial' => $empleado->nivel_salarial,
                            'fecha_ingreso' => $empleado->fecha_ingreso,
                            'codigo_puesto' => $empleado->codigo_puesto,
                            'puesto' => $empleado->puesto,
                            'area_inscripcion_id' => $empleado->area_id,
                            'unidad_administrativa_id' => $empleado->unidad_administrativa_id,
                            'unidad_administrativa' => $empleado->unidad_administrativa,
                            'subunidad_id' => $empleado->subunidad_id,
                            'antiguedad_puesto_actual' => $empleado->antiguedad_puesto_actual,
                            'domicilio_laboral' => $empleado->domicilio_laboral,
                            'telefono_laboral' => $empleado->telefono_laboral,
                            'ext_telefono_laboral' => $empleado->ext_telefono_laboral,
                            'denominacion_puesto' => $empleado->denominacion_puesto,
                            'descripcion_actividades' => $empleado->descripcion_actividades,
                            'nombre_jefe' => $empleado->nombre_jefe,
                            'cargo_jefe' => $empleado->cargo_jefe,
                            'tipo_nombramiento' => $empleado->tipo_nombramiento,
                            'propuesto_por' => $empleado->propuesto_por,
                            'grupo' => $empleado->grupo,
                            'fecha_evaluacion_desempenio' => $empleado->fecha_evaluacion_desempenio,
                            'json_desempenio' => $empleado->json_desempenio,
                            'json_cursos' => $empleado->json_cursos,
                            'json_puntualidad_asistencia' => $empleado->json_puntualidad_asistencia,

                            'evaluado_por' => $empleado->evaluado_por,
                            'evaluado_por_area' => $empleado->evaluado_por_area,
                            'evaluado_por_area_nombre' => $empleado->evaluado_por_area_nombre,
                            'evaluado_por_titulo' => $empleado->evaluado_por_titulo,
                            'evaluado_fecha' => $empleado->evaluado_fecha,

                            'validado_por' => $empleado->validado_por,
                            'validado_por_area' => $empleado->validado_por_area,
                            'validado_por_area_nombre' => $empleado->validado_por_area_nombre,
                            'validado_por_titulo' => $empleado->validado_por_titulo,
                            'validado_fecha' => $empleado->validado_fecha,

                            'total_art_87' => $empleado->total_art_87,
                        ]);

                    DB::commit();
                } else {

                    DB::beginTransaction();

                        $candidatosPremio = new P21CandidatosPremio;
                        // Datos Premio
                        $candidatosPremio->p21_premio_id = $premioAdministracion->p21_premio_id;
                        $candidatosPremio->folio_premio = $premioAdministracion->folio;
                        $candidatosPremio->estatus_convocatoria = $premioAdministracion->estatus;
                        $candidatosPremio->tarea_convocatoria = $premioAdministracion->tarea_convocatoria;
                        $candidatosPremio->anio_convocatoria = $premioAdministracion->anio_convocatoria;
                        $candidatosPremio->area_premio_id = $premioAdministracion->area->area_id;
                        $candidatosPremio->area_premio_nombre = $premioAdministracion->area->nombre;
                        $candidatosPremio->comentarios_admin_pa_21 = $premioAdministracion->comentarios_admin_pa_21;
                        $candidatosPremio->fecha_inicio_evaluacion_pa = $premioAdministracion->fecha_inicio_evaluacion_pa;
                        $candidatosPremio->fecha_fin_evaluacion_pa = $premioAdministracion->fecha_fin_evaluacion_pa;
                        $candidatosPremio->creado_por = $premioAdministracion->creado_por;
                        $candidatosPremio->creado_por_area = $premioAdministracion->creado_por_area;
                        $candidatosPremio->creado_por_area_nombre = $premioAdministracion->creado_por_area_nombre;
                        $candidatosPremio->creado_por_titulo = $premioAdministracion->creado_por_titulo;
                        $candidatosPremio->area_creadora_id = $premioAdministracion->area_creadora_id;
                        // Datos Inscripción
                        $candidatosPremio->p21_inscripcion_id = $empleado->p21_inscripcion_id;
                        $candidatosPremio->folio_inscripcion = $empleado->folio;
                        $candidatosPremio->estatus_inscripcion = $empleado->estatus;
                        $candidatosPremio->comentarios_oper_pa_21 = $empleado->comentarios_oper_pa_21;
                        $candidatosPremio->comentarios_oper_cap_21 = $empleado->comentarios_oper_cap_21;
                        $candidatosPremio->numero_empleado = $empleado->numero_empleado;
                        $candidatosPremio->nombre_empleado = $empleado->nombre_empleado;
                        $candidatosPremio->apellido_paterno = $empleado->apellido_paterno;
                        $candidatosPremio->apellido_materno = $empleado->apellido_materno;
                        $candidatosPremio->rfc = $empleado->rfc;
                        $candidatosPremio->seccion_sindical = $empleado->seccion_sindical;
                        $candidatosPremio->nivel_salarial = $empleado->nivel_salarial;
                        $candidatosPremio->fecha_ingreso = $empleado->fecha_ingreso;
                        $candidatosPremio->codigo_puesto = $empleado->codigo_puesto;
                        $candidatosPremio->puesto = $empleado->puesto;
                        $candidatosPremio->area_inscripcion_id = $empleado->area_id;
                        $candidatosPremio->unidad_administrativa_id = $empleado->unidad_administrativa_id;
                        $candidatosPremio->unidad_administrativa = $empleado->unidad_administrativa;
                        $candidatosPremio->subunidad_id = $empleado->subunidad_id;
                        $candidatosPremio->antiguedad_puesto_actual = $empleado->antiguedad_puesto_actual;
                        $candidatosPremio->domicilio_laboral = $empleado->domicilio_laboral;
                        $candidatosPremio->telefono_laboral = $empleado->telefono_laboral;
                        $candidatosPremio->ext_telefono_laboral = $empleado->ext_telefono_laboral;
                        $candidatosPremio->denominacion_puesto = $empleado->denominacion_puesto;
                        $candidatosPremio->descripcion_actividades = $empleado->descripcion_actividades;
                        $candidatosPremio->nombre_jefe = $empleado->nombre_jefe;
                        $candidatosPremio->cargo_jefe = $empleado->cargo_jefe;
                        $candidatosPremio->tipo_nombramiento = $empleado->tipo_nombramiento;
                        $candidatosPremio->propuesto_por = $empleado->propuesto_por;
                        $candidatosPremio->grupo = $empleado->grupo;
                        $candidatosPremio->fecha_evaluacion_desempenio = $empleado->fecha_evaluacion_desempenio;
                        $candidatosPremio->json_desempenio = $empleado->json_desempenio;
                        $candidatosPremio->json_cursos = $empleado->json_cursos;
                        $candidatosPremio->json_puntualidad_asistencia = $empleado->json_puntualidad_asistencia;

                        $candidatosPremio->evaluado_por = $empleado->evaluado_por;
                        $candidatosPremio->evaluado_por_area = $empleado->evaluado_por_area;
                        $candidatosPremio->evaluado_por_area_nombre = $empleado->evaluado_por_area_nombre;
                        $candidatosPremio->evaluado_por_titulo = $empleado->evaluado_por_titulo;
                        $candidatosPremio->evaluado_fecha = $empleado->evaluado_fecha;

                        $candidatosPremio->validado_por = $empleado->validado_por;
                        $candidatosPremio->validado_por_area = $empleado->validado_por_area;
                        $candidatosPremio->validado_por_area_nombre = $empleado->validado_por_area_nombre;
                        $candidatosPremio->validado_por_titulo = $empleado->validado_por_titulo;
                        $candidatosPremio->validado_fecha = $empleado->validado_fecha;

                        $candidatosPremio->total_art_87 = $empleado->total_art_87;

                        // Datos candidatos premio
                        $candidatosPremio->estatus_declinacion = $empleado->estado_estatus;
                        $candidatosPremio->comentarios_declinacion = mb_strtoupper($empleado->razon_estatus);

                        $candidatosPremio->save();

                    DB::commit();
                }
            }

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function cierreConvocatoria($premioAdministracion){

        try {

            DB::beginTransaction();

                DB::table('p21_premio')
                ->where('p21_premio_id', $premioAdministracion->p21_premio_id)
                ->update(['fecha_cierre_convocatoria' => now() ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function finalizarProcesoConvocatoria($premioAdministracion, $instanciaTarea, $request){
        try {

            DB::beginTransaction();

                $instanciaTarea->updateEstatus('CANCELADO');

                $premioAdministracion->update([
                    'estatus' => 'CANCELADO',
                    'activo' => false
                ]);

                P21Inscripcion::where(['p21_premio_id' => $premioAdministracion->p21_premio_id])
                    ->update(['estatus' => 'CANCELADO',
                            'activo' => false]);

                P21CandidatosPremio::where(['p21_premio_id' => $premioAdministracion->p21_premio_id])
                    ->update(['estatus_convocatoria' => 'CANCELADO',
                            'estatus_inscripcion' => 'CANCELADO',
                            'activo' => false]);
            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarNuevoCandidatoConvocatoria($premioAdministracion, $request){

        try {
            $empleado = json_decode($request['datos_empleado']);

            DB::beginTransaction();

                $p21_inscripcion_id = DB::table('p21_inscripcion')->insertGetId([

                    'estatus' => "EN_PROCESO",
                    'p21_premio_id' => $premioAdministracion->p21_premio_id,
                    'folio_premio' => $premioAdministracion->folio,
                    'area_id' => $premioAdministracion->area_id,
                    'anio_convocatoria' => $premioAdministracion->anio_convocatoria,
                    'comentarios_admin_pa_21' => $premioAdministracion->comentarios_admin_pa_21,
                    'fecha_inicio_evaluacion_pa' => $premioAdministracion->fecha_inicio_evaluacion_pa,
                    'fecha_fin_evaluacion_pa' => $premioAdministracion->fecha_fin_evaluacion_pa,

                    'area_creadora_id' => Auth::user()->area->area_id,
                    'creado_por' => Auth::user()->id,
                    'creado_por_area' => Auth::user()->area->identificador,
                    'creado_por_area_nombre' => Auth::user()->area->nombre,
                    'creado_por_titulo' => Auth::user()->puesto,

                    //Datos del empleado
                    'numero_empleado' => $empleado->numero_empleado,
                    'nombre_empleado' => $empleado->nombre,
                    'apellido_paterno' => $empleado->apellido_paterno,
                    'apellido_materno' => $empleado->apellido_materno,
                    'rfc' => $empleado->rfc,
                    'seccion_sindical' => $empleado->seccion_sindical,
                    'nivel_salarial' => $empleado->nivel_salarial,
                    'fecha_ingreso' => $empleado->fecha_alta_empleado,
                    'codigo_puesto' => $empleado->codigo_puesto,
                    'puesto' => $empleado->puesto,
                    'unidad_administrativa_id' => $empleado->unidad_administrativa,
                    'unidad_administrativa' => $empleado->unidad_administrativa_nombre,
                    'subunidad_id' => $empleado->subunidad,
                    'json_puntualidad_asistencia' => json_encode($empleado),

                    'grupo' => $request->grupo,
                    'tipo_nombramiento' => $request->tipo_nombramiento,

                ], 'p21_inscripcion_id');

                DB::table('p21_candidatos_premio')->insert([

                    'estatus_tiempo' => "FUERA DE TIEMPO",
                    'estatus_origen' => "COMITÉ",
                    'p21_premio_id' => $premioAdministracion->p21_premio_id,
                    'folio_premio' => $premioAdministracion->folio,
                    'estatus_convocatoria' => "EN_PROCESO",
                    'anio_convocatoria' => $premioAdministracion->anio_convocatoria,

                    'area_premio_id' => $premioAdministracion->area_id,
                    'area_premio_nombre' => $premioAdministracion->area->nombre,

                    'area_inscripcion_id' => $premioAdministracion->inscripcion->area_id,
                    'area_inscripcion_nombre' => $premioAdministracion->inscripcion->nombre,

                    'comentarios_admin_pa_21' => $premioAdministracion->comentarios_admin_pa_21,
                    'fecha_inicio_evaluacion_pa' => $premioAdministracion->fecha_inicio_evaluacion_pa,
                    'fecha_fin_evaluacion_pa' => $premioAdministracion->fecha_fin_evaluacion_pa,

                    'area_creadora_id' => Auth::user()->area->area_id,
                    'creado_por' => Auth::user()->id,
                    'creado_por_area' => Auth::user()->area->identificador,
                    'creado_por_area_nombre' => Auth::user()->area->nombre,
                    'creado_por_titulo' => Auth::user()->puesto,

                    'p21_inscripcion_id' => $p21_inscripcion_id,
                    'estatus_inscripcion' => "EN_PROCESO",
                    'numero_empleado' => $empleado->numero_empleado,
                    'nombre_empleado' => $empleado->nombre,
                    'apellido_paterno' => $empleado->apellido_paterno,
                    'apellido_materno' => $empleado->apellido_materno,
                    'rfc' => $empleado->rfc,
                    'seccion_sindical' => $empleado->seccion_sindical,
                    'nivel_salarial' => $empleado->nivel_salarial,
                    'fecha_ingreso' => $empleado->fecha_alta_empleado,
                    'codigo_puesto' => $empleado->codigo_puesto,
                    'puesto' => $empleado->puesto,
                    'unidad_administrativa_id' => $empleado->unidad_administrativa,
                    'unidad_administrativa' => $empleado->unidad_administrativa_nombre,
                    'subunidad_id' => $empleado->subunidad,
                    'json_puntualidad_asistencia' => json_encode($empleado),
                    'comentarios_desempenio' => $request->comentarios_desempenio,
                    'comentarios_cursos' => $request->comentarios_cursos,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            DB::commit();

            return [ 'estatus' => true, 'mensaje' => 'Candidato guardado exitosamente' ];


        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrió un error, intente más tarde' ];
        }
    }

    public function guardarPuntajePremio($premioAdministracion, $request){

        foreach ($request->puntaje as $puntu) {
            $dataPuntaje[] = explode(",", $puntu);
        }

        foreach ($dataPuntaje as $punta) {
            $datosCandidatoInscripcion[] = P21Inscripcion::where('numero_empleado', $punta[1])->where('p21_premio_id', $premioAdministracion->p21_premio_id)->first();
        }

        foreach ($datosCandidatoInscripcion as $key => $value) {

            $premio = $request->premios[$key];
            $value->premio = $premio;
            $observaciones = $request->observaciones[$key];
            $value->observaciones = $observaciones;

            foreach ($dataPuntaje as $k => $v) {
                $puntajes = $request->puntaje[$key];
                $puntajes = explode(",", $puntajes);
                $value->puntaje = $puntajes[0];
            }
        }

        try {

            if ( $premioAdministracion->comite_previo == null ) {

                foreach ($datosCandidatoInscripcion as $empleado) {
                    DB::beginTransaction();

                        DB::table('p21_candidatos_premio')
                        ->where('p21_inscripcion_id', $empleado->p21_inscripcion_id)
                        ->where('p21_premio_id', $premioAdministracion->p21_premio_id)
                        ->where('numero_empleado', $empleado->numero_empleado)
                        ->update(['puntaje_total_inicial' => $empleado->puntaje,
                                'premio_inicial' => $empleado->premio,
                                'observaciones' => mb_strtoupper($empleado->observaciones) ]);

                    DB::commit();
                }

                return true;

            } else {

                foreach ($datosCandidatoInscripcion as $empleado) {
                    DB::beginTransaction();

                        DB::table('p21_candidatos_premio')
                        ->where('p21_inscripcion_id', $empleado->p21_inscripcion_id)
                        ->where('p21_premio_id', $premioAdministracion->p21_premio_id)
                        ->where('numero_empleado', $empleado->numero_empleado)
                        ->update(['puntaje_total_final' => $empleado->puntaje,
                                'premio_final' => $empleado->premio,
                                'observaciones' => mb_strtoupper($empleado->observaciones) ]);

                    DB::commit();
                }

                return true;
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarComite($premioAdministracion){

        try {

            DB::beginTransaction();

                DB::table('p21_premio')
                ->where('p21_premio_id', $premioAdministracion->p21_premio_id)
                ->update(['comite_previo' => "t" ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function finalizarProceso($premioAdministracion){

        try {

            DB::beginTransaction();

                DB::table('p21_premio')
                    ->where(['p21_premio_id' => $premioAdministracion->p21_premio_id])
                    ->update(['estatus' => 'COMPLETADO',
                            'activo' => false]);

                DB::table('p21_inscripcion')
                    ->where(['p21_premio_id' => $premioAdministracion->p21_premio_id])
                    ->where(['activo' => true])
                    ->update(['estatus' => 'COMPLETADO',
                            'activo' => false]);

                DB::table('p21_candidatos_premio')
                    ->where(['p21_premio_id' => $premioAdministracion->p21_premio_id])
                    ->where(['activo' => true])
                    ->update(['estatus_convocatoria' => 'COMPLETADO',
                            'estatus_inscripcion' => 'COMPLETADO',
                            'activo' => false]);
            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarStatusComentario($premioAdministracion, $request){

        foreach ($request->estatus_inconformidad as $status) {
            $dataStatus[] = explode(",", $status);
        }

        foreach ($dataStatus as $dStatus) {
            $datosCandidatoInscripcion[] = P21Inscripcion::where('numero_empleado', $dStatus[1])->where('p21_premio_id', $premioAdministracion->p21_premio_id)->first();
        }

        foreach ($datosCandidatoInscripcion as $key => $value) {

            $comentario_inconformidad = $request->comentario_inconformidad[$key];
            $value->comentario_inconformidad = $comentario_inconformidad;

            foreach ($dataStatus as $k => $v) {
                $status = $request->estatus_inconformidad[$key];
                $status = explode(",", $status);
                $value->estatus_inconformidad = $status[0];
            }
        }

        try {

            foreach ($datosCandidatoInscripcion as $empleado) {
                DB::beginTransaction();

                    DB::table('p21_candidatos_premio')
                    ->where('p21_inscripcion_id', $empleado->p21_inscripcion_id)
                    ->update(['estatus_inconformidad' => $empleado->estatus_inconformidad,
                            'comentarios_inconformidad' => mb_strtoupper($empleado->comentario_inconformidad) ]);

                DB::commit();
            }

            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

}
