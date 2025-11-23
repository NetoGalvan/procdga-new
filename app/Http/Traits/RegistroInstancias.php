<?php

namespace App\Http\Traits;
use App\Models\Instancia;
use App\Models\Proceso;

trait RegistroInstancias
{
    /**
     * Crea una instancia de un proceso en particular
     *
     * @return \App\Models\Instancia
     */
    public function crearInstancia($proceso, $tramite, $area = null, $instanciaPadre = null)
    {
        $instancia = new Instancia();
        $instancia->instancia_padre_id = $instanciaPadre ? $instanciaPadre->instancia_id : $instanciaPadre;
        $instancia->proceso_id = Proceso::select('proceso_id')->where('identificador', $proceso)->first()->proceso_id;
        $instancia->area_id = $area->area_id ?? null;
        $instancia->model()->associate($tramite);
        $instancia->save();

        $tramite->folio = $instancia->folio;
        $tramite->save();

        return $instancia;
    }
}
