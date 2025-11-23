<?php

namespace Database\Seeders\p19_incentivos_empleado_mes;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP19Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            "nombre" => "INCENTIVO EMPLEADO DEL MES",
            "identificador" => "manual_incentivo_empleado_del_mes",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p19_incentivo_empleado_del_mes.pdf"
        ]);
    }
}
