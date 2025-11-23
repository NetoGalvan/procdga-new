<?php

namespace App\Http\Controllers\p20_premio_puntualidad_asistencia;

use App\Http\Traits\RegistroInstancias;
use DB;
use App\Models\p20_premio_puntualidad_asistencia\P20PremioPuntualidadInscripcion;

trait ManejadorTareas{

    use RegistroInstancias;

    // TAREAS
    // T01
    public function guardarAreasSeleccionadasT01($request, $usuario, $premioPuntualidad, $areasParticipantes){
        try {
            $json_areas = json_encode($areasParticipantes);
            $dataFechas = explode(", ", $request->fecha_quincena);
            $fechas_separadas = explode(' - ', $dataFechas[1]);
            // La primera parte será el primer elemento del array
            $f_ini = $fechas_separadas[0];
            // La segunda parte será el segundo elemento del array
            $f_fin = $fechas_separadas[1];

            DB::beginTransaction();
            $premioPuntualidad->quincena = $request->fecha_quincena;
            $premioPuntualidad->fecha_inicio_pago = $f_ini;
            $premioPuntualidad->fecha_fin_pago = $f_fin;
            $premioPuntualidad->instrucciones = $request->instrucciones;
            $premioPuntualidad->firmas = null;
            $premioPuntualidad->estructura_concurrente = $json_areas;
            $premioPuntualidad->subproceso_inicio = now();
            $premioPuntualidad->creado_por = $usuario->nombre .' '. $usuario->apellido_paterno .' '. $usuario->apellido_materno;
            $premioPuntualidad->creado_por_area = $usuario->area->nombre;
            $premioPuntualidad->creado_por_titulo = $usuario->nombre_usuario;
            $premioPuntualidad->save();

            DB::commit();
            return [ 'estatus' => true, 'mensaje' => '¡La tarea finalizó exitosamente!', 'ruta' => route('tareas') ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrio un error, intente de nuevo más tarde.' ];
        }
    }

    // T01
    public function crearSubprocesoPremio($instanciaPadre, $premioPuntualidad, $areasParticipantes) {
        try {
            foreach ($areasParticipantes as $areaParticipante) {
                DB::beginTransaction();
                    $subproceso = new P20PremioPuntualidadInscripcion();
                    $subproceso->activo = true;
                    $subproceso->estatus = "EN_PROCESO";
                    $subproceso->premio_puntualidad_id = $premioPuntualidad->premio_puntualidad_id;
                    $subproceso->quincena = $premioPuntualidad->quincena;
                    $subproceso->area_id = $areaParticipante->area_id;
                    $subproceso->save();

                    $instancia = $this->crearInstancia('subproceso_premio_puntualidad_asistencia', $subproceso, $areaParticipante, $instanciaPadre);
                    $instanciaTarea = $instancia->crearInstanciaTarea('ASIGANCION_DE_AREAS', 'NUEVO');

                    $subproceso->folio = $instancia->folio;
                    $subproceso->save();
                DB::commit();
            }
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => '¡Error: Intente más tarde!' ];
        }
    }

    // T03
    public function crearNotificacionAreas($instancia, $premioPuntualidadAsistencia) {

        try {
            foreach ($premioPuntualidadAsistencia->inscripciones as $inscripcion) {
                if ( $inscripcion->estatus == 'COMPLETADO' ) {
                    $instancia->crearInstanciaTarea('TNOTAPPA01', 'NOTIFICACION_NO_LEIDO', $inscripcion->area);
                }
            }
            return [ 'estatus' => true, 'mensaje' => 'Proceso finalizado correctamente', 'ruta' => route('tareas') ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => '¡Error: Intente más tarde!' ];
        }
    }

    // SUBTAREAS

    // ST01
    public function guardaSubtareaCapturarInstrucciones($request, $usuario, $subproceso) {
        try {
            DB::beginTransaction();
            $subproceso->instrucciones  = $request->instrucciones;
            $subproceso->creado_por = $usuario->nombre .' '. $usuario->apellido_paterno .' '. $usuario->apellido_materno;
            $subproceso->creado_por_area = $usuario->area->nombre;
            $subproceso->creado_por_titulo = $usuario->nombre_usuario;
            $subproceso->save();
            DB::commit();
            return [ 'estatus' => true, 'mensaje' => 'La tarea finalizó correctamente', 'ruta' => route('tareas') ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Ocurrio un error, intente de nuevo más tarde.' ];
        }
    }

}
