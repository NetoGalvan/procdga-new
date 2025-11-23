<?php

namespace Database\Seeders\p12_tramites_incidencias;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class ProcesoP12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 12,
            'nombre' => 'INCIDENCIAS',
            'identificador' => 'tramites_incidencias',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso que permite a los administradores de las diferentes unidades administrativas gestionar la aplicación de incidencias de los trabajadores.',
            'ruta_descripcion' => 'tramite.incidencia.descripcion',
            'icono' => 'fas fa-user-check'
        ]);
        $proceso->attachRoles([
            ["name" => "INI_JUST", "inicializa_proceso" => true],
            ["name" => "EMPLEADO_GRAL", "inicializa_proceso" => true],
            ["name" => "CAPT_KDX", "inicializa_proceso" => true],
        ]);

        // NOTAS BUENAS
        $proceso = Proceso::create([
            'numero_proceso' => 12.1,
            'nombre' => 'NOTAS BUENAS',
            'identificador' => 'notas_buenas',
            'tipo' => 'AUTOPROCESO',
            'descripcion' => 'Proceso optimizado que permite calcular, monitorear y aplicar las notas buenas de los empleados sindicalizados adscritos a la Secretaría de Finanzas con base en sus registros de asistencia y puntualidad quincenales y/o mensuales.',
            'ruta_descripcion' => 'notas.buenas.descripcion',
            'icono' => 'fas fa-clipboard-check'
        ]);
    }
}
