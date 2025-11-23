<?php

namespace Database\Seeders\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP22Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'reportes_dias_efectivamente_laborados')->first()->proceso_id,
            "nombre" => "REPORTES DE DÍAS EFECTIVAMENTE LABORADOS",
            "identificador" => "manual_reportes_dias_efectivamente_laborados",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p22_reportes_dias_efectivamente_laborados.pdf"
        ]);
    }
}
