<?php

namespace App\Http\Controllers\p06_servicio_social;

use App\Http\Traits\RegistroInstancias;

use App\Models\Proceso;
use App\Models\p06_servicio_social\P06Detalle;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06AreasAdscripcion;
use App\Models\p06_servicio_social\P06DetalleArchivos;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06Programa;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Instituciones;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

trait ManejadorTareas{
    use RegistroInstancias;

    protected $directorioBase = 'p06_servicio_social';

    public function terminarServicioSocial($instancia){
        return P06ServicioSocial::create([
            'estatus_trabajo' => 'COMPLETADO',
            'instancia_id' => $instancia->instancia_id
        ]);
    }

    public function getInstanciaTarea($instancia, $nombreTarea){
        return $instancia->getInstanciaTarea($nombreTarea);
    }

    public function crearFolio($instancia, $instanciaTarea) {
        $instancia->folio = $this->crearFolioProceso($instancia, $instanciaTarea);
        $instancia->save();

        return $instancia->folio;
    }

    public function crearTarea($instancia, $nombreTarea, $estatus){
        return $instancia->crearInstanciaTarea($nombreTarea, $estatus);
    }

    public function actualizarEstatusTarea($instanciaTarea, $estatus){
        $instanciaTarea->estatus = $estatus;
        return $instanciaTarea->save();
    }

