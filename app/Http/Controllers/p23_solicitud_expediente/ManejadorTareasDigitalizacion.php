<?php

namespace App\Http\Controllers\p23_solicitud_expediente;

use App\Http\Traits\RegistroInstancias;
use App\Models\Instancia;
use App\Models\InstanciaTarea;
use App\Models\Proceso;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\p23_solicitud_expediente\P23Indice;
use App\Models\p23_solicitud_expediente\P23Digitalizacion;
use App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion;
use p23_digitalizacion;

trait ManejadorTareasDigitalizacion{

    use RegistroInstancias;

    protected $pathRootDigitalizacionArchivo = 'p23_digitalizacion';
    protected $directorioBase = 'p23_digitalizacion';

    public function cancelarTodo($request){
        try {
            DB::beginTransaction();
                InstanciaTarea::query()->where('instancia_id', $request->instancia['instancia_id'])->update([ 'estatus' => 'COMPLETADO' ]);
                P23Digitalizacion::query()->where('p23_digitalizacion_id', $request->p23_digitalizacion_id)->update([ 'activo' => false, 'estatus' => 'CANCELADO' ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarTareaTDIG01($digitalizacion, $datosIndice, $datosActualiza, $request, $datosDetalle){
        try {
            DB::beginTransaction();

            $digitalizacion->p23_indice_id = $datosIndice->p23_indice_id;
            $digitalizacion->numero_empleado = $datosIndice->numero_empleado;
            $digitalizacion->nombre_empleado = $datosIndice->nombre_empleado;
            $digitalizacion->apellido_paterno = $datosIndice->apellido_paterno;
            $digitalizacion->apellido_materno = $datosIndice->apellido_materno;
            $digitalizacion->rfc = $datosIndice->rfc;
            $digitalizacion->numero_expediente = $datosIndice->numero_expediente;
            $digitalizacion->ruta_archivo = $datosIndice->ruta_archivo;
            $digitalizacion->nombre_archivo = $datosIndice->nombre_archivo;
            $digitalizacion->hash_archivo = $datosIndice->hash_archivo;
            $digitalizacion->fecha_carga = $datosIndice->fecha_carga;
            $digitalizacion->anio_carga = $datosIndice->anio_carga;
            $digitalizacion->version = $datosIndice->version;
            $digitalizacion->archivo_original = $datosIndice->archivo_original;
            $digitalizacion->uploaded_by = $datosActualiza->nombre_usuario;
            $digitalizacion->uploaded_by_cn = $datosActualiza->nombre_usu . $datosActualiza->apellido_paterno . $datosActualiza->apellido_materno;
            $digitalizacion->uploaded_by_ip = $request->ip();
            $digitalizacion->created_by = $datosIndice->created_by;
            $digitalizacion->created_by_cn = $datosIndice->created_by_cn;
            $digitalizacion->created_by_bc = $datosIndice->created_by_bc;
            $digitalizacion->created_by_bc_cn = $datosIndice->created_by_bc_cn;
            $digitalizacion->created_by_title = $datosIndice->created_by_title;
            $digitalizacion->created_by_ou = $datosIndice->created_by_ou;
            $digitalizacion->created_by_ou_cn = $datosIndice->created_by_ou_cn;
            $digitalizacion->created_on = $datosIndice->created_on;
            $digitalizacion->save();

            foreach ($datosDetalle as $value) {
                $detalleDigitalizacion = new P23DetalleDigitalizacion();
                $detalleDigitalizacion->p23_digitalizacion_id = $digitalizacion->p23_digitalizacion_id;
                $detalleDigitalizacion->folio = $digitalizacion->folio;
                $detalleDigitalizacion->documento = $value->documento;
                $detalleDigitalizacion->hojas = $value->hojas;
                $detalleDigitalizacion->created_by = $datosIndice->created_by;
                $detalleDigitalizacion->created_by_cn = $datosIndice->created_by_cn;
                $detalleDigitalizacion->created_by_bc = $datosIndice->created_by_bc;
                $detalleDigitalizacion->created_by_bc_cn = $datosIndice->created_by_bc_cn;
                $detalleDigitalizacion->created_by_ou = $datosIndice->created_by_ou;
                $detalleDigitalizacion->created_by_ou_cn = $datosIndice->created_by_ou_cn;
                $detalleDigitalizacion->created_by_title = $datosIndice->created_by_title;
                $detalleDigitalizacion->created_on = now();
                $detalleDigitalizacion->created_at = now();
                $detalleDigitalizacion->updated_at = now();
                $detalleDigitalizacion->save();
            }
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'La tarea ha finalizado exitosamente' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }

    public function guardarTareaTDIG02($digitalizacion, $request, $datosCreador){
        try {
            DB::beginTransaction();
                $indiceId = DB::table('p23_indice')->insertGetId([
                    'folio' => $digitalizacion->folio,
                    'numero_empleado' => $request['numero_empleado'],
                    'nombre_empleado' => $request['nombre'],
                    'apellido_paterno' => $request['apellido_paterno'],
                    'apellido_materno' => $request['apellido_materno'],
                    'rfc' => $request['rfc'],
                    'numero_expediente' => $request['numero_expediente'],
                    'anio_ingreso' => json_encode ( $request['tablaNotas'] ),
                    'created_by' => $datosCreador->nombre_usuario,
                    'created_by_cn' => $datosCreador->nombre_usu . ' ' . $datosCreador->apellido_paterno . ' ' . $datosCreador->apellido_materno,
                    // 'created_by_bc' => $datosCreador->identificador_unidad_area,
                    'created_by_bc_cn' => $datosCreador->nombre_area,
                    'created_by_title' => $datosCreador->puesto,
                    'created_by_ou' => $datosCreador->identificador,
                    // 'created_by_ou_cn' => $datosCreador->ou,
                    'created_on' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'p23_indice_id');

                DB::table('p23_digitalizacion')
                    ->where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)
                    ->update([ 'p23_indice_id' => $indiceId,
                        'numero_empleado' => $request['numero_empleado'],
                        'nombre_empleado' => $request['nombre'],
                        'apellido_paterno' => $request['apellido_paterno'],
                        'apellido_materno' => $request['apellido_materno'],
                        'rfc' => $request['rfc'],
                        'numero_expediente' => $request['numero_expediente'],
                        'created_by' => $datosCreador->nombre_usuario,
                        'created_by_cn' => $datosCreador->nombre_usu . ' ' . $datosCreador->apellido_paterno . ' ' . $datosCreador->apellido_materno,
                        // 'created_by_bc' => $datosCreador->identificador_unidad_area,
                        'created_by_bc_cn' => $datosCreador->nombre_area,
                        'created_by_title' => $datosCreador->puesto,
                        'created_by_ou' => $datosCreador->identificador,
                        // 'created_by_ou_cn' => $datosCreador->ou,
                        'created_on' => now()
                    ]);
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'La tarea ha finalizado exitosamente' ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }

    public function actualizarDatosTDIG03( $digitalizacion, $request ){
        try {
            DB::beginTransaction();
                P23Indice::query()->where('p23_indice_id', $digitalizacion->p23_indice_id)
                                    ->update([ 'apellido_paterno' => $request['apellido_paterno'],
                                            'apellido_materno' => $request['apellido_materno'],
                                            'nombre_empleado' => $request['nombre'],
                                            'anio_ingreso' => json_encode ( $request['tablaNotas'] )
                                            ]);

                P23Digitalizacion::query()->where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)
                                    ->update([ 'apellido_paterno' => $request['apellido_paterno'],
                                            'apellido_materno' => $request['apellido_materno'],
                                            'nombre_empleado' => $request['nombre']
                                            ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    function guardarDatosDocExpediente($request, $digitalizacion) {

        $version = $digitalizacion->version ;
        $version++;

        $datosDocumento = (object) [
            "nombre_archivo" => $digitalizacion->folio,
            "hash_archivo" => hash( 'md5', $request->file('file')->getClientOriginalName() ),
            "fecha_carga" => Carbon::now()->format('d-m-Y'),
            "anio_carga" => Carbon::now()->format('Y'),
            "version" => $version,
            "archivo_original" => $request->file('file')->getClientOriginalName(),
            "uploaded_by" => $digitalizacion->created_by,
            "uploaded_by_cn" => $digitalizacion->created_by_cn,
            "uploaded_ip" => $request->ip(),
        ];

        try {
            $existeHash = P23Digitalizacion::where('hash_archivo', $datosDocumento->hash_archivo)->exists();
            if ($existeHash) {
                return [ 'estatus' => false, 'mensaje' => 'El documento que intenta subir ya existe en nuestros registros.' ];
            } else {
                if ( $this->guardarDatosDocumento($datosDocumento, $digitalizacion->p23_digitalizacion_id) ) {
                    $archivoNuevo = $request->file('file')->getContent();
                    $anio = Carbon::now('y')->year;
                    $nuevoDirectorios = $this->directorioBase . '/' . $anio;
                    $subDirectorios = Storage::allDirectories($this->directorioBase);
                    $directorioEncontrados = in_array($nuevoDirectorios, $subDirectorios);
                    if ( ! $directorioEncontrados ) {
                        Storage::makeDirectory($nuevoDirectorios);
                    }
                    $nombreArchivos = $nuevoDirectorios . '/' .$datosDocumento->archivo_original;
                    $archivosDirectorios = Storage::files($nuevoDirectorios);
                    $existeDocumentos = in_array($nombreArchivos, $archivosDirectorios);
                    if ( ! $existeDocumentos ) {
                        $archivosguardados = Storage::put($nombreArchivos, $archivoNuevo);
                        if ( ! $archivosguardados ) {
                            return ['estatus' => false, 'mensaje' => 'No se puede guardar el documento'];
                        }
                    } else {
                        return ['estatus' => false, 'mensaje' => 'Ya existe un documento con ese nombre'];
                    }
                    DB::beginTransaction();
                        P23Digitalizacion::query()->where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)->update([ 'ruta_archivo' => $nombreArchivos ]);
                        $documentos = json_decode( $request->tabla_documentos);
                        if ($documentos != null) {
                            foreach ($documentos as $value) {
                                $detalleDigitalizacion = new P23DetalleDigitalizacion();
                                $detalleDigitalizacion->p23_digitalizacion_id = $digitalizacion->p23_digitalizacion_id;
                                $detalleDigitalizacion->folio = $digitalizacion->folio;
                                $detalleDigitalizacion->documento = $value->tipo;
                                $detalleDigitalizacion->hojas = $value->fojas;
                                $detalleDigitalizacion->created_by = $digitalizacion->created_by;
                                $detalleDigitalizacion->created_by_cn = $digitalizacion->created_by_cn;
                                $detalleDigitalizacion->created_by_bc = $digitalizacion->created_by_bc;
                                $detalleDigitalizacion->created_by_bc_cn = $digitalizacion->created_by_bc_cn;
                                $detalleDigitalizacion->created_by_ou = $digitalizacion->created_by_ou;
                                $detalleDigitalizacion->created_by_ou_cn = $digitalizacion->created_by_ou_cn;
                                $detalleDigitalizacion->created_by_title = $digitalizacion->created_by_title;
                                $detalleDigitalizacion->created_on = now();
                                $detalleDigitalizacion->created_at = now();
                                $detalleDigitalizacion->updated_at = now();
                                $detalleDigitalizacion->save();
                            }
                        }
                    DB::commit();
                    return ['estatus' => true,'mensaje' => 'El documento fue guardado con éxito.'];
                } else {
                    return [ 'estatus' => false, 'mensaje' => 'Ocurrio un error al guardar la información' ];
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return ['estatus' => false, 'mensaje' => 'No se pudo guardar el documento ' . $th];
        }
    }

    function guardarDatosDocumento($datosDocumento, $digitalizacion_id) {
        return P23Digitalizacion::query()->where('p23_digitalizacion_id', $digitalizacion_id)
        ->update([
                'nombre_archivo' => $datosDocumento->nombre_archivo.".pdf",
                'hash_archivo' => $datosDocumento->hash_archivo,
                'fecha_carga' => $datosDocumento->fecha_carga,
                'anio_carga' => $datosDocumento->anio_carga,
                'version' => $datosDocumento->version,
                'archivo_original' => $datosDocumento->archivo_original,
                'uploaded_by' => $datosDocumento->uploaded_by,
                'uploaded_by_cn' => $datosDocumento->uploaded_by_cn,
                'uploaded_by_ip' => $datosDocumento->uploaded_ip ]);
    }

    public function guardarDocumentoDisk( $file, $nombreDocumentoOriginal) {
        $path = $file->storeAs(
            $this->directorioBase, $nombreDocumentoOriginal
        );
        return $path;
    }

    function eliminarFichaIndice( $digitalizacion, $request ) {
        try {
            DB::beginTransaction();
                P23Indice::query()->where('p23_indice_id', $digitalizacion->p23_indice_id)->delete();
                P23Digitalizacion::query()->where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)
                                ->update([ 'comentarios_eliminacion' => $request->causa_eliminacion, 'estatus' => "PREMATURAMENTE COMPLETADO" ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function finalizarProceso($digitalizacion, $estatus){
        try {
            DB::beginTransaction();
                P23Digitalizacion::query()->where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)->update([ 'activo' => false, 'estatus' => 'COMPLETADO' ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }
}
