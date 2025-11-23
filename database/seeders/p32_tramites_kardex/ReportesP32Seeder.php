<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP32Seeder extends Seeder
{
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'REPORTE PROCESOS KARDEX',
            'identificador' => 'reporte_procesos_kardex',
            'descripcion' => 'Generar reporte para los diferentes tipos de procesos del kardex.',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'reporte.procesos.tramites.kardex'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_KARDEX')->first()->id ]);
    }
}
