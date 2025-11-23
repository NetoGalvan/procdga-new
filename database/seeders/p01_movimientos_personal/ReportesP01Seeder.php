<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\Proceso;
use App\Models\Reporte;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ReportesP01Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE MOVIMIENTOS DE PERSONAL',
            'identificador' => 'reporte_movimiento_personal',
            'descripcion' => 'Generar reporte acerca de los movimientos de personal',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.reporte.movimientos'
        ]);
        $reporte->syncRoles([Role::where('name', 'JUD_MP')->first()->id, Role::where('name', 'SUB_EA')->first()->id]);
    }
}
