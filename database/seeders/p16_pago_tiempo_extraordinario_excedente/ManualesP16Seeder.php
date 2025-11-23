<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP16Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            "nombre" => "PAGO DE TIEMPO EXTRAORDINARIO Y EXCEDENTE",
            "identificador" => "manual_tiempo_extraordinario_excedente",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p16_tiempo_extraordinario_excedente.pdf"
        ]);
    }
}
