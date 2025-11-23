<?php

namespace App\Http\Controllers\p23_solicitud_expediente;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;

use App\Models\InstanciaTarea;
use App\Models\p23_solicitud_expediente\P23Digitalizacion;
use App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion;
use App\Models\p23_solicitud_expediente\P23Indice;

use App\Models\historico\lbpm_dga\p23_solicitud_expediente\HistoricoP23Indice;

use Carbon\Carbon;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use League\Flysystem\FileNotFoundException as FileDownload;

class DigitalizacionArchivoController extends Controller
{
    use RegistroInstancias;

    public function descripcion() { return view('p23_digitalizacion_archivo.tareas.descripcion'); }

    public function iniciarProceso(Request $request){

        try {
            $user = Auth::user();
            DB::beginTransaction();

            $digitalizacion = P23Digitalizacion::create([
                'estatus' => 'EN_PROCESO',
                'area_creadora_id' => $user->area_id
            ]);
            $instancia = $this->crearInstancia('digitalizacion_archivo', $digitalizacion, Auth::user()->area);
            $instanciaTarea = $instancia->crearInstanciaTarea('TDIG01', 'NUEVO');
            $mensaje = 'Se ha iniciado correctamente el proceso, será dirigido a la primer tarea';

            DB::commit();
            return redirect()->route('digitalizacion.archivos.buscar.datos.expediente', [$digitalizacion, $instanciaTarea])->with("success", "El proceso se creó correctamente.");

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }
#BEGIN::TAREA 01
    public function buscarDatosExpediente(Request $request, P23Digitalizacion $digitalizacion, InstanciaTarea $instanciaTarea) {

        $instancia =  $digitalizacion->instancia;
        $indiceDigitalizacion = P23Indice::query()->where('activo', true)->orderBy(DB::raw("concat(apellido_paterno, ' ', apellido_materno, ' ', nombre_empleado)"))->get();

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();

                $instanciaTarea->updateEstatus('COMPLETADO');
                $regresa = $instancia->crearInstanciaTarea('TDIG02', 'NUEVO');

                DB::commit();
                return redirect()->route('digitalizacion.archivos.creacion.expediente', [$digitalizacion, $regresa->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");

            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p23_digitalizacion_archivo.tareas.TDIG01_buscarDatosExpediente', compact('digitalizacion', 'instanciaTarea', 'indiceDigitalizacion'));
    }

    public function expedienteEncontrado(P23Digitalizacion $digitalizacion, InstanciaTarea $instanciaTarea, $noExpediente) {
        try {
            DB::beginTransaction();

            $instancia =  $digitalizacion->instancia;
            $user = Auth::user();

            $expEncontrado = P23Digitalizacion::where('numero_expediente', $noExpediente)->where('expediente_actual', true)->first();

            P23Indice::where('numero_expediente', $noExpediente)->update(['folio' => $digitalizacion->folio]);

            $digitalizacion->update([ 
                'p23_indice_id' => $expEncontrado->p23_indice_id,
                'numero_empleado' => $expEncontrado->numero_empleado,
                'nombre_empleado' => $expEncontrado->nombre_empleado,
                'apellido_paterno' => $expEncontrado->apellido_paterno,
                'apellido_materno' => $expEncontrado->apellido_materno,
                'rfc' => $expEncontrado->rfc,
                'numero_expediente' => $expEncontrado->numero_expediente,
                'creado_por' => $user->nombre_usuario,
                'creado_por_nombre' => $user->nombre_completo,
                'creado_por_puesto' => $user->puesto,
                "ruta_archivo" => $expEncontrado->ruta_archivo,
                "nombre_archivo" => $expEncontrado->nombre_archivo,
                //"hash_archivo" => $expEncontrado->hash_archivo,
                "fecha_carga" => $expEncontrado->fecha_carga,
                "version" => $expEncontrado->version,
                "archivo_original" => $expEncontrado->archivo_original,
                "subido_por" => $expEncontrado->subido_por,
                "subido_por_usuario" => $expEncontrado->subido_por_usuario,
                "subido_por_ip" => $expEncontrado->subido_por_ip
            ]);

            P23DetalleDigitalizacion::where('p23_digitalizacion_id', $expEncontrado->p23_digitalizacion_id)
            ->update([
                'p23_digitalizacion_id' => $digitalizacion->p23_digitalizacion_id,
                'folio' => $digitalizacion->folio,
            ]);

            $expEncontrado->update([ 'expediente_actual' => false ]);

            $instanciaTarea->updateEstatus('COMPLETADO');
            $regresa = $instancia->crearInstanciaTarea('TDIG03', 'NUEVO');

            DB::commit();
            return redirect()->route('digitalizacion.archivos.actualizacion.expediente', [$digitalizacion, $regresa->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
        }
    }
#END::TAREA 01

#BEGIN::TAREA 02
    public function creacionExpediente(Request $request, P23Digitalizacion $digitalizacion, InstanciaTarea $instanciaTarea) {
    
        #BEGIN::Comprobar existencia
        if ($request->ajax()) {
            $respuesta = ['estatus' => true, 'mensaje' => ''];

            #BEGIN::Existe empleado con expediente
            if( isset($request->rfc) ) {
                $existeRFC = P23Indice::where('rfc', $request->rfc)->where('activo', true)->first();

                if( !is_null($existeRFC) ) {
                    $nombreCompleto = $existeRFC->nombre_empleado.' '.$existeRFC->apellido_paterno.' '.$existeRFC->apellido_materno;
                    $respuesta = ['estatus' => false, 'mensaje' => '<b>'.$nombreCompleto.'</b><br> cuenta con un expediente'];
                } 
            }
            #END::Existe empleado con expediente

            #BEGIN::Existe expediente registrado 
            if( isset($request->no_expediente) ) {
                $existeNoExp = P23Indice::where('numero_expediente', $request->no_expediente)->where('activo', true)->exists();

                if( $existeNoExp ) $respuesta = ['estatus' => false, 'mensaje' => $request->no_expediente];
            }
            #END::Existe expediente registrado
            
            return response()->json( $respuesta );
        }
        #END::Comprobar existencia

        if ($request->isMethod('post')) {
            $instancia =  $digitalizacion->instancia;
            $user = Auth::user();

            try {
                DB::beginTransaction();
                $indiceTB = P23Indice::create([
                    'area_creadora_id' => $digitalizacion->area_creadora_id,
                    'folio' => $digitalizacion->folio,
                    'numero_empleado' => $request->numero_empleado,
                    'nombre_empleado' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'rfc' => $request->rfc,
                    'numero_expediente' => $request->numero_expediente,
                    'notas' => $request->notas, //notas
                    'creado_por' => $user->nombre_usuario,
                    'creado_por_nombre' => $user->nombre_completo,
                    'creado_por_puesto' => $user->puesto,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $digitalizacion->update([ 
                    'p23_indice_id' => $indiceTB->p23_indice_id,
                    'numero_empleado' => $request->numero_empleado,
                    'nombre_empleado' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'rfc' => $request->rfc,
                    'numero_expediente' => $request->numero_expediente,
                    'creado_por' => $user->nombre_usuario,
                    'creado_por_nombre' => $user->nombre_completo,
                    'creado_por_puesto' => $user->puesto,
                ]);

                $instanciaTarea->updateEstatus('COMPLETADO');
                $regresa = $instancia->crearInstanciaTarea('TDIG03', 'NUEVO');

                DB::commit();
                return redirect()->route('digitalizacion.archivos.actualizacion.expediente', [$digitalizacion, $regresa->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");

            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p23_digitalizacion_archivo.tareas.TDIG02_crearExpediente', compact('digitalizacion', 'instanciaTarea'));
    }
#END::TAREA 02

#BEGIN::TAREA 03
    public function actualizacionExpediente(Request $request, P23Digitalizacion $digitalizacion, InstanciaTarea $instanciaTarea) {

        $instancia =  $digitalizacion->instancia;
        $p23Indice = P23Indice::find( $digitalizacion->p23_indice_id );

        #BEGIN::ACTUALIZAR NOTAS
        if ( $request->ajax() ) {
            if ( isset($request->dataNotas) ) {
                $p23Indice->notas = $request->dataNotas;
                $p23Indice->save();
            
                 return response()->json(["actualizarNotas" => $p23Indice->notas ]);
            }   
        }
        #END::ACTUALIZAR NOTAS

        $notas = ( !is_null($p23Indice->notas) ) ? json_decode( $p23Indice->notas ) : [];
        $descripcionesDocumento = P23DetalleDigitalizacion::where('folio', $digitalizacion->folio)
                                                            ->where('activo', true)
                                                            ->orderBy('documento')
                                                            ->get();

        $descripDocumentoFalse = P23DetalleDigitalizacion::where('folio', $digitalizacion->folio)
                                                            ->where('activo', false)
                                                            ->orderBy('documento')
                                                            ->get();
        
        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                    
                $mensaje = '';
                if ($request->check_borrar_expediente == "on") {
                #BEGIN::Borrar Expediente
                    P23Indice::where('p23_indice_id', $digitalizacion->p23_indice_id)->delete();
                    P23DetalleDigitalizacion::where('p23_digitalizacion_id', $digitalizacion->p23_digitalizacion_id)->update([ 'activo' => false ]);
                    Storage::deleteDirectory('public/p23_digitalizacion/expediente_'.$digitalizacion->numero_expediente);

                    $digitalizacion->update([
                        'activo' => false,
                        'expediente_actual' => false,
                        'comentarios_eliminacion' => $request->causa_eliminacion, 
                        'estatus' => "RECHAZADO" 
                    ]);

                    $instanciaTarea->updateEstatus('RECHAZADO');
                    $mensaje = 'La ficha del expediente se eliminó correctamente.';
                #END::Borrar Expediente
                } else {
                   $digitalizacion->update([ 'activo' => false, 'estatus' => 'COMPLETADO' ]);
                   $instanciaTarea->updateEstatus('COMPLETADO');

                   $mensaje = 'El proceso finalizo correctamente.';
                }

                DB::commit();
                return redirect()->route('tareas')->with("success", $mensaje);
            
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p23_digitalizacion_archivo.tareas.TDIG03_actualizacionExpediente', compact('digitalizacion', 'instanciaTarea', 'notas', 'descripcionesDocumento', 'descripDocumentoFalse'));
    }

    public function guardarDocumento(Request $request, P23Digitalizacion $digitalizacion) {

        $user = Auth::user();
        $version = $digitalizacion->version ;
        $version++;

        $nombreArchivo = $digitalizacion->numero_empleado.'_'.$digitalizacion->numero_expediente.'_'.($version < 10 ? '0'.$version : $version).'.pdf';
        $rutaArchivo = 'p23_digitalizacion/expediente_'.$digitalizacion->numero_expediente.'/'.$nombreArchivo;

        $datosDocumento = [
            "ruta_archivo" => $rutaArchivo,
            "nombre_archivo" => $nombreArchivo,
            //"hash_archivo" => hash( 'md5', $request->file('file')->getClientOriginalName() ),
            "fecha_carga" => Carbon::now()->format('d-m-Y'),
            "version" => $version,
            "archivo_original" => $request->file('file')->getClientOriginalName(),
            "subido_por" => $digitalizacion->creado_por,
            "subido_por_usuario" => $digitalizacion->creado_por_nombre,
            "subido_por_ip" => $request->ip()
        ];

        try {
            DB::beginTransaction();

            $digitalizacion->update( $datosDocumento );
            Storage::disk('public')->put($rutaArchivo, $request->file('file')->getContent()); 

            foreach (json_decode($request->descripciones_del_documento) as $descripcion_doc) {
                $descipcionExp = P23DetalleDigitalizacion::where('folio', $digitalizacion->folio)->where('documento', $descripcion_doc->tipo)->first();

                if( !is_null( $descipcionExp ) ) {
                    P23DetalleDigitalizacion::where('folio', $digitalizacion->folio)->where('documento', $descripcion_doc->tipo)->update([
                        'area_creadora_id' => $digitalizacion->area_creadora_id,
                        'activo' => true,
                        'creado_por' => $user->nombre_usuario,
                        'creado_por_nombre' => $user->nombre_completo,
                        'creado_por_puesto' => $user->puesto,
                        'hojas' => $descripcion_doc->fojas,
                    ]);

                } else {
                    P23DetalleDigitalizacion::create([
                        'p23_digitalizacion_id' => $digitalizacion->p23_digitalizacion_id,
                        'area_creadora_id' => $digitalizacion->area_creadora_id,
                        'creado_por' => $user->nombre_usuario,
                        'creado_por_nombre' => $user->nombre_completo,
                        'creado_por_puesto' => $user->puesto,
                        'folio' => $digitalizacion->folio,
                        'documento' => $descripcion_doc->tipo,
                        'hojas' => $descripcion_doc->fojas,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            $detallesExp = P23DetalleDigitalizacion::where('folio', $digitalizacion->folio)
                                                    ->where('activo', true)
                                                    ->orderBy('documento')
                                                    ->get(['documento', 'hojas']);

            DB::commit();
            return [
                'estatus' => true,
                'mensaje' => 'El documento se guardó correctamente.', 
                'detalles_exp' => $detallesExp, 
                'ruta_archivo' => $digitalizacion->ruta_archivo,
                'nombre_archivo' => $digitalizacion->nombre_archivo
            ];
            
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return ['estatus' => false, 'mensaje' => 'Surgio un problema al guardar el documento, comuniquese con el administrador'];
        }
    }
#END::TAREA 03

    public function cancelarProceso(P23Digitalizacion $digitalizacion, InstanciaTarea $instanciaTarea){
        try {
            DB::beginTransaction();
                $instanciaTarea->update([ 'estatus' => 'CANCELADO' ]);
                $digitalizacion->update([ 'activo' => false, 'expediente_actual' => false, 'estatus' => 'CANCELADO' ]);
            DB::commit();
            return redirect()->route('procesos')->with("success", "El proceso se ha cancelado correctamente.");

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
        }
    }
}
