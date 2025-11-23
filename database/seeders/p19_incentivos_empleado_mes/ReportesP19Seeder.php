<?php

namespace Database\Seeders\p19_incentivos_empleado_mes;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP19Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA INCENTIVO EMPLEADO DEL MES',
            'identificador' => 'reporte_ejecutivo_incentivo_empleado_mes',
            'descripcion' => 'Generar reporte ejecutivo del incentivo empleado del mes',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.incentivo.empleado.mes'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'SUB_EA')->first()->id, Role::select('id')->where('name', 'OPER_INC_19')->first()->id ]);

        $reporte = Reporte::create([
            'nombre' => 'RELACIÓN DE EMPLEADOS INCENTIVO EMPLEADO DEL MES',
            'identificador' => 'reporte_relacion_empleados_incentivo_empleado_mes',
            'descripcion' => 'Relación de empleados',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'reporte.relacion.empleados.incentivo.empleado.mes'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'SUB_EA')->first()->id, Role::select('id')->where('name', 'OPER_INC_19')->first()->id ]);

        $reporte = Reporte::create([
            'nombre' => 'REPORTE CONCENTRADO DEL INCENTIVO EMPLEADO DEL MES',
            'identificador' => 'reporte_concentrado_incentivo_empleado_mes',
            'descripcion' => 'Generar reporte concentrado del incentivo empleado del mes',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'reporte.concentrado.incentivo.empleado.mes'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_PREMIO_PUNTUALIDAD')->first()->id ]);


    }
}
