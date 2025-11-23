<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP02Seeder extends Seeder {

    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            "nombre" => "TRÁMITES ISSSTE",
            "identificador" => "manual_tramites_issste",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p02_tramites_issste.pdf"
        ]);        
    }
}
