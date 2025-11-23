<?php

namespace App\Http\Controllers\p06_servicio_social;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Traits\RegistroInstancias;

use App\Models\User;
use App\Models\InstanciaTarea;
use App\Models\p06_servicio_social\P06DetalleArchivos;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06Detalle;
use App\Models\p06_servicio_social\P06Instituciones;
use App\Models\p06_servicio_social\P06AreasAdscripcion;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServicioSocialController extends Controller {
    use RegistroInstancias;

    public function configurar_hora_24hrs($hora) { #horario de 12 hrs -> 24 hrs
        $horario_24 = [
            '1' => '13', '2' => '14', '3' => '15', 
            '4' => '16', '5' => '17', '6' => '18', 
            '7' => '19', '8' => '20', '9' => '21', 
            '10' => '22', '11' => '23', '12' => '00'
        ];

        $simpHora = str_replace([' PM', ' AM'], '', $hora);
        $particionarHr = explode(':',$simpHora);

        if ( strpos($hora, 'PM') !== false ) { 
            if ( strpos($hora, '12') !== false ) return $simpHora;
            return $horario_24[$particionarHr[0]].':'.$particionarHr[1]; 

        } else {  
            if ( strpos($hora, '12') !== false ) return $horario_24[$particionarHr[0]].':'.$particionarHr[1]; 
            return $simpHora;
        }
    }

    public function descripcion() { return view('p06_servicio_social.tareas.descripcion'); }

    public function iniciarProceso() {
        try {
            DB::beginTransaction();
                $servicioSocial = P06ServicioSocial::create([
                    "area_id" => Auth::user()->area_id,
                    "nombre_area" => Auth::user()->area->nombre,
                    "estatus" => "EN_PROCESO"
                ]);
                $instancia = $this->crearInstancia("servicio_social", $servicioSocial, Auth::user()->area);
                $instanciaTarea = $instancia->crearInstanciaTarea("T01", "NUEVO");

            DB::commit();
            return redirect()->route('servicio.social.seleccionar.prestador', [$servicioSocial, $instanciaTarea])->with("success", "El proceso se creó correctamente.");
        } catch (\Exception $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
        }
    }

    #BEGIN::TAREAS ->
    # ----- TAREA 01
    public function seleccionarPrestador(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea) {
        $instancia =  $servicioSocial->instancia;
        if ($request->isMethod('post')) {   
            try {
                DB::beginTransaction();

                $prestador_id = intval($request->seleccion);
                P06Prestador::where('prestador_id', $prestador_id)->update([ 'estatus_prestador' => 'EN_PROCESO' ]); #Actualizar prestador

                $servicioSocial->prestador_id = $prestador_id; #Actualizar servicio social
                $servicioSocial->estatus = 'EN_PROCESO';
                $servicioSocial->save();

                $instanciaTarea->updateEstatus('COMPLETADO'); #Actualizar estatus de la instancia
                $nuevaTarea = $instancia->crearInstanciaTarea('T02', 'NUEVO'); #Crear nueva instancia

                DB::commit();
                return redirect()->route('servicio.social.asignar.datos.entrevista', [$servicioSocial, $nuevaTarea->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }
        $queryCandidatos = P06Prestador::where('activo', true)->where( function($q) {
                                            $q->whereNull('estatus_prestador')->orWhereIn('estatus_prestador', ['RECHAZADO', 'PROCESO_CANCELADO']);
                                        })->get();
        
        return view('p06_servicio_social.tareas.T01_seleccionarPrestador', compact('servicioSocial', 'queryCandidatos', 'instanciaTarea'));
    }
    # ----- TAREA 02
    public function asignarDatosEntrevista(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){
        $instancia =  $servicioSocial->instancia;

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                $servicioSocial->fecha_cita = $request->fecha_cita;
                $servicioSocial->hora_cita = $this->configurar_hora_24hrs( $request->hora_cita );
                $servicioSocial->lugar_cita = $servicioSocial->area->nombre;
                $servicioSocial->save(); #Guardar fecha, hora y lugar de la cita

                $instanciaTarea->updateEstatus('COMPLETADO'); #Actualizar estatus de la instancia
                $nuevaTarea = $instancia->crearInstanciaTarea('T03', 'NUEVO'); #Crear nueva instancia
                $instancia->crearInstanciaTarea('TANOTA01', 'NOTIFICACION_NO_LEIDO'); #Crear TANOTA01 - Notificación cita examen psicométrico

                DB::commit();
                return redirect()->route('servicio.social.captura.resultado.entrevista', [$servicioSocial, $nuevaTarea->instancia_tarea_id])->with("success", "La tarea finalizó correctamente.");
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p06_servicio_social.tareas.T02_asignarDatosEntrevista', compact('servicioSocial', 'instanciaTarea'));
    }
    # ----- TAREA 03
    public function capturaResultadoEntrevista(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){
        $instancia =  $servicioSocial->instancia;

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                    P06Prestador::where('prestador_id', $servicioSocial->prestador_id)->update([ 'estatus_prestador' => $request->EstatusCandidato ]);

                    if ($request->EstatusCandidato == "ACEPTADO") {

                        $instanciaTarea->updateEstatus('COMPLETADO'); #Actualizar estatus de la instancia
                        $nuevaTarea = $instancia->crearInstanciaTarea('T04', 'NUEVO'); #Crear nueva instancia

                        $mensaje = 'La tarea finalizó correctamente';
                        $ruta = route('servicio.social.asignacion.labores', [$servicioSocial, $nuevaTarea->instancia_tarea_id] );
                    }

                    if ($request->EstatusCandidato == "RECHAZADO") {

                        $servicioSocial->estatus = 'RECHAZADO';
                        $servicioSocial->activo = false;
                        $servicioSocial->save();
                        
                        $instanciaTarea->updateEstatus('COMPLETADO');

                        $mensaje = 'El candidato fue rechazado. El proceso ha terminado correctamente.';
                        $ruta = route('tareas');
                    }

                DB::commit();
                return redirect($ruta)->with("success", $mensaje);
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p06_servicio_social.tareas.T03_aceptacionCandidato', compact('servicioSocial', 'instanciaTarea'));

    }
    # ----- TAREA 04
    public function asignacionLabores(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){
        $instancia =  $servicioSocial->instancia;
        $areasAdscripcion = P06AreasAdscripcion::where('activo', true)->orderBy('area_adscripcion_id', 'asc')->get();

        if ($request->isMethod('post')) {

            try {
                DB::beginTransaction();
                $horario = $this->configurar_hora_24hrs( $request->hora_entrada ).' - '.$this->configurar_hora_24hrs( $request->hora_salida );

                $servicioSocial->estatus = 'EN_PROCESO';
                $servicioSocial->fecha_inicio = $request->fecha_inicio;
                $servicioSocial->fecha_fin = $request->fecha_fin;
                $servicioSocial->horario = $horario;
                $servicioSocial->area_adscripcion_id = $request->area_adscripcion_id;
                $servicioSocial->subdireccion_ua = $request->subdireccion_ua;
                $servicioSocial->unidad_departamental_ua = $request->unidad_departamental_ua;
                $servicioSocial->jefe = $request->jefe;
                $servicioSocial->puesto_jefe = $request->puesto_jefe;
                $servicioSocial->telefono_jefe = $request->telefono_jefe;
                $servicioSocial->actividades = $request->actividades;
                $servicioSocial->fecha_inicio_monitoreo = now();
                $servicioSocial->direccion_ejecutiva = $request->direccion_ejecutiva;
                $servicioSocial->coordinacion = $request->coordinacion;
                $servicioSocial->telefono_ext_jefe = $request->telefono_ext_jefe;
                $servicioSocial->save();

                $instancia->crearInstanciaTarea('T05', 'NUEVO');
                $instancia->crearInstanciaTarea('TANOTA06', 'NOTIFICACION_NO_LEIDO');
                $instanciaTarea->updateEstatus('COMPLETADO');
                
                DB::commit();
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        $servicioSocial->fecha_inicio=((!is_null($servicioSocial->fecha_inicio)) ? date_format(Carbon::parse($servicioSocial->fecha_inicio), 'd/m/Y') : '');
        $servicioSocial->fecha_fin=((!is_null($servicioSocial->fecha_fin)) ? date_format(Carbon::parse($servicioSocial->fecha_fin), 'd/m/Y') : '');
        
        $servicioSocial->horario = ($servicioSocial->horario ?? $servicioSocial->prestador->horario_tentativo);

        return view('p06_servicio_social.tareas.T04_asignacionFunciones', compact('servicioSocial', 'instanciaTarea', 'areasAdscripcion'));
    }
    # ----- TAREA 05
    public function impresionCartaInicio(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea) {
        $instancia =  $servicioSocial->instancia;

        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                # Guardar observaciones    
                if ( !is_null($request->observaciones_carta_inicio) ) {
                    $servicioSocial->observaciones_carta_inicio = $request->observaciones_carta_inicio;
                    $servicioSocial->save();
                    DB::commit();
                    return response()->json([ 'mensaje' => "Datos Guardados Correctamente!" ]);
                }
                # Guardar fecha de la confirmación de la firma DRH
                if ( $request->carta_firmada ) {

                    if(!is_null($servicioSocial->fecha_carta_inicio)) {
                        $servicioSocial->fecha_firma_drh_inicio = Carbon::now();
                        $servicioSocial->save();
                        DB::commit();
                        return response()->json([ 'estatus' => true ]);
                    }

                    return response()->json([ 'estatus' => false, 'mensaje' => "Aún no ha generado la carta de inicio, debe hacerlo para poder continuar." ]);
                }
                
            }

            if ($request->isMethod('post')) 
            {
                $instanciaTarea->updateEstatus('COMPLETADO');
                $instancia->crearInstanciaTarea('T06', 'NUEVO');
                $instancia->crearInstanciaTarea('T08', 'NUEVO');
                $instancia->crearInstanciaTarea('TANOTA02', 'NOTIFICACION_NO_LEIDO');

                P06Prestador::where('prestador_id', $servicioSocial->prestador_id)->update([ 'estatus_prestador' => 'EN_CURSO' ]);

                DB::commit();
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            }
        } catch (\Exception $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
        }

        return view('p06_servicio_social.tareas.T05_impresionCartaInicio', compact('servicioSocial', 'instanciaTarea'));
    }
    # -----------
    public function regresarCorrecciones(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea) {
        $instancia =  $servicioSocial->instancia;

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();

                $servicioSocial->estatus = "EN_CORRECCION";
                $servicioSocial->correcciones = $request->correcciones;
                $servicioSocial->save();

                $instanciaTarea->updateEstatus('RECHAZADO');
                $instanciaTarea->motivo_rechazo = $request->correcciones;
                $instanciaTarea->save();

                $instancia->crearInstanciaTarea('T04', 'EN_CORRECCION');

                DB::commit();
                return redirect()->route('tareas')->with("success", "Se ha regresado la tarea para sus correcciones.");

            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }
    }
    # ----- TAREA 06
    public function registrarEventos(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia =  $servicioSocial->instancia;

        $totalDias = DB::select("SELECT CAST(fecha_fin-fecha_inicio AS INTEGER) as fecha FROM p06_servicio_social
                                WHERE servicio_social_id =".$servicioSocial['servicio_social_id']);

        $diasTranscurridos = DB::select("SELECT CAST(TO_CHAR(NOW()-fecha_inicio :: DATE, 'dd') AS INTEGER) AS Dias FROM p06_servicio_social
                                 WHERE servicio_social_id =".$servicioSocial['servicio_social_id']);

        $diasFaltantes = $totalDias[0]->fecha - $diasTranscurridos[0]->dias;

        $tipos = [
            "subir_horas" => "SUBIR HORAS", 
            "solicitar_baja" => "SOLICITAR BAJA",
            "abandono" => "ABANDONO"
        ];
        $informes = [
            "informe_uno" => "1ER INFORME",
            "informe_dos" => "2DO INFORME",
            "informe_tres" => "3ER INFORME",
        ];

        if ($request->isMethod('post')) 
        {
            try {
                DB::beginTransaction();

                P06Prestador::where('prestador_id', $servicioSocial->prestador_id)->update([ 'estatus_prestador' => $request->opcion ]);
                $instanciaTarea->updateEstatus('COMPLETADO');
                
                if( $request->opcion == 'BAJA' || $request->opcion == 'ABANDONO' ){
                    $servicioSocial->estatus = 'CANCELADO';
                    $servicioSocial->save();
                    $instancia->crearInstanciaTarea('TANOTA04', 'NOTIFICACION_NO_LEIDO');
                } 

                $mensaje = '';
                if( $request->opcion == 'BAJA' ){
                    $mensaje = 'El candidato fue dado de baja, la tarea finalizó correctamente.';
                } 

                if( $request->opcion == 'ABANDONO' ){
                    $mensaje = 'La tarea finalizó correctamente ya que el candidato abandono el proceso de servicio social.';
                } 
                
                if( $request->opcion == 'LIBERADO' ) { 
                    $instancia->crearInstanciaTarea('T07', 'NUEVO'); 
                    $mensaje = "La tarea finalizó correctamente.";
                }
                
                DB::commit();
                return redirect()->route('tareas')->with("success", $mensaje);

            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p06_servicio_social.tareas.T06_registrarEventos', compact('servicioSocial', 'instanciaTarea', 'diasFaltantes', 'informes', 'tipos'));
    }
    # ----- TAREA 08
    public function validarLiberacionBaja(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia =  $servicioSocial->instancia;
        $documentosRecibidos = P06DetalleArchivos::where('servicio_social_id', $servicioSocial->servicio_social_id)->orderBy('detalle_archivo_id', 'desc')->get();
        $opcionesValidacion = ['LIBERADO', 'BAJA', 'ABANDONO'];

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                
                $servicioSocial->validacion = $request->validacion;
                $servicioSocial->save();
                $instanciaTarea->updateEstatus('COMPLETADO');

                DB::commit();
                return redirect()->route('tareas')->with("success", "La tarea finalizó correctamente.");
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        }

        return view('p06_servicio_social.tareas.T08_validarLiberacionBaja', compact('servicioSocial', 'instanciaTarea', 'documentosRecibidos', 'opcionesValidacion'));
    }
    # ----- TAREA 07
    public function impresionCartaFinalizacion(Request $request, P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){

        $instancia =  $servicioSocial->instancia;

            try {
                DB::beginTransaction();

                if ($request->ajax()) #Ajax para -> Actualizar funcionario, Agregar observaciones carta fin y/o Confirmar carta firmada
                {
                    # Actualizar funcionario
                    if ( isset($request->nombre_funcionario) )  {
                        P06Prestador::where('prestador_id', $servicioSocial->prestador_id)->update([ 
                            'nombre_funcionario' => $request->nombre_funcionario,
                            'puesto_funcionario' => $request->puesto_funcionario,
                            'telefono_funcionario' => $request->telefono_funcionario,
                            'actualizo_funcionario_carta_termino' => true
                        ]);
                        DB::commit();
                        return response()->json(['mensaje' => "Datos guardados correctamente.", "prestador" => $servicioSocial->prestador]);
                    }
                    # Agregar observaciones
                    if ( !is_null($request->observaciones_carta_fin) ) {
                        $servicioSocial->observaciones_carta_fin = $request->observaciones_carta_fin;
                        $servicioSocial->save();

                        DB::commit();
                        return response()->json(['mensaje' => "Se guardó la observación correctamente."]);
                    }
                    # Confirmar carta firmada
                    if ( $request->carta_firmada ) { 
                        if ( is_null($servicioSocial->fecha_carta_fin) ) {
                            return response()->json([ 'estatus' => false, 'mensaje' => "Aún no ha generado la carta de termino, debe hacerlo para poder continuar." ]);
                        
                        } else {
                            $servicioSocial->fecha_firma_drh_fin = Carbon::now();
                            $servicioSocial->save();

                            DB::commit();
                            return response()->json([ 'estatus' => true ]);
                        }
                    }
                }

                if ($request->isMethod('post')) 
                {
                    $servicioSocial->estatus = 'COMPLETADO';
                    $servicioSocial->save();

                    $instanciaTarea->updateEstatus('COMPLETADO');
                    $instancia->crearInstanciaTarea('TANOTA03', 'NOTIFICACION_NO_LEIDO'); 

                    DB::commit();
                    return redirect()->route('tareas')->with("success", "El proceso ha finalizado exitosamente");
                }
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error(__METHOD__." -> ".$th->getMessage());
                return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
            }
        return view('p06_servicio_social.tareas.T07_impresionCartaFinalizacion', compact('servicioSocial', 'instanciaTarea'));
    }
    #END::TAREAS <-

    #FROM::T04 Obtener areas de adscripción
    public function getDomicilioAreaAds(Request $request) {
        $area = P06AreasAdscripcion::where('area_adscripcion_id', $request->area_adscripcion_id)->first();
        return response()->json($area);
    }
    
    #FROM::T01 - T02 "Finalizar proceso"
    public function finalizarProceso(P06ServicioSocial $servicioSocial, InstanciaTarea $instanciaTarea){
        try {
            DB::beginTransaction();
                $instanciaTarea->updateEstatus('CANCELADO'); // #Actualizar el estatus de la instancia
                if( !is_null($servicioSocial->prestador_id) ) P06Prestador::where('prestador_id', $servicioSocial->prestador_id)->update([ 'estatus_prestador' => 'PROCESO_CANCELADO' ]);
                
                #Actualizar proceso del servicio social
                $servicioSocial->activo = false;
                $servicioSocial->estatus = 'CANCELADO';
                $servicioSocial->save();   

            DB::commit();
            return redirect()->route('procesos')->with("success", "El proceso se ha cancelado correctamente.");
        } catch (\Exception $th) {
            DB::rollback();
            Log::error(__METHOD__." -> ".$th->getMessage());
            return redirect()->back()->with("error", "Surgio algún percance, comuniquese con el administrador");
        }
    }
}