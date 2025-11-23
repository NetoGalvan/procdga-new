<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP20Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            "nombre" => "PREMIO DE PUNTUALIDAD Y ASISTENCIA",
            "identificador" => "manual_premio_puntualidad_asistencia",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p20_premio_puntualidad_asistencia.pdf"
        ]);
    }
}
