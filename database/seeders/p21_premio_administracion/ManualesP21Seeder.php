<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP21Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            "nombre" => "PREMIO DE ADMINISTRACIÓN",
            "identificador" => "manual_premio_administracion",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p21_manual_premio_administracion.pdf"
        ]);

        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'premio_administracion_inscripcion')->first()->proceso_id,
            "nombre" => "INSCRIPCIÓN AL PREMIO DE ADMINISTRACIÓN",
            "identificador" => "manual_inscripcion_premio_administración",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p21_manual_inscripcion_premio_administracion.pdf"
        ]);
    }
}
