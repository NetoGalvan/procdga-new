<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Area;
use App\Models\Instancia;
use App\Models\InstanciaTarea;
use App\Models\Proceso;
use App\Models\Tarea;
use App\Models\Municipio;

use App\Models\p06_servicio_social\P06AreasAdscripcion;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Prestador;

use App\Models\historico\lbpm_dga\HistoricoInstancia;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoServicioSocial;
use App\Models\historico\lbpm_dga\p06_servicio_social\HistoricoPrestador;

use Spatie\Permission\Models\Role;

class HistoricoP06Seeder extends Seeder
{
    public function run() {
        $remplazar = ['á' => 'Á', 'é' => 'É', 'í' => 'Í', 'ó' => 'Ó', 'ú' => 'Ú', 'ñ' => 'Ñ'];
        $removerAcentos = ['Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U'];

        $tipoPrestador = [
            'servicio social' => 'SERVICIO SOCIAL',
            'prácticas profesionales' => 'PRÁCTICAS PROFESIONALES'
        ];
        $estatus = ['WORKING' => 'EN_PROCESO'];
        $paymentEstatus = [
            'OK' => 'ACEPTADO',
            'NO' => null,
            'PAGO_PARCIAL' => 'ACEPTADO',
            'ELIMINAR DE NOMINA' => 'ELIMINAR_DE_NOMINA',
        ];

        #Conectar a la B.D. historica
        $db_old_connected = false;
        try {
                DB::connection('lbpm_dga')->getPdo();
                $db_old_connected = true;
            
            } catch (\Exception $e) { }


        if( $db_old_connected ) {
            $historico_servicio_social = HistoricoServicioSocial::where('work_status', 'WORKING')->whereNotNull('nombre_prestador')->orderBy('id_p06')->get();

            if( !empty($historico_servicio_social) ){

                #BEGIN::CATALOGO - AREAS DE ADSCRIPCIÓN
                $this->catAreasAdscripcion($historico_servicio_social, $remplazar);
                #END::CATALOGO - AREAS DE ADSCRIPCIÓN

                #BEGIN::CATALOGO - PROGRAMAS
                //$this->catProgramas($historico_servicio_social, $remplazar);
                #END::CATALOGO - PROGRAMAS

                foreach($historico_servicio_social as $historico) {
                    $area = Area::firstWhere('identificador', $historico->id_unidad_administrativa);

                    #Configurar campos
                    $lugar_cita = strtr( mb_strtoupper( $historico->lugar_cita ), $remplazar);
                    $actividades = strtr( mb_strtoupper( $historico->actividades ), $remplazar);
                    $nombre_jefe = strtr( mb_strtoupper( $historico->jefe ), $remplazar);
                    $puesto_jefe = strtr( mb_strtoupper( $historico->puesto_jefe ), $remplazar);
                    $nombre_drh = strtr( mb_strtoupper( $historico->nombre_drh ), $remplazar);
                    $correcciones = strtr( mb_strtoupper( $historico->rechazo_som ), $remplazar);
                    $obs_carta_inicio = strtr( mb_strtoupper( $historico->observaciones_som ), $remplazar);
                    $obs_carta_fin = strtr( mb_strtoupper( $historico->comentario ),$remplazar); 
                    
                    $nombre_area_adscripcion = strtr( mb_strtoupper( $historico->direccion_ua), $remplazar);
                    $subdireccion_ua = strtr( mb_strtoupper( $historico->subdireccion_ua ), $remplazar);
                    $unidad_dep_ua = strtr( mb_strtoupper( $historico->unidad_departamental_ua ), $remplazar);

                    $horario_remp = str_ireplace(['de','hrs.'],'', $historico->horario);
                    $horario = trim( str_ireplace('a','-', $horario_remp) );

                    $nombre_funcionario = strtr( mb_strtoupper( $historico->funcionario_escuela_2 ), $remplazar);
                    $puesto_funcionario = strtr( mb_strtoupper( $historico->cargo_funcionario_2 ), $remplazar); 

                #BEGIN::PRESTADORES -->
                    # -- municipio
                    $ciudad = trim( strtr($historico->ciudad, ['MEXICO' => 'MÉXICO']) );
                    $ciudad = ( $ciudad == 'MÉXICO' ) ? 'ESTADO DE MÉXICO' : $ciudad;

                    $nombre_municipio = trim( strtr($historico->mpio_delegacion, $removerAcentos) );
                    $nombre_municipio = ( $nombre_municipio == 'TLAMANALCO' ) ? 'TLALMANALCO' : $nombre_municipio;
                    $nombre_municipio = ( strpos( $nombre_municipio, 'CHICOLOAPAN' ) !== false ) ? 'CHICOLOAPAN' : $nombre_municipio;
                    $nombre_municipio = ( strpos( $nombre_municipio, 'GUSTAVO A MADERO' ) !== false ) ? 'GUSTAVO A. MADERO' : $nombre_municipio;

                    $municipio = Municipio::where('nombre', 'ilike', $nombre_municipio)
                                          ->whereHas('entidad', function ( $q ) use ( $ciudad ){
                                            $q->where('nombre', $ciudad);
                                          })
                                          ->first();

                    # -- Telefono funcionario
                    $configurarTelefonoFuncionario = str_ireplace([' - ',' ext. '],' EXT ', $historico->telefono_funcionario_2);
                    $partTelefonoFuncionario = explode('EXT', $configurarTelefonoFuncionario);
                    
                    $telefono_funcionario = str_ireplace(['s/n','s/t', 'sin tel', '-', ' '],'', trim($partTelefonoFuncionario[0]) );
                    $actualizar = false;

                    # -- Telefono prestador
                    $configurarTelefono = str_ireplace([' - ',' ext. '],' EXT ', $historico->telefono);
                    $partTelefono = explode('EXT', $configurarTelefono);
                    
                    $telefono = str_ireplace(['s/n','s/t', 'sin tel', '-', ' '],'', trim($partTelefono[0]) );
                    
                    # -- Funcionario actualizado "true - false"
                    $actualizar = false;
                    if ($historico->funcionario_escuela == $historico->funcionario_escuela_2 && 
                        $historico->cargo_funcionario == $historico->cargo_funcionario_2 &&
                        $historico->telefono_funcionario == $historico->telefono_funcionario_2
                    ) {
                        $actualizar = false;
                    } else {
                        $actualizar = true;
                    }

                    # Escuelas ---->>
                    $configurarPalabras = [
                        'EDUCACION' => 'EDUCACIÓN',
                        'TECNICA' => 'TÉCNICA',
                        'ADMINISTRACION' => 'ADMINISTRACIÓN',
                        'CONTADURIA' => 'CONTADURÍA',
                        'LINEA' => 'LÍNEA'
                    ];

                    $nombre_escuela = trim( strtr($historico->nombre_escuela, $configurarPalabras) );

                    $removerEnDireccion = ['CAMPUS', 'PLANTEL', 'UNIDAD', 'UNIVERSITARIA', 'NO.', 'NO'];
                    $direccion_escuela = trim( str_ireplace($removerEnDireccion,'', $historico->direccion_escuela) );
                    
                    $historico->acronimo_escuela = mb_strtoupper($historico->acronimo_escuela);
                    $acronimo_escuela = trim($historico->acronimo_escuela);

                    $acronimo_escuela = ($historico->acronimo_escuela == 'IESCA') ? 'UIN' : $historico->acronimo_escuela;
                    
                    if($acronimo_escuela == 'UNIMEX' && $direccion_escuela == 'CENTRAL') $direccion_escuela = 'POLANCO';
                    if($acronimo_escuela == 'UIN' && stripos($direccion_escuela, 'ECATEPEC') !== false) $direccion_escuela = 'CDAD AZTECA';
                    if($acronimo_escuela == 'UI' && $direccion_escuela == 'CANTERA') $acronimo_escuela = 'ICEL LA VILLA';
                    if($acronimo_escuela == 'UI' && $direccion_escuela == 'TLALPAN-COYOACAN') $acronimo_escuela = 'ICEL TLALPAN';

                    if (stripos($acronimo_escuela, 'ENP') !== false) {
                        $direccion_escuela = preg_replace('/[^0-9]/', '', $direccion_escuela);
                    }

                    $acronimo_escuela = trim( str_ireplace([' NO ', 'IPN - ','unam - ', 'universidad'],' ', $acronimo_escuela));
                    # ------>>>
                    $escuela = P06Escuela::where('acronimo_escuela', 'ilike', $acronimo_escuela)
                                ->orWhere('nombre_escuela', 'ilike', $nombre_escuela)->first();

                    if (is_null($escuela)) {
                        $escuela = P06Escuela::where( function($query) use ($direccion_escuela, $acronimo_escuela, $removerAcentos) {
                                                $query->where('acronimo_escuela', 'ilike', '%'.$acronimo_escuela.'%')
                                                      ->where('acronimo_escuela', 'ilike', '%'.strtr($direccion_escuela, $removerAcentos).'%');
                                           })->first();
                    }
                    
                    if (is_null($escuela)) {
                        $escuela = P06Escuela::where('nombre_escuela', 'ilike', '%'.$nombre_escuela.'%')->where('nombre_escuela', 'ilike', '%'.$direccion_escuela.'%')->first();
                    }

                    if (is_null($escuela)) { 
                        $escuela = P06Escuela::whereHas('institucion', function($q) use ($nombre_escuela) {
                                        $q->where('nombre_institucion', 'ilike', $nombre_escuela);
                                    })->first();
                    }
                    # Escuelas <<----

                    $configurarTelefono = str_ireplace([' - ',' ext. '],' EXT ', $historico->telefono);

                    $prestador = P06Prestador::create([
                        'escuela_id' => ($escuela->escuela_id ?? 1),
                        'tipo_prestador' => $tipoPrestador[$historico->tipo_prestador],
                        'primer_apellido' => $historico->apellido_paterno,
                        'segundo_apellido' => $historico->apellido_materno,
                        'nombre_prestador' => $historico->nombre_prestador,
                        'telefono' => intval($telefono),
                        'email' => $historico->email,
                        'carrera' => $historico->carrera,
                        'matricula' => $historico->matricula,
                        'calle' => $historico->calle,
                        'numero_interior' => $historico->numero_interior,
                        'numero_exterior' => $historico->numero_exterior,
                        'ciudad' => $historico->ciudad,
                        'colonia' => $historico->colonia,
                        'cp' => $historico->cp,
                        'municipio_id' => ($municipio->municipio_id ?? 1),
                        'estatus_prestador' => $estatus[$historico->work_status],
                        'horario_tentativo' => $horario,
                        'total_horas' => $historico->total_horas,
                        'observaciones' => $historico->observaciones,
                        'actualizo_funcionario_carta_termino' => $actualizar,
                        'nombre_funcionario' => $nombre_funcionario,
                        'puesto_funcionario' => $puesto_funcionario,
                        'telefono_funcionario' => intval($telefono_funcionario),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                #END::PRESTADORES <--

                #BEGIN::SERVICIO SOCIAL -->
                    $configurarTelefonoJefe = str_ireplace(['EXTENSIÓN', ' - ','ext.'],' EXT ', $historico->telefono_jefe);
                    $partTelefonoJefe = explode('EXT', $configurarTelefonoJefe);
                    
                    $telefonoJefePart1 = str_ireplace(['s/n','s/t', 'sin tel', '-', ',', ' '],'', trim($partTelefonoJefe[0]) );
                    
                    $telefono_jefe = null;
                    $telefono_ext_jefe = null;             
                    if( strlen($telefonoJefePart1) <= 6 ){
                        $telefono_ext_jefe = $telefonoJefePart1;
                    } else {
                        $telefono_jefe = $telefonoJefePart1;

                        if( count($partTelefonoJefe) == 2 ){
                            $telefono_ext_jefe = trim( str_ireplace('.','', $partTelefonoJefe[1]) );
                        }
                    }

                    $areaAdscripcion = P06AreasAdscripcion::firstWhere('nombre_area_adscripcion', trim($nombre_area_adscripcion));

                    $servicioSocial = P06ServicioSocial::create([
                        'servicio_social_id' => $historico->id_p06,
                        'folio' => $historico->folio,
                        'estatus' => $estatus[$historico->work_status],
                        
                        'prestador_id' => ($prestador->prestador_id ?? null),

                        'area_id' => (!is_null($area) ? $area->area_id : null),
                        'nombre_area' => (!is_null($area) ? $area->nombre : null),
                        
                        'fecha_cita' => $historico->fecha_cita,
                        'hora_cita' => $historico->hora_cita,
                        'lugar_cita' => $lugar_cita,

                        'horario' => $horario,
                        'actividades' => $actividades,

                        'jefe' => $nombre_jefe,
                        'puesto_jefe' => $puesto_jefe,
                        'telefono_jefe' => (isset($telefono_jefe) ? intval($telefono_jefe) : null),
                        'telefono_ext_jefe' =>(!empty($telefono_ext_jefe) ? $telefono_ext_jefe : null),

                        'horas_acumuladas' => ($historico->horas_acumuladas ?? 0),

                        'fecha_inicio' => $historico->fecha_inicio,
                        'fecha_fin' => $historico->fecha_fin,
                        'fecha_carta_inicio' => $historico->fecha_carta_inicio,
                        'fecha_carta_fin' => $historico->fecha_carta_fin,

                        'nombre_drh' => $nombre_drh,
                        'fecha_firma_drh_inicio' => $historico->firma_drh_inicio,
                        'fecha_firma_drh_fin' => $historico->firma_drh_fin,

                        'area_adscripcion_id' => $areaAdscripcion->area_adscripcion_id ?? null,
                        'subdireccion_ua' => $subdireccion_ua,
                        'unidad_departamental_ua' => $unidad_dep_ua,

                        'correcciones' => $correcciones,
                        'observaciones_carta_inicio' => $obs_carta_inicio,
                        'observaciones_carta_fin' => $obs_carta_fin,

                        'es_historico' => true,
                        'created_at' => $historico->instancia->created_on,
                        'updated_at' => now()
                    ]);
                #END::SERVICIO SOCIAL <--

                #BEGIN::INSTANCIAS -->
                    $area_instancia = Area::firstWhere('identificador', $historico->instancia->created_by_ou);
                    $proceso = Proceso::firstWhere('nombre', 'SERVICIO SOCIAL');

                    $instancia = new Instancia();
                    $instancia->instancia_id = $historico->id_instance;
                    $instancia->proceso_id = $proceso->proceso_id ?? 1;
                    $instancia->model()->associate($servicioSocial);
                    $instancia->area_id = $area_instancia->area_id ?? null;
                    $instancia->es_historico = true;
                    $instancia->created_at = $historico->instancia->created_on;
                    $instancia->updated_at = now();
                    $instancia->save();

                    $instancia->folio = $historico->folio;
                    $instancia->save();
                #END::INSTANCIAS <--

                #BEGIN::TAREAS -->
                    $siguienteTarea = false;

                    # TAREA 01 -- Seleccionar prestador
                    $instanciaTarea = $this->crearTareas('T01', 'COMPLETADO', $historico, $area_instancia, 'SUB_EA');
                    $instanciaTarea->autorizado_por_area = $area->area_id;
                    $instanciaTarea->autorizado_por_usuario = 1;
                    $instanciaTarea->save();

                    # TAREA 02 -- Datos de entrevista
                    if( !is_null($servicioSocial->hora_cita) && 
                        !is_null($servicioSocial->fecha_cita) && 
                        !is_null($servicioSocial->lugar_cita) 
                    ) {
                        $instanciaTarea = $this->crearTareas('T02', 'COMPLETADO', $historico, $area_instancia, 'SUB_EA');
                        $instanciaTarea->autorizado_por_area = $area->area_id;
                        $instanciaTarea->autorizado_por_usuario = 1;
                        $instanciaTarea->save();
                        $siguienteTarea = true;

                    } else { 
                        $this->crearTareas('T02', 'NUEVO', $historico, $area_instancia, 'SUB_EA');
                        $siguienteTarea = false;
                    }

                    # TAREA 03 -- Aceptar o Rechazar prestador
                    if ( $siguienteTarea ) {
                        if( !is_null($servicioSocial->fecha_inicio) ) {
                            $instanciaTarea = $this->crearTareas('T03', 'COMPLETADO', $historico, $area_instancia, 'SUB_EA');
                            $instanciaTarea->autorizado_por_area = $area->area_id;
                            $instanciaTarea->autorizado_por_usuario = 1;
                            $instanciaTarea->save();

                            $prestador->estatus_prestador = 'ACEPTADO';
                            $prestador->save();
                            
                        } else { 
                            $this->crearTareas('T03', 'NUEVO', $historico, $area_instancia, 'SUB_EA');
                            $siguienteTarea = false;
                        }
                    }
                    
                    # TAREA 04 -- Asignar funciones
                    if ( $siguienteTarea ) {
                        if(
                        !is_null($servicioSocial->fecha_inicio) && !is_null($servicioSocial->fecha_fin) &&
                        !is_null($servicioSocial->horario) && !is_null($servicioSocial->actividades) &&
                        !is_null($servicioSocial->jefe) && !is_null($servicioSocial->puesto_jefe)
                        ) {
                            $instanciaTarea = $this->crearTareas('T04', 'COMPLETADO', $historico, $area_instancia, 'SUB_EA');
                            $instanciaTarea->autorizado_por_area = $area->area_id;
                            $instanciaTarea->autorizado_por_usuario = 1;
                            $instanciaTarea->save();
                        } else { 
                            $this->crearTareas('T04', 'NUEVO', $historico, $area_instancia, 'SUB_EA');
                            $siguienteTarea = false;
                        }
                    }

                    # TAREA 05 -- Carta inicio
                    if ( $siguienteTarea ) {
                        if( !is_null($servicioSocial->fecha_carta_inicio) && !is_null($servicioSocial->fecha_firma_drh_inicio) ) {
                            $instanciaTarea = $this->crearTareas('T05', 'COMPLETADO', $historico, $area_instancia, 'PROG_SS');

                            $prestador->estatus_prestador = 'EN_CURSO';
                            $prestador->save();

                            $instanciaTarea->autorizado_por_area = $area->area_id;
                            $instanciaTarea->autorizado_por_usuario = 1;
                            $instanciaTarea->save();

                        } else { 
                            $this->crearTareas('T05', 'NUEVO', $historico, $area_instancia, 'PROG_SS');
                            $siguienteTarea = false;
                        }
                    }

                    # TAREA 06 -- Registrar eventos
                    # TAREA 08 -- Validar proceso
                    if ( $siguienteTarea ) {
                        if( $servicioSocial->horas_acumuladas == $prestador->total_horas &&
                            ($servicioSocial->validacion == 'LIBERADO' || $servicioSocial->validacion == 'BAJA')
                        ) {
                            $instanciaTarea = $this->crearTareas('T06', 'COMPLETADO', $historico, $area_instancia, 'SUB_EA');
                            $instanciaTarea->autorizado_por_area = $area->area_id;
                            $instanciaTarea->autorizado_por_usuario = 1;
                            $instanciaTarea->save();

                            $instanciaTarea = $this->crearTareas('T08', 'COMPLETADO', $historico, $area_instancia, 'PROG_SS');
                            $instanciaTarea->autorizado_por_area = $area->area_id;
                            $instanciaTarea->autorizado_por_usuario = 1;
                            $instanciaTarea->save();

                        } else { 
                            $this->crearTareas('T06', 'NUEVO', $historico, $area_instancia, 'SUB_EA');
                            $this->crearTareas('T08', 'NUEVO', $historico, $area_instancia, 'PROG_SS');
                            $siguienteTarea = false;
                        }
                    }

                #END::TAREAS <--
                }
            }
        }   
    }

    public function crearTareas($indentificadorTarea, $estatus, $historico, $area, $name)
    {
        $tarea = Tarea::firstWhere('identificador', $indentificadorTarea);
        $role = Role::firstWhere('name', $name);

        $instanciaTarea = InstanciaTarea::create([
            "instancia_id" => $historico->id_instance,
            "tarea_id" => $tarea->tarea_id,
            "es_primer_tarea" => InstanciaTarea::where('instancia_id', $historico->id_instance)->get()->count() < 1,
            
            "pertenece_al_area" => $area->area_id,
            "pertenece_unidad_administrativa" => $area->unidadAdministrativa->unidad_administrativa_id,
            "pertenece_dependencia" => $area->unidadAdministrativa->dependencia->dependencia_id,
            
            "asignado_al_rol" => $role->id,
            "asignado_al_usuario" => 1,
            
            "creado_por_area" => $area->area_id,
            "creado_por_usuario" => 1,

            "estatus" =>  $estatus,
            "created_at" => $historico->instancia->created_on,
            "updated_at" => now()
        ]);

        return $instanciaTarea;
    }

    public function catProgramas($historicoProc, $reamplazarMayusculasAcentos)
    {
        foreach($historicoProc->unique('observaciones_som') as $historico) {
            
            if (stripos($historico->observaciones_som, 'programa') !== false && 
                (stripos($historico->observaciones_som, 'clave:') !== false || stripos($historico->observaciones_som, 'clave del programa:') !== false)
            ) {
                $observaciones = str_ireplace(['clave del programa', 'programa', 'clave', 'CÓDIGO'],'#', $historico->observaciones_som);

                $arrProgramas = explode('#', $observaciones);
                $nombrePrograma = str_ireplace([':', '”', '“', '"', '.'],'', strtr( mb_strtoupper( $arrProgramas[1] ), $reamplazarMayusculasAcentos) );
                $clavePrograma =  str_ireplace([':', '"', '.'],'', $arrProgramas[2]);

                $programa = P06ProgramasInstitucion::firstWhere('clave_programa', trim($clavePrograma));

                if(is_null($programa)) {
                    P06ProgramasInstitucion::create([
                        'nombre_programa' => trim($nombrePrograma),
                        'clave_programa' => trim($clavePrograma)
                    ]);
                }
            }
        }

        foreach($historicoProc as $historico) {
            if ( !empty($historico->clave_programa) && trim($historico->clave_programa) != '-' && trim($historico->nombre_programa) != '-') {
                $programa = P06ProgramasInstitucion::firstWhere('clave_programa', trim($historico->clave_programa));

                if(is_null($programa)) {
                    P06ProgramasInstitucion::create([
                        'nombre_programa' => trim( strtr( mb_strtoupper($historico->nombre_programa), $reamplazarMayusculasAcentos) ),
                        'clave_programa' => trim($historico->clave_programa)
                    ]);
                }
            }
        }
    }

    public function catAreasAdscripcion($historico, $reamplazarMayusculasAcentos)
    {
        foreach($historico->unique('direccion_ua') as $historicoAreas){
            if( isset($historicoAreas->direccion_ua) ) {
                $nombre_area_adscripcion = strtr( mb_strtoupper($historicoAreas->direccion_ua), $reamplazarMayusculasAcentos);
                $direccion_area_adscripcion = strtr( mb_strtoupper($historicoAreas->domicilio_ua), $reamplazarMayusculasAcentos);

                P06AreasAdscripcion::create([
                    'nombre_area_adscripcion' => trim($nombre_area_adscripcion),
                    'direccion_area_adscripcion' => trim($direccion_area_adscripcion)
                ]);
            }
        }
    }
}