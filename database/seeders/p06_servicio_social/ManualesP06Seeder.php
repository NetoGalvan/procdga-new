<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP06Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            "nombre" => "SERVICIO SOCIAL",
            "identificador" => "manual_servicio_social",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p06_servicio_social.pdf"
        ]);

        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'servicio_social_nomina')->first()->proceso_id,
            "nombre" => "NÓMINA - SERVICIO SOCIAL",
            "identificador" => "manual_nomina_servicio_social",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p06_nomina_servicio_social.pdf"
        ]);
    }
}