    public function guardarTareaT01($servicioSocial, $prestador_id) {
        try {
            DB::beginTransaction();
                P06Prestador::where('prestador_id', $prestador_id)->update(['estatus_prestador' => 'EN_PROCESO'/*, 'activo' => false*/]);
                $datosPrestadorSeleccionado = P06Prestador::firstWhere('prestador_id', $prestador_id);

                $servicioSocial->prestador_id = $datosPrestadorSeleccionado->prestador_id;
                $servicioSocial->entidad_federativa_id = $datosPrestadorSeleccionado->entidad_federativa_id;
                $servicioSocial->escuela_id = $datosPrestadorSeleccionado->escuela_id;
                $servicioSocial->estatus = 'EN_PROCESO';
                $servicioSocial->save();
            DB::commit();
            return [ 'estatus' => true ];
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }

    public function guardarTareaT02($servicioSocial, $request){
        try {
            DB::beginTransaction();
                $servicioSocial->fecha_cita = $request['fecha_cita'];
                $servicioSocial->hora_cita = $request['hora_cita'];
                $servicioSocial->lugar_cita = $servicioSocial->area->nombre;
                $servicioSocial->save();
                // $arregloActualizar = [];

                // isset($request['totalHoras'])?$arregloActualizar['total_horas'] = $request['totalHoras']:'';
                // isset($request['horarioCubrir'])?$arregloActualizar['horario_tentativo'] = $request['horarioCubrir']:'';
                // isset($request['correo'])?$arregloActualizar['email'] = $request['correo']:'';
                // isset($request['telefono'])?$arregloActualizar['telefono'] = $request['telefono']:'';
                // isset($request['calle'])?$arregloActualizar['calle'] = $request['calle']:'';
                // isset($request['exterior'])?$arregloActualizar['numero_exterior'] = $request['exterior']:'';

                // if (count($arregloActualizar) > 0) {
                //     DB::table('p06_prestadores')
                //     ->where('prestador_id', $request['prestador_id'])
                //     ->update($arregloActualizar);
                // }
            DB::commit();
            return [ 'estatus' => true ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }

    public function guardarTareaT03($servicioSocial, $request){
        try {
            DB::beginTransaction();
                P06Prestador::query()->where('prestador_id', $servicioSocial->prestador_id)->update(['estatus_aceptado' => $request['EstatusCandidato']]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function actualizarEstatusPrestadorARechazado($servicioSocial){
        try {
            DB::beginTransaction();
                P06ServicioSocial::query()->where('servicio_social_id', $servicioSocial->servicio_social_id)->update([ 'activo' => false, 'estatus' => 'RECHAZADO' ]);
                P06Prestador::query()->where('prestador_id', $servicioSocial->prestador_id)->update(['activo' => true, 'estatus_prestador' => 'RECHAZADO' ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarTareaT04($servicioSocial, $request){
        try {
            DB::beginTransaction();
            $servicioSocial->fecha_inicio = $request['fecha_inicio'];
            $servicioSocial->fecha_fin = $request['fecha_fin'];
            $servicioSocial->horario = $request['hora_entrada'].' - '.$request['hora_salida'];
            $servicioSocial->area_adscripcion_id = $request['area_adscripcion_id'];
            $servicioSocial->subdireccion_ua = $request['subdireccion_ua'];
            $servicioSocial->unidad_departamental_ua = $request['unidad_departamental_ua'];
            $servicioSocial->jefe = $request['jefe'];
            $servicioSocial->puesto_jefe = $request['puesto_jefe'];
            $servicioSocial->telefono_jefe = $request['telefono_jefe'];
            $servicioSocial->actividades = $request['actividades'];
            $servicioSocial->fecha_inicio_monitoreo = now();
            $servicioSocial->direccion_ejecutiva = $request['direccion_ejecutiva'];
            $servicioSocial->coordinacion = $request['coordinacion'];
            $servicioSocial->telefono_ext_jefe = $request['telefono_ext_jefe'];
            $servicioSocial->save();
            DB::commit();
            return [ 'estatus' => true ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }

    public function guardarObservaciones($servicioSocial, $request){
        $servicioSocial->observaciones_som = $request['observaciones_som'];
        return $servicioSocial->save();
    }

    public function guardarHorasAcumuladas($servicioSocial, $horasAcumuladasSumadas){
        $servicioSocial->horas_acumuladas = $horasAcumuladasSumadas;
        return $servicioSocial->save();
    }

    public function guardarTareaT06($servicioSocial, $request){
        try {
            $detalle = new P06Detalle;
            $detalle->servicio_social_id = $servicioSocial->servicio_social_id;
            $detalle->fecha_comentario = date("Y-m-d",strtotime(now()));
            $detalle->comentario = $request->comentario;
            $detalle->informe = $request->tipo_informe;
            $detalle->save();

            return [ 'estatus' => true, 'mensaje' => 'Se guardó la información correctamente'];
        } catch (\Throwable $th) {
            return [ 'estatus' => false, 'mensaje' => $th];
        }
    }

    function guardarDatosDocumentoServicioSocial($request, $servicioSocial) {
        try {
            DB::beginTransaction();

            $detalleArchivo = new P06DetalleArchivos();

            $archivoNuevo = $request->file('file');
            $nombreArchivo = $archivoNuevo->getClientOriginalName();
            
            $rutaArchivo = 'p06_servicio_social/'.$servicioSocial->folio.'/'.$nombreArchivo;

            $horasAsistencia = (isset($request->horas_asistencia) ? $request->horas_asistencia : null);

            if( P06DetalleArchivos::where('ruta_archivo', $rutaArchivo)->exists() ){
                return [ 'estatus' => false, 'mensaje' => 'Ya existe un documento con el mismo nombre' ];
                
            } else {
                $detalleArchivo->servicio_social_id = $servicioSocial->servicio_social_id;
                $detalleArchivo->tipo_archivo = $request->tipo;
                $detalleArchivo->descripcion = $request->descripcion;
                $detalleArchivo->fecha_detalle = Carbon::now()->format('d-m-Y');
                $detalleArchivo->nombre_archivo = $nombreArchivo;
                $detalleArchivo->ruta_archivo = $rutaArchivo;
                $detalleArchivo->horas_asistencia = $horasAsistencia;
                $detalleArchivo->save();

                Storage::disk('public')->put($rutaArchivo, $archivoNuevo->getContent()); 
            }
/*
            $nombreArchivos = $nuevoDirectorios . '/' .$request->file('file')->getClientOriginalName();
            $archivosDirectorios = Storage::files($nuevoDirectorios);
            $existeDocumentos = in_array($nombreArchivos, $archivosDirectorios);

            if ( ! $existeDocumentos ) {
                $archivosguardados = Storage::put($nombreArchivos, $archivoNuevo);
                if ( ! $archivosguardados ) {
                    return [ 'estatus' => false, 'mensaje' => 'No se puede guardar el documento' ];
                }
            } else {
                return [ 'estatus' => false, 'mensaje' => 'Ya existe un documento con ese nombre' ];
            }
*/
/*           
            $horasAsistencia = (isset($request->horas_asistencia) ? $request->horas_asistencia : null);

            

            $detalleArchivo->servicio_social_id = $servicioSocial->servicio_social_id;
            $detalleArchivo->tipo_archivo = $request->tipo;
            $detalleArchivo->descripcion = $request->descripcion;
            $detalleArchivo->fecha_detalle = Carbon::now()->format('d-m-Y');
            $detalleArchivo->nombre_archivo = $nombreArchivo;
            $detalleArchivo->ruta_archivo = $rutaArchivo;
            $detalleArchivo->horas_asistencia = $horasAsistencia;

            $detalleArchivo->save();
*/
            if($request->tipo == 'SUBIR HORAS'){
                $servicioSocial->horas_acumuladas = P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->where('tipo_archivo', $request->tipo)->get()->sum('horas_asistencia');
                $servicioSocial->save();
            }  

            $horasRestantes = ($servicioSocial->prestador->total_horas - $servicioSocial->horas_acumuladas);

            DB::commit();
            return [ 
                'estatus' => true, 
                'cargarDocumentos' => P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->orderByDesc('detalle_archivo_id')->get(), 
                'horasRestantes' => $horasRestantes,
                'mensaje' => 'Se guardó el documento correctamente.'
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'No se pudo guardar el documento ' . $th ];
        }
/*
        try {
            $archivoNuevo = $request->file('file')->getContent();
            $nuevoDirectorios = $this->directorioBase . '/' . $servicioSocial->folio;
            $subDirectorios = Storage::allDirectories($this->directorioBase);
            $directorioEncontrados = in_array($nuevoDirectorios, $subDirectorios);

            if ( ! $directorioEncontrados ) {
                Storage::makeDirectory($nuevoDirectorios);
            }

            $nombreArchivos = $nuevoDirectorios . '/' .$request->file('file')->getClientOriginalName();
            $archivosDirectorios = Storage::files($nuevoDirectorios);
            $existeDocumentos = in_array($nombreArchivos, $archivosDirectorios);

            if ( ! $existeDocumentos ) {
                $archivosguardados = Storage::put($nombreArchivos, $archivoNuevo);
                if ( ! $archivosguardados ) {
                    return [ 'estatus' => false, 'mensaje' => 'No se puede guardar el documento' ];
                }
            } else {
                return [ 'estatus' => false, 'mensaje' => 'Ya existe un documento con ese nombre' ];
            }

            DB::beginTransaction();
                $horasAsistencia = (isset($request->horas_asistencia) ? $request->horas_asistencia : null);

                $detalleArchivo = new P06DetalleArchivos();

                $detalleArchivo->servicio_social_id = $servicioSocial->servicio_social_id;
                $detalleArchivo->tipo_archivo = $request->tipo;
                $detalleArchivo->descripcion = $request->descripcion;
                $detalleArchivo->fecha_detalle = Carbon::now()->format('d-m-Y');
                $detalleArchivo->nombre_archivo = $request->file('file')->getClientOriginalName();
                $detalleArchivo->ruta_archivo = $nombreArchivos;
                $detalleArchivo->horas_asistencia = $horasAsistencia;

                $detalleArchivo->save();

                if($request->tipo == 'SUBIR HORAS'){
                    $servicioSocial->horas_acumuladas = P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->where('tipo_archivo', $request->tipo)->get()->sum('horas_asistencia');
                    $servicioSocial->save();
                }  

                $horasRestantes = ($servicioSocial->prestador->total_horas - $servicioSocial->horas_acumuladas);

            DB::commit();
            return [ 
                'estatus' => true, 
                'cargarDocumentos' => P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->orderByDesc('detalle_archivo_id')->get(), 
                'horasRestantes' => $horasRestantes,
                'mensaje' => 'Se guardó el documento correctamente.'
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'No se pudo guardar el documento ' . $th ];
        }
*/
    }


    public function guardarValidacion($servicioSocial, $validacion){
        try {
            DB::beginTransaction();
                P06ServicioSocial::query()->where('servicio_social_id', $servicioSocial->servicio_social_id)->update(['validacion' => $validacion ]);
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'Validación guardada, la tarea ha finalizado correctamente' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error al validar: ' . $th ];
        }
    }

    public function guardarObservacionesFinalizacion($servicioSocial, $request){
        $servicioSocial->comentario = $request['observaciones_finalizacion'];
        return $servicioSocial->save();
    }

    public function guardarFechaCartaInicio($servicioSocial) {
        $servicioSocial->fecha_carta_inicio = now();
        return $servicioSocial->save();
    }

    public function guardarFechaCartaTermino($servicioSocial) {
        $servicioSocial->fecha_carta_fin = now();
        return $servicioSocial->save();
    }

    public function guardarFuncionarioCartaTermino($servicioSocial, $request){

        $servicioSocial->prestador->nombre_funcionario = $request['nombre_funcionario'];
        $servicioSocial->prestador->puesto_funcionario = $request['puesto_funcionario'];
        $servicioSocial->prestador->telefono_funcionario = $request['telefono_funcionario'];
        $servicioSocial->prestador->actualizo_funcionario_carta_termino = true;

        return $servicioSocial->prestador->save();
    }
/*
    public function catalogoGuardarNuevaInstitucion($request){

        $institucion = new P06Instituciones;

        $institucion->nombre_institucion = $request['nombreNuevaInstitucion'];
        $institucion->acronimo_institucion = $request['acronimoNuevaInstitucion'];
        $institucion->clave_institucion = $request['claveNuevaInstitucion'];
        $institucion->save();

        return $institucion->save();
    }

    public function catalogoEditarInstitucion($request){

        DB::table('p06_instituciones')
                    ->where('institucion_id', $request['institucion_id'])
                    ->update(['nombre_institucion' => $request['nombreInstitucionEditar'],
                            'acronimo_institucion' => $request['acronimoInstitucionEditar'],
                            'clave_institucion' => $request['claveIntitucionEditar'] ]);

        return true;
    }

    public function pasarInstitucionAFalse($request){
        DB::table('p06_instituciones')->where('institucion_id', $request['institucion_id'])->update(['activo' => false]);
        return true;
    }
*/
/*
    // Inician funciones del catalogo prestador
    public function catalogoGuardarNuevoPrestador($request){
        try {
            DB::beginTransaction();
                $prestador = new P06Prestador;
                $prestador->escuela_id = $request['escuela_id'];
                $prestador->entidad_federativa_id = $request['entidad_id'];
                $prestador->tipo_prestador = $request['tipo_prestador'];
                $prestador->primer_apellido = mb_strtoupper($request['apePaterno']);
                $prestador->segundo_apellido = mb_strtoupper($request['apeMaterno']);
                $prestador->nombre_prestador = mb_strtoupper($request['nombre']);
                $prestador->telefono = $request['telefono'];
                $prestador->email = $request['correo'];
                $prestador->carrera = mb_strtoupper($request['carrera']);
                $prestador->matricula = mb_strtoupper($request['matricula']);
                $prestador->calle = mb_strtoupper($request['calle']);
                $prestador->numero_interior = $request['interior'];
                $prestador->numero_exterior = $request['exterior'];
                $prestador->ciudad = mb_strtoupper($request['ciudad']);
                $prestador->colonia = mb_strtoupper($request['colonia']);
                $prestador->cp = $request['cp'];
                $prestador->municipio_alcaldia = mb_strtoupper($request['municipio_alcaldia']);
                $prestador->horario_tentativo = mb_strtoupper($request['horarioCubrir']);
                $prestador->total_horas = $request['totalHoras'];
                $prestador->observaciones = mb_strtoupper($request['observaciones']);
                $prestador->nombre_funcionario = mb_strtoupper($request['funcionario_escuela']);
                $prestador->puesto_funcionario = mb_strtoupper($request['cargo_funcionario']);
                $prestador->telefono_funcionario = mb_strtoupper($request['telefono_funcionario']);
                $prestador->save();
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'Prestador registrado exitosamente' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error al guardar al prestador: ' . $th ];
        }
    }

    public function catalogoEditarPrestador($request){

        DB::table('p06_prestadores')
                    ->where('prestador_id', $request->prestador_id)
                    ->update([
                        'entidad_federativa_id' => $request->entidad_id,
                        'tipo_prestador' => $request->tipo_prestadorEditar,
                        'primer_apellido' => mb_strtoupper($request->apePaternoEditar),
                        'segundo_apellido' => mb_strtoupper($request->apeMaternoEditar),
                        'nombre_prestador' => mb_strtoupper($request->nombreEditar),
                        'telefono' => $request->telefonoEditar,
                        'email' => $request->correoEditar,
                        'carrera' => mb_strtoupper($request->carreraEditar),
                        'matricula' => mb_strtoupper($request->matriculaEditar),
                        'calle' => $request->calleEditar,
                        'numero_interior' => $request->interiorEditar,
                        'numero_exterior' => $request->exteriorEditar,
                        'ciudad' => mb_strtoupper($request->ciudad),
                        'colonia' => mb_strtoupper($request->colonia),
                        'cp' => $request->cp,
                        'municipio_alcaldia' => mb_strtoupper($request->municipio_alcaldia),
                        'horario_tentativo' => $request->horarioCubrirEditar,
                        'total_horas' => $request->totalHorasEditar,
                        'observaciones' => $request->observacionesEditar
                    ]);

        return true;
    }

    public function pasarPrestadorAFalse($request){
        DB::table('p06_prestadores')->where('prestador_id', $request->prestador_id)->update(['activo' => false]);
        return true;
    }
*/
/*
    // Inician funciones del catalogo de Escuelas
    public function catalogoGuardarNuevaEscuela($request, $institucion_id){

        $escuela = new P06Escuela();

        $escuela->institucion_id = $institucion_id;
        $escuela->nombre_escuela = $request['nombreNuevaEscuela'];
        $escuela->acronimo_escuela = $request['acronimoNuevaEscuela'];
        $escuela->direccion_escuela = $request['direccionNuevaEscuela'];
        $escuela->save();
        return true;
    }

    public function catalogoEditarEscuela($request){

        DB::table('p06_escuelas')
                    ->where('escuela_id', $request['escuela_id'])
                    ->update(['nombre_escuela' => $request['nombreEscuelaEditar'],
                            'acronimo_escuela' => $request['acronimoEscuelaEditar'],
                            'direccion_escuela' => $request['direccionEscuelaEditar'] ]);

        return true;
    }

    public function pasarEscuelaAFalse($request){
        DB::table('p06_escuelas')->where('escuela_id', $request['escuela_id'])->update(['activo' => false]);
        return true;
    }

    // Inician funciones del catalogo Programa
    public function catalogoGuardarNuevoPrograma($request){
        $programa = new P06Programa();

        $programa->institucion_id = $request->institucion_id;
        $programa->nombre_programa = $request->nombreNuevoPrograma;
        $programa->clave_programa = $request->claveNuevoPrograma;
        $programa->activo = true;
        $programa->save();
        return true;
    }

    public function catalogoEditarPrograma($request){
        P06Programa::query()->where('programa_id', $request->programa_id)->update([ 'nombre_programa' => $request->nombreProgramaEditado, 'clave_programa' => $request->claveProgramaEditado ]);
        return true;
    }

    public function pasarProgramaAFalse($request){
        P06Programa::query()->where('programa_id', $request['programa_id'])->update([ 'activo' => false ]);
        return true;
    }
*/
    public function actualizar_estatus_prestador_dar_de_baja($servicioSocial){
        try {
            DB::beginTransaction();
                P06Prestador::where(['prestador_id' => $servicioSocial->prestador_id])
                ->update(['estatus_prestador' => 'BAJA']);

                $servicioSocial->estatus = 'CANCELADO'; //Baja
                $servicioSocial->activo = false;
                $servicioSocial->save();
/*
                DB::table('p06_prestadores')->where(['prestador_id' => $servicioSocial->prestador_id])
                ->update(['estatus_prestador' => 'DADO_DE_BAJA']);

                DB::table('p06_servicio_social')->where(['servicio_social_id' => $servicioSocial->servicio_social_id])
                ->update(['estatus' => 'DADO_DE_BAJA',
                        'activo' => false]);
*/
                //dd($servicioSocial);
            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th);
            return false;
        }
    }

    public function actualizar_estatus_prestador_servicio_liberado($servicioSocial){

        try {
            DB::beginTransaction();

                DB::table('p06_prestadores')->where(['prestador_id' => $servicioSocial->prestador_id])
                ->update(['estatus_prestador' => 'LIBERADO']);

                DB::table('p06_servicio_social')->where(['servicio_social_id' => $servicioSocial->servicio_social_id])
                ->update(['estatus' => 'LIBERADO']);

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
/*
    public function mandarEstatusFinalizadoInstancia($instanciaTarea, $estatus){
        DB::table('instancias')->where(['instancia_id' => $instanciaTarea->instancia_id])->update(['estatus' => $estatus]);
        return true;
    }
*/
/*
    public function mandarEstatusServicioSocialFalso($servicioSocial){

        try {

            DB::beginTransaction();

                DB::table('p06_servicio_social')
                            ->where('servicio_social_id', $servicioSocial->servicio_social_id)
                            ->update(['activo' => false,
                                    'estatus' => 'PREMATURAMENTE_FINALIZADO' ]);

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
*/
    // Inician funciones del catalogo de Escuelas
    public function catalogoGuardarNuevaArea($request){

        $area = new P06AreasAdscripcion();

        $area->nombre_area_adscripcion = $request['nombreArea'];
        $area->direccion_area_adscripcion = $request['direccionArea'];
        $area->save();
        return true;
    }

    public function catalogoEditarArea($request){
        P06AreasAdscripcion::query()->where('area_adscripcion_id', $request['area_ads_id'])
        ->update([ 'nombre_area_adscripcion' => $request['nombreArea'], 'direccion_area_adscripcion' => $request['direccionArea'] ]);
        return true;
    }

    public function pasarAreaAFalse($request){
        P06AreasAdscripcion::query()->where('area_adscripcion_id', $request['area_adscripcion_id'])->update([ 'activo' => false ]);
        return true;
    }
}
