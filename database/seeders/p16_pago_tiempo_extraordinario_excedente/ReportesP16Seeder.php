<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP16Seeder extends Seeder
{
    public function run()
    {
        // Reporte 1. REPORTE DE EMPLEADOS INCLUIDOS EN EL PAGO DE TIEMPO EXTRA Y EXCEDENTE
        // Para el rol ADMIN_TIEMPO_EXTRA y SUB_EA
        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE EMPLEADOS INCLUIDOS EN EL PAGO DE TIEMPO EXTRA Y EXCEDENTE',
            'identificador' => 'reporte_empleados_incluidos_pago',
            'descripcion' => 'Generar reporte de los empleados incluidos en el pago',
            'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            'ruta' => 'reporte.empleados.incluidos'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_TIEMPO_EXTRA')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id ]);

        // Reporte 2. REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PAGO DE TIEMPO EXTRA Y EXCEDENTE
        // Para el rol ADMIN_TIEMPO_EXTRA y SUB_EA
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PAGO DE TIEMPO EXTRA Y EXCEDENTE',
            'identificador' => 'reporte_ejecutivo_procesos_ejecutados',
            'descripcion' => 'Generar reporte ejecutivo de los procesos que fueron ejecutados',
            'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.procesos.ejecutados'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_TIEMPO_EXTRA')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id ]);
    }
}
