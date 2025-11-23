<?php

namespace Database\Seeders\p15_asistencia;
use Illuminate\Database\Seeder;
use App\Models\Reporte;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ReportesP15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reporte = Reporte::create([
            'nombre' => 'TARJETA ELECTRONICA DE ASISTENCIA',
            'identificador' => 'reporte_tarjeta_electronica',
            'descripcion' => 'Generar reporte de asistencias para los empleados.',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.reporte.tarjeta.electronica'
        ]);
        $reporte->attachRoles(["CONTROL_ASISTENCIA", "SUB_EA", "INI_JUST", "EMPLEADO_GRAL"]);

        $reporte = Reporte::create([
            'nombre' => 'TARJETA ELECTRONICA DE ASISTENCIA - CALENDARIO',
            'identificador' => 'reporte_tarjeta_electronica_calendario',
            'descripcion' => 'Generar reporte de asistencias para los empleados en formato de calendario.',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.reporte.calendario'
        ]);
        $reporte->attachRoles(["CONTROL_ASISTENCIA", "SUB_EA", "INI_JUST", "EMPLEADO_GRAL"]);

        $reporte = Reporte::create([
            'nombre' => 'EVENTOS DE ASISTENCIA',
            'identificador' => 'reporte_eventos_asistencia',
            'descripcion' => 'Generar reporte de eventos de los empleados.',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.reporte.eventos'
        ]);
        $reporte->attachRoles(["CONTROL_ASISTENCIA", "SUB_EA", "INI_JUST", "EMPLEADO_GRAL"]);
        
        $reporte = Reporte::create([
            'nombre' => 'REPORTE DE FALTAS, RETARDOS LEVES Y GRAVES',
            'identificador' => 'reporte_faltas',
            'descripcion' => 'Generar reporte ejecutivo de faltas',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.reporte.faltas'
        ]);
        $reporte->attachRoles(["CONTROL_ASISTENCIA"]);
        
        /* $reporte = Reporte::create([
            'nombre' => 'EVALUACIONES DE EMPLEADOS',
            'identificador' => 'reporte_evaluaciones_empleados',
            'descripcion' => 'Generar reporte de las evaluaciones de todos los empleados.',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.reporte.evaluaciones',
            "activo" => false
        ]);
        $reporte->attachRoles(["CONTROL_ASISTENCIA", "SUB_EA", "INI_JUST"]); */
    }
}
