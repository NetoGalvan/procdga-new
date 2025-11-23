<?php

namespace Database\Seeders\p12_tramites_incidencias;
use Illuminate\Database\Seeder;
use App\Models\Reporte;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ReportesP12Seeder extends Seeder
{
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE INCIDENCIAS',
            'identificador' => 'reporte_incidencias_por_empleado',
            'descripcion' => 'Generar reporte de las incidencias de un empleado',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.reporte.incidencias.empleado',
            "activo" => true
        ]);
        $reporte->attachRoles(["CTRL_KDX", "CAPT_KDX", "SUB_EA", "INI_JUST", "EMPLEADO_GRAL"]);

        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE DÍAS ACUMULADOS POR TIPO DE INCIDENCIA',
            'identificador' => 'reporte_incidencias_dias_acumulados',
            'descripcion' => 'Generar reporte de los dias acumulados por tipo de incidencias de un empleado',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.reporte.dias.acumulados',
            "activo" => true
        ]);
        $reporte->attachRoles(["CTRL_KDX", "CAPT_KDX", "SUB_EA", "INI_JUST", "EMPLEADO_GRAL"]);

        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE INCIDENCIAS AUTORIZADAS PARA ARCHIVO',
            'identificador' => 'reporte_incidencias_archivo',
            'descripcion' => 'Generar reporte de las incidencias autorizadas para archivo en un rango de tiempo',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.reporte.incidencias.archivo',
            "activo" => true
        ]);
        $reporte->attachRoles(["INI_JUST"]);
    }
}
