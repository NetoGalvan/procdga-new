<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP23Seeder extends Seeder
{
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            "nombre" => "DIGITALIZACIÓN DE ARCHIVO",
            "identificador" => "manual_digitalizacion_archivo",
            "descripcion" => "", 
            "ruta" => "pdf/manuales/p23_digitalizacion_archivo.pdf"
        ]);
    }
}
