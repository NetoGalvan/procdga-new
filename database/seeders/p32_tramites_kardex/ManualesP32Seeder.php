<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP32Seeder extends Seeder
{

    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            "nombre" => "TRÁMITES KARDEX",
            "identificador" => "manual_tramites_kardex",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p32_tramites_kardex.pdf"
        ]);
    }
}
