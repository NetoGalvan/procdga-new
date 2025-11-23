<?php

namespace Database\Seeders\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class TareasP22Seeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' =>  'SELECCIÓN DE REPORTE Y PERIODO DE EVALUACIÓN',
            'identificador' =>  'TRDEL01',
            'descripcion' => 'Seleccionar el tipo de reporte que se desea generar y el periodo de evaluación',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'reportes_dias_efectivamente_laborados')->first()->proceso_id,
            'ruta' => 'reportes.dias.efectivamente.laborados.seleccion.reporte'
        ]);
        $tarea->attachRoles(["ADMN_REP_22"]);

        $tarea = Tarea::create([
            'nombre' =>  'REVISIÓN Y CONCENTRADO DE EMPLEADOS',
            'identificador' =>  'TRDEL02',
            'descripcion' => 'Descargar el listado para revisión de empleados que serán incluídos para la evaluación y añadir empleados faltantes',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'reportes_dias_efectivamente_laborados')->first()->proceso_id,
            'ruta' => 'reportes.dias.efectivamente.laborados.revision.concentrado.empleados'
        ]);
        $tarea->attachRoles(["ADMN_REP_22"]);

        $tarea = Tarea::create([
            'nombre' =>  'GENERACIÓN DE REPORTE',
            'identificador' =>  'TRDEL03',
            'descripcion' => 'Generar y descargar el archivo correspondiente al tipo de reporte seleccionado',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'reportes_dias_efectivamente_laborados')->first()->proceso_id,
            'ruta' => 'reportes.dias.efectivamente.laborados.generacion.reporte'
        ]);
        $tarea->attachRoles(["ADMN_REP_22"]);
    }
}
