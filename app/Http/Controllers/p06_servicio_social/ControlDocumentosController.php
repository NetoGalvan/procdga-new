<?php

namespace App\Http\Controllers\p06_servicio_social;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\InstanciaTarea;
use App\Models\p06_servicio_social\P06DetalleArchivos;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Detalle;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControlDocumentosController extends Controller {
    
    # ----- Configuración de fecha
    public function fecha($fecha_nueva){
        $fechaNueva = Carbon::parse($fecha_nueva);
        $meses= [
            "01"=>"Enero",
            "02"=>"Febrero",
            "03"=>"Marzo",
            "04"=>"Abril",
            "05"=>"Mayo",
            "06"=>"Junio",
            "07"=>"Julio",
            "08"=>"Agosto",
            "09"=>"Septiembre",
            "10"=>"Octubre",
            "11"=>"Noviembre",
            "12"=>"Diciembre"
        ];

        $cadenaFecha = $fechaNueva->format('d') . ' de ' . $meses[$fechaNueva->format('m')] . ' del ' . $fechaNueva->format('Y');
        return $cadenaFecha;
    }

    public function firmaDRH($role){
        return User::whereHas("roles", function($q) use ($role) {
                    $q->where("name", $role);
                })->first(['nombre', 'apellido_paterno', 'apellido_materno', 'puesto']);
    }

    # ----- FROM::T06 Descargar ficha del prestador
    public function fichaPrestador(P06ServicioSocial $servicioSocial){
        $cadenaFecha = $this->fecha(Carbon::now());
        return \PDF::loadView('p06_servicio_social.Formatos.fichaPrestador', compact('servicioSocial', 'cadenaFecha'))->download();
    }
    # ----- FROM::T06 Descargar carta de aceptación
    public function cartaAceptacion(P06ServicioSocial $servicioSocial){
        try {
            DB::beginTransaction();
            $cadenaFechaInicioSS = $this->fecha( $servicioSocial->fecha_inicio );
            $cadenaFechaFinSS = $this->fecha( $servicioSocial->fecha_fin );

            $firmaCartaInicio = $this->firmaDRH("AUTORIZADOR_CARTA_INICIO_SS");

            $servicioSocial->fecha_carta_inicio = now();
            $servicioSocial->save();

            $cadenaFecha = $this->fecha( $servicioSocial->fecha_carta_inicio );
            
            DB::commit();
            return \PDF::loadView('p06_servicio_social.Formatos.cartaAceptacion', compact('servicioSocial', 'cadenaFecha', 'firmaCartaInicio', 'cadenaFechaInicioSS', 'cadenaFechaFinSS'))->download();

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }
    # ----- FROM::T08 Descargar carta de termino
    public function cartaFinalizacion(P06ServicioSocial $servicioSocial){
        try {
            DB::beginTransaction();
            $cadenaFechaInicioSS = $this->fecha( $servicioSocial->fecha_inicio );
            $cadenaFechaFinSS = $this->fecha( $servicioSocial->fecha_fin );

            $firmaCartaFin = $this->firmaDRH('AUTORIZADOR_CARTA_TERMINO_SS');

            $servicioSocial->fecha_carta_fin = now();
            $servicioSocial->save();

            $cadenaFechaCartaFin = $this->fecha( $servicioSocial->fecha_carta_inicio );
            
            DB::commit();
            return \PDF::loadView('p06_servicio_social.Formatos.cartaTerminacion', compact('servicioSocial', 'cadenaFechaCartaFin', 'firmaCartaFin', 'cadenaFechaInicioSS', 'cadenaFechaFinSS'))->download();

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }
    # ----- FROM::T07 Registrar documentos
    public function registrarDocumentos(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea)
    {
        try {
            DB::beginTransaction();

            if ( isset($request->tipo_accion) ) 
            {
                $horasAsistencia = (isset($request->horas_asistencia) ? $request->horas_asistencia : null);

                if($request->tipo_accion != 'ABANDONO') {
                    $archivoNuevo = $request->file('file');
                    $nombreArchivo = $archivoNuevo->getClientOriginalName();
                
                    $rutaArchivo = 'p06_servicio_social/'.$servicioSocial->folio.'/'.$nombreArchivo;

                    if( P06DetalleArchivos::where('ruta_archivo', $rutaArchivo)->exists() ){
                        return [ 'estatus' => false, 'mensaje' => 'Ya existe un documento con el mismo nombre' ];
                    }
                    Storage::disk('public')->put($rutaArchivo, $archivoNuevo->getContent());
                }
                
                $detalleArchivo = new P06DetalleArchivos();
                $detalleArchivo->servicio_social_id = $servicioSocial->servicio_social_id;
                $detalleArchivo->tipo_archivo = $request->tipo_accion;
                $detalleArchivo->descripcion = $request->descripcion;
                $detalleArchivo->fecha_detalle = Carbon::now()->format('d-m-Y');
                $detalleArchivo->nombre_archivo = ($nombreArchivo ?? null);
                $detalleArchivo->ruta_archivo = ($rutaArchivo ?? null);
                $detalleArchivo->horas_asistencia = $horasAsistencia;
                $detalleArchivo->save();

                if($request->tipo_accion == 'SUBIR HORAS') {
                    $servicioSocial->horas_acumuladas = P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)
                                                                          ->where('tipo_archivo', $request->tipo_accion)
                                                                          ->get()
                                                                          ->sum('horas_asistencia');
                    $servicioSocial->save();
                } 
                $horasRestantes = ($servicioSocial->prestador->total_horas - $servicioSocial->horas_acumuladas);

                DB::commit();
                return [ 
                    'estatus' => true, 
                    'horasRestantes' => $horasRestantes,
                    'mensaje' => 'Se guardó el documento correctamente.'
                ];
            }

            $documentos = P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->orderByDesc('detalle_archivo_id')->get();
            return response()->json($documentos);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return response()->json([ "estatus" => false, "mensaje" => $th ]);
        }
    }
    # ----- FROM::T07 Registrar informes
    public function registrarInformes(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea) {
        try {
            DB::beginTransaction();
            if ( isset($request->tipo_informe) ) 
            {
                $detalle = new P06Detalle;
                $detalle->servicio_social_id = $servicioSocial->servicio_social_id;
                $detalle->fecha_comentario = date("Y-m-d",strtotime(now()));
                $detalle->comentario = $request->comentario;
                $detalle->informe = $request->tipo_informe;
                $detalle->save();

                $instancia =  $servicioSocial->instancia;
                $instancia->crearInstanciaTarea('TANOTA05', 'NOTIFICACION_NO_LEIDO');

                DB::commit();
                return response()->json([ "estatus" => true, "mensaje" => 'La Información se guardo satisfactoriamente.']);
            }
            $informes = P06Detalle::where('servicio_social_id', $servicioSocial->servicio_social_id)->orderByDesc('detalle_id')->get();
            return response()->json($informes);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return response()->json([ "estatus" => false, "mensaje" => $th ]);
        }
    }
}