<?php

namespace Database\Seeders\p15_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 15,
            'nombre' => 'ASISTENCIA',
            'identificador' => 'asistencia',
            'tipo' => 'AUTOPROCESO',
            'descripcion' => 'Proceso optimizado que permite evaluar los registros de asistencia de los trabajadores guardados en las terminales biométricas y mantenerlos disponibles para diversos procesos automatizados del sistema PROCDGA',
            'ruta_descripcion' => 'asistencia.descripcion',
            'icono' => 'fas fa-calendar-check',
        ]);
        $proceso->attachRoles([["name" => "CONTROL_ASISTENCIA", "inicializa_proceso" => true]]);
    }
}
