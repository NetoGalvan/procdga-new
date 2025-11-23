<?php

namespace Database\Seeders\p02_tramites_issste;

use App\Models\Proceso;
use App\Models\Reporte;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ReportesP02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE MOVIMIENTOS ANTE EL ISSSTE',
            'identificador' => 'reporte_tramites_issste_movimientos',
            'descripcion' => 'Reporte de movimientos ante el ISSSTE',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'tramites.issste.reporte.movimientos'
        ]);
        $reporte->syncRoles([Role::select('id')->where('name', 'JUD_PRES')->first()->id]);

        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DE PROCESOS DEL ISSSTE',
            'identificador' => 'reporte_tramites_issste_procesos',
            'descripcion' => 'Reporte ejecutivo de procesos del ISSSTE',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'tramites.issste.reporte.procesos'
        ]);
        $reporte->syncRoles([Role::select('id')->where('name', 'JUD_PRES')->first()->id]);
    }
}
