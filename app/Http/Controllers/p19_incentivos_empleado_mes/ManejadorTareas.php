<?php

namespace App\Http\Controllers\p19_incentivos_empleado_mes;

use App\Http\Traits\RegistroInstancias;

use App\Models\p19_incentivos_empleado_mes\P19Incentivo;
use App\Models\p19_incentivos_empleado_mes\P19Subproceso;
use App\Models\p19_incentivos_empleado_mes\P19Nomina;
use App\Models\Area;
use App\Models\User;
use App\Models\Proceso;
use App\Models\UnidadAdministrativa;
use App\Models\Dependencia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\p24_directorio\NivelSalarial;

trait ManejadorTareas
{
    use RegistroInstancias;

    public function crearIncentivoEmpleadoMes()
    {
        $incentivoEmpleadoMes = P19Incentivo::create(["estatus" => "EN_PROCESO"]);

        $user       = Auth::user();
        $userArea   = Auth::user()->area;

        $OPER       = User::role('OPER_INC_19')->first();
        $DRH        = User::role('DRH')->first();
        $JUD_PRES   = User::role('JUD_PRES')->first();
        $SUB_PRES   = User::role('SUB_PRES')->first();

        // Operador de premio incentivo empleado del mes. Responsable de agregar y evaluar a los empleados solicitantes del premio.
        $firmas['opera_incen'] = [
            'nombre' => isset($OPER) ? mb_strtoupper($OPER->nombre .' '. $OPER->apellido_paterno .' '. $OPER->apellido_materno) : '',
            'cargo' => isset($OPER) ? mb_strtoupper($OPER->puesto) : '',
            'rol' => 'OPER_INC_19'
        ];
        $firmas['drh'] =[
            'nombre' => isset($DRH) ? mb_strtoupper($DRH->nombre .' '. $DRH->apellido_paterno .' '. $DRH->apellido_materno) : '',
            'cargo' => isset($DRH) ? mb_strtoupper($DRH->puesto) : '',
            'rol' => 'DRH'
        ];
        $firmas['jud_pres'] =[
            'nombre' => isset($JUD_PRES) ? mb_strtoupper($JUD_PRES->nombre .' '. $JUD_PRES->apellido_paterno .' '. $JUD_PRES->apellido_materno) : '',
            'cargo' => isset($JUD_PRES) ? mb_strtoupper($JUD_PRES->puesto) : '',
            'rol' => 'JUD_PRES'
        ];
        $firmas['sub_pres'] =[
            'nombre' => isset($SUB_PRES) ? mb_strtoupper($SUB_PRES->nombre .' '. $SUB_PRES->apellido_paterno .' '. $SUB_PRES->apellido_materno) : '',
            'cargo' => isset($SUB_PRES) ? mb_strtoupper($SUB_PRES->puesto) : '',
            'rol' => 'SUB_PRES'
        ];

        $incentivoEmpleadoMes->firmas = json_encode($firmas);

        // Usuario creador de Incentivo
        $incentivoEmpleadoMes->creado_por                   = $user->nombre_usuario;
        $incentivoEmpleadoMes->creado_por_area              = $userArea->area_id;
        $incentivoEmpleadoMes->creado_por_nombre_completo   = $user->nombre .' '. $user->apellido_paterno .' '. $user->apellido_materno;
        $incentivoEmpleadoMes->creado_por_titulo            = $user->puesto;

        return $incentivoEmpleadoMes;
    }


