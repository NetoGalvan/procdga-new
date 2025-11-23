<?php

namespace Database\Seeders\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP22Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 22,
            'nombre' => 'REPORTES DE DÍAS EFECTIVAMENTE LABORADOS',
            'identificador' => 'reportes_dias_efectivamente_laborados',
            'tipo' => 'PROCESO',
            'descripcion' => 'Reportar el número de días efectivamente laborados con base a los criterios de evaluación de asistencia y puntualidad de los empleados para 3 tipos de reportes diferentes.',
            'ruta_descripcion' => 'reportes.dias.efectivamente.laborados.descripcion',
            'icono' => 'fas fa-calendar-alt',
        ]);
        $proceso->attachRoles([["name" => "ADMN_REP_22", "inicializa_proceso" => true]]);
    }
}
