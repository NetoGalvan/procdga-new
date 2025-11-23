<?php

namespace Database\Seeders\p01_movimientos_personal;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP01Seeder extends Seeder {

    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            "nombre" => "MOVIMIENTOS DE PERSONAL - ALTAS",
            "identificador" => "manual_movimientos_personal_altas",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p01_movimientos_personal_ALTAS.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            "nombre" => "MOVIMIENTOS DE PERSONAL - BAJAS",
            "identificador" => "manual_movimientos_personal_bajas",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p01_movimientos_personal_BAJAS.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            "nombre" => "MOVIMIENTOS DE PERSONAL - REANUDACIONES",
            "identificador" => "manual_movimientos_personal_reanudaciones",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p01_movimientos_personal_REANUDACIONES.pdf"
        ]);
    }
}