    /**
     * Método encargado de guardar la Selección quincena pago.
     * Es la T01 del P19.
     * @param object $incentivoEmpleadoMes
     * @param object $request
     */
    public function guardarTareaT01($incentivoEmpleadoMes, $request)
    {
        // Datos de la Mes a Evaluar
        $fechaEvaluacion = json_decode($request['fecha_evaluacion']);
        // Expresión regular para buscar fechas en formato dd/mm/yyyy
        $patron = '/\b(\d{2})\/(\d{2})\/(\d{4})\b/';
        // Buscar todas las coincidencias de fechas en la cadena
        preg_match_all($patron, $request->fecha_data, $matches);
        // Obtener la fecha de inicio y de fin
        $fechaInicio = $matches[0][0];
        $fechaFin = $matches[0][1];

        // Ingresa datos de la selección
        $incentivoEmpleadoMes->nombre_quincena      = $request->fecha_data;
        $incentivoEmpleadoMes->fecha_inicio_pago    = $fechaInicio;
        $incentivoEmpleadoMes->fecha_fin_pago       = $fechaFin;
        $incentivoEmpleadoMes->nombre_mes_anio_evaluacion   = $fechaEvaluacion->nombre_mes_anio;
        $incentivoEmpleadoMes->fecha_inicio_evaluacion      = $fechaEvaluacion->fecha_inicio;
        $incentivoEmpleadoMes->fecha_fin_evaluacion         = $fechaEvaluacion->fecha_fin;
        $incentivoEmpleadoMes->numero_documento     = $request->numero_documento;
        $incentivoEmpleadoMes->premios_aprobados    = $request->premios_aprobados;
        $incentivoEmpleadoMes->comentarios_opera_incen = $request->comentarios_opera_incen;

        return $incentivoEmpleadoMes->save();
    }


    /**
     * Método encargado de guardar la Asignación de premios por unidad
     * Es la T02 del P19.
     * @param object $incentivoEmpleadoMes
     * @param object $request
     */
    public function guardarTareaT02($incentivoEmpleadoMes, $request)
    {

        // Datos de la tabla de las Unidades
        $dataAreas = json_decode($request['arreglo_areas']);

        // Se recorren las Áreas de la tabla Si tiene chechado el estaus SI aplica y tienen CANTIDAD de PREMIOS asignada se guarda para generar la estructura de la areas que recibiran premios
        $estructuraConcurrente = [];
        foreach ($dataAreas as $key => $area) {
            if ( $request['aplica_'.$area->area_id] == 'SI' && $request['premios_asignados_'.$area->area_id] > 0 ) {
                $estructuraConcurrente[$area->area_id] = [
                    'area_id' => $area->area_id,
                    'identificador' => $area->identificador,
                    'nombre' => mb_strtoupper($area->nombre),
                    'premios_opera_incen' => $request['premios_asignados_'.$area->area_id],
                    'aplica' => $request['aplica_'.$area->area_id]
                ];
            }
        }

        // Se manda llamar al método para crear el Subproceso a las Áreas que cumplan con la validación
        $subprocesoCreado =  $this->crearSubprocesoST01($incentivoEmpleadoMes, $request, $estructuraConcurrente);

        if ( $subprocesoCreado ) {

            $actualizado = $incentivoEmpleadoMes->update([
                'estructura_concurrente'  => json_encode($estructuraConcurrente),
                'fecha_subproceso_inicio' => Carbon::now(),
                'estatus' => 'SUBPROCESO_INICIO'
            ]);

            return $actualizado;
        } else {

            return false;
        }

    }


    /**
     * Método encargado de crear los Subprocesos para las Áreas que aplique
     * Es la TS01 del P19.
     * @param object $incentivoEmpleadoMes
     * @param object $request
     * @param array $estructuraConcurrente
     */
    public function crearSubprocesoST01($incentivoEmpleadoMes, $request, $estructuraConcurrente)
    {

        try {
            DB::beginTransaction();
            // Se obtienen las areas a validar
            $dataAreas = json_decode($request['arreglo_areas']);
            // Se crea el Subproceso
            $proceso        = Proceso::select('proceso_id')->where('identificador', 'subproceso_incentivo_empleado_mes')->first();
            $instanciaPadre = $incentivoEmpleadoMes->instancia;

            foreach ($dataAreas as $area) {

                // Se realiza la validación  para ver a que Áreas se les creará el Subproceso
                if ( $request['aplica_'.$area->area_id] == 'SI' && $request['premios_asignados_'.$area->area_id] > 0 ) {
                    $subproceso = new P19Subproceso();
                    $subproceso->p19_incentivo_id           = $incentivoEmpleadoMes->p19_incentivo_id;
                    $subproceso->area_id                    = $area->area_id;
                    $subproceso->estatus                    = "EN_PROCESO";
                    $subproceso->estructura_concurrente     = json_encode($estructuraConcurrente);
                    $subproceso->instancia_padre_id         = $instanciaPadre->instancia_id;
                    $subproceso->folio_padre                = $incentivoEmpleadoMes->folio;
                    $subproceso->nombre_quincena            = $incentivoEmpleadoMes->nombre_quincena;
                    $subproceso->fecha_inicio_pago          = $incentivoEmpleadoMes->fecha_inicio_pago;
                    $subproceso->fecha_fin_pago             = $incentivoEmpleadoMes->fecha_fin_pago;
                    $subproceso->comentarios_opera_incen    = $incentivoEmpleadoMes->comentarios_opera_incen;
                    $subproceso->nombre_mes_anio_evaluacion = $incentivoEmpleadoMes->nombre_mes_anio_evaluacion;
                    $subproceso->fecha_inicio_evaluacion    = $incentivoEmpleadoMes->fecha_inicio_evaluacion;
                    $subproceso->fecha_fin_evaluacion       = $incentivoEmpleadoMes->fecha_fin_evaluacion;
                    $subproceso->premios_aprobados          = $request['premios_asignados_'.$area->area_id];
                    $subproceso->save();
                    $instancia          = $this->crearInstancia('subproceso_incentivo_empleado_mes', $subproceso, $area, $instanciaPadre);
                    $instanciaTarea     = $instancia->crearInstanciaTarea('DISTRIBUIR_PREMIOS_POR_SUBAREA', 'NUEVO', $area);

                    $subproceso->folio  = $instancia->folio;
                    $subproceso->save();
                }

            }
            DB::commit();

            return true;
        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }


    /**
     * Método encargado de guardar la Revisión de solicitudes de premios
     * Es la T03 del P19.
     * @param object $incentivoEmpleadoMes
     * @param object $request
     */
    public function guardarTareaT03($incentivoEmpleadoMes, $request)
    {

        try {

            DB::beginTransaction();
            // Datos de la tabla de los Subprocesos
            $dataSubprocesos = json_decode($request['arreglo_subprocesos']);

            // Se recorren los SUBPROCESOS para validar cuales ya fueron FINALIZADOS
            foreach ($dataSubprocesos as $key => $subproceso) {

                // Si se detentan subprocesos que no fueron finalizados, se aplica estas reglas
                if ( $subproceso->estatus == 'EN_PROCESO' )
                {
                    // Se debera dar como Completada (Finalizada) el Subproceso que corresponda
                    $subprocesoUpdate = P19Subproceso::find($subproceso->p19_subproceso_id);
                    $subprocesoUpdate->update([
                        'estatus' => 'CANCELADO'
                    ]);

                    // Despues se debe Eliminar las Nominas Asociadas, ya que no serán tomadas en cuenta para el Incentivo
                    P19Nomina::where('p19_subproceso_id', $subprocesoUpdate->p19_subproceso_id)->delete();

                    // Despues se obtienen la Instancia
                    $instancia =  $subprocesoUpdate->instancia;
                    // Despues con la Instancia obtenemos las InstaciasTareas de este subProceso
                    $instanciasTareas = $instancia->instanciasTareas;

                    // Se recorren las Instancias Tareas de este SubProceso y se Finalizan, ya que no fue completado
                    foreach ($instanciasTareas as $key => $instanciaTarea) {
                        $instanciaTarea->updateEstatus('CANCELADO');
                        $instanciaTarea->motivo_rechazo = 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR POR PARTE DE LA SUBÁREA (TAREA 3 - REVISIÓN DE SOLICITUDES DE PREMIO)';
                        $instanciaTarea->save();
                    }

                    // Ahora se actualiza el estatus de la instancia del Subproceso a Cancelado ya que no continua para el Incentivo
                    $instancia->update(['estatus' => 'CANCELADO']);
                }
            }

            // Despues que se recorrio y ejecutaron las acciones a los Subprocesos de este Incentivo se actualiza el mismo
            $actualizado = $incentivoEmpleadoMes->update([
                'estatus' => 'SUBPROCESO_FINALIZO',
                'fecha_subproceso_finalizo' => Carbon::now()
            ]);

            DB::commit();
            return $actualizado;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;

        }

    }


    /**
     * Método encargado de guardar la Generación archivos pago
     * Es la T04 del P19.
     * @param object $incentivoEmpleadoMes
     * @param object $request
     */
    public function guardarTareaT04($incentivoEmpleadoMes, $request)
    {

        try {

            DB::beginTransaction();

            // Despues que se recorrio y ejecutaron las acciones a los Subprocesos de este Incentivo se actualiza el mismo
            $actualizado = $incentivoEmpleadoMes->update([
                'estatus' => 'COMPLETADO',
            ]);

            DB::commit();
            return $actualizado;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;

        }

    }


    /**
     * Método encargado de guardar la el Subproceso Distribución de premios por sub área
     * Es la ST01 del P19.
     * @param object $subproceso
     * @param object $request
     */
    public function guardarTareaST01($subproceso, $request)
    {

        $user       = Auth::user();
        $userArea   = Auth::user()->area;

        // Datos de la tabla de las Sub áreas
        $dataSubAreas = json_decode($request['arreglo_sub_areas']);

        // Se recorren las Sub Áreas de la tabla Si tienen CANTIDAD de PREMIOS asignada se guarda para generar la estructura de la areas que recibiran premios
        $estructuraConcurrente = [];
        foreach ($dataSubAreas as $key => $area) {
            if ( $request['premios_asignados_'.$area->area_id] > 0 ) {
                $estructuraConcurrente[$area->area_id] = [
                    'area_id' => $area->area_id,
                    'identificador' => $area->identificador,
                    'nombre' => mb_strtoupper($area->nombre),
                    'premios_sub_ea' => $request['premios_asignados_'.$area->area_id],
                ];
            }
        }

        $estructuraNew = [
            'hijo'  => $estructuraConcurrente,
            'padre' => $subproceso->estructura_concurrente
        ];

        try {
            DB::beginTransaction();

            // Ingresa datos del área que recibira el servicio
            $actualizado = $subproceso->update([
                'comentarios_sub_ea'          => $request->comentarios_sub_ea,
                'estructura_concurrente'      => json_encode($estructuraNew),
                'creado_por'                  => $user->nombre_usuario,
                'creado_por_area'             => $userArea->area_id,
                'creado_por_nombre_completo'  => $user->nombre .' '. $user->apellido_paterno .' '. $user->apellido_materno,
                'creado_por_titulo'           => $user->puesto
            ]);

            DB::commit();
            return $actualizado;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

    }


    public function guardarTareaST02EmpleadoNomina($subproceso, $data_empleado, $comentarios_admin_incen = '', $instancia_tarea)
    {
        $user       = Auth::user();
        $userArea   = Auth::user()->area;
        $subArea    = Area::find($instancia_tarea['pertenece_al_area']);

        try {
            DB::beginTransaction();
            $empleado = P19Nomina::create([
                'folio' => $subproceso->folio_padre,
                'p19_incentivo_id' => $subproceso->p19_incentivo_id,
                'p19_subproceso_id' => $subproceso->p19_subproceso_id,
                'numero_empleado' => isset($data_empleado->numero_empleado) ? $data_empleado->numero_empleado : '',
                'nombre_empleado' => $data_empleado->nombre,
                'apellido_paterno' => $data_empleado->apellido_paterno,
                'apellido_materno' => $data_empleado->apellido_materno,
                'id_sindicato' => isset($data_empleado->seccion_sindical) ? $data_empleado->seccion_sindical : null,
                'rfc' => $data_empleado->rfc,
                'nivel_salarial' => $data_empleado->nivel_salarial,
                'area_id' => $subproceso->area->area_id,
                'area' => $subproceso->area->nombre,
                'sub_area_id' => $subArea->area_id,
                'sub_area' => $subArea->nombre,
                'fecha_inicio_evaluacion' => $subproceso->fecha_inicio_evaluacion,
                'fecha_fin_evaluacion' => $subproceso->fecha_fin_evaluacion,
                'comentarios_admin_incen' => $comentarios_admin_incen,
                'nombre_mes' => $subproceso->nombre_mes_anio_evaluacion,
                'fecha_inicio_siden' => null,
                'fecha_fin_siden' =>  null,
                'creado_por' => $user->nombre_usuario,
                'creado_por_area' => $userArea->area_id,
                'creado_por_nombre_completo' => $user->nombre.' '.$user->apellido_paterno.' '.$user->apellido_materno,
                'creado_por_titulo' => $user->puesto
            ]);

            $respuesta = [
                'empleado' => $empleado,
                'estatus' => true,
            ];

            DB::commit();
            return $respuesta;

        } catch (\Throwable $th) {

            DB::rollback();
            $respuesta = [
                'estatus' => false,
            ];
            return $respuesta;
        }

    }

    /**
     * Método encargado de guardar la el Subproceso Autorización de solicitudes
     * Es la ST03 del P19.
     * @param object $subproceso
     * @param object $request
     */
    public function guardarTareaST03($subproceso, $request)
    {

        try {
            DB::beginTransaction();

            // Obtenemos la instancia del subproceso
            $instancia = $subproceso->instancia;
            // Obtenemos las instaciasTareas de este subProceso
            $instanciasTareas = $instancia->instanciasTareas;

            // Datos de la tabla de las Sub áreas
            $dataSubAreas = json_decode($request['arreglo_sub_areas']);

            // Recorremos las Instacias Tareas y Validamos las que son ST02
            foreach ($instanciasTareas as $key => $instanciaTarea) {
                if ($instanciaTarea->tarea->identificador == 'ASIGNAR_PREMIOS_POR_EMPLEADO') {
                    // Despues validamos si esta Instancia Tarea no se finalizo
                    if ($instanciaTarea->estatus == 'NUEVO') {
                        // Y Finalizamos las tareas ST02 del Subproceso que no fueron completadas como canceladas
                        $instanciaTarea->updateEstatus('CANCELADO');
                        $instanciaTarea->motivo_rechazo = 'CANCELACIÓN AUTOMATICA POR NO CONCLUIR POR PARTE DE LA SUBÁREA (SUB TAREA 2 - ASIGNACIÓN DE PREMIOS POR EMPLEADO)';
                        $instanciaTarea->save();
                    }
                }
            }

            // Despues recorremos las Sub Áreas y validamos su estatus
            foreach ($dataSubAreas as $key => $subArea) {
                // Validamos si esta Sub Área termino de capturar a sus empleados
                if ( $subArea->estatus == 'PENDIENTE' ) {
                    // Si el estatus quedo pendiente por que no concluyeron a tiempo la ST02, Elminamos la todos los empleados que hayan agregado en la tabla de p19_nomina, si es que los hay.
                    // Si capturaron y concluyeron bien su ST02 no se afectan a los empleados que capturaron
                    P19Nomina::where('p19_subproceso_id', $subproceso->p19_subproceso_id)
                            ->where('sub_area_id', $subArea->area_id)
                            ->delete();
                }
            }

            // Finalmente despues de eliminar se actualiza el estatus del Sub Proceso
            $subproceso->update([
                'estatus' => 'COMPLETADO'
            ]);

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

    }


}
