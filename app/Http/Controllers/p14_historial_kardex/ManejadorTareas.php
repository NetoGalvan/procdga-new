<?php

namespace App\Http\Controllers\p14_historial_kardex;

use App\Http\Traits\RegistroInstancias;

use App\Models\Instancia;
use App\Models\Proceso;
use App\Models\p12_tramites_incidencias\P14HistorialKardex;

trait ManejadorTareas{
    use RegistroInstancias;

    public function crearHistorialKardex(){
        return $historialKardex = P14HistorialKardex::create();
    }

    public function crearInstanciaCapturaKardex($historialKardex){
        $proceso = Proceso::select('proceso_id')
            ->where('identificador', 'historial')
            ->first();
        return $this->crearInstancia($proceso, $historialKardex, 'EN_PROCESO');
    }

    public function crearTarea($instancia, $nombreTarea, $estatus) {
        return $instancia->crearInstanciaTarea($nombreTarea, $estatus);
    }
}
