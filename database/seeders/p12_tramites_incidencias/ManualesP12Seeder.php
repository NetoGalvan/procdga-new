<?php

namespace Database\Seeders\p12_tramites_incidencias;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP12Seeder extends Seeder {

    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            "nombre" => "INCIDENCIAS",
            "identificador" => "manual_tramites_incidencias",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p12_tramites_incidencias.pdf"
        ]);
    }
}
