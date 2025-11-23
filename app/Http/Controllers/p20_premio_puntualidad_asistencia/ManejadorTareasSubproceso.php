<?php

namespace App\Http\Controllers\p20_premio_puntualidad_asistencia;

use App\Http\Traits\RegistroInstancias;
use App\Models\Proceso;
use DB;

trait ManejadorTareasSubproceso{

    use RegistroInstancias;

    // public function crearInstanciaSubprocesoPremioPuntualidadAsistencia($subprocesoPremio){
    //     $proceso = Proceso::select('proceso_id')
    //         ->where('identificador', 'premio_administracion')
    //         ->first();

    //     return $this->crearInstancia($proceso, $subprocesoPremio, 'EN_PROCESO');
    // }

    // public function getInstanciaTareaSubproceso($instancia, $nombreTarea){
    //     return $instancia->getInstanciaTareaSubproceso($nombreTarea);
    // }

    // public function crearFolioSubproceso($instancia, $instanciaTarea) {
    //     $instancia->folio  = $this->crearFolioProceso($instancia, $instanciaTarea);
    //     $instancia->save();

    //     return $instancia->folio;
    // }

    // public function crearTareaSubproceso($instancia, $nombreTarea, $estatus){
    //     return $instancia->crearInstanciaTarea($nombreTarea, $estatus);
    // }

    // public function actualizarEstatusTareaSubproceso($instanciaTarea, $estatus){
    //     $instanciaTarea->estatus = $estatus;
    //     return $instanciaTarea->save();
    // }
}