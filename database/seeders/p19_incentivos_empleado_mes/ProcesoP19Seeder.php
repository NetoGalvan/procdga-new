<?php

namespace Database\Seeders\p19_incentivos_empleado_mes;
use App\Models\Proceso;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ProcesoP19Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 19,
            'nombre' => 'INCENTIVO EMPLEADO DEL MES',
            'identificador' => 'incentivo_empleado_mes',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite otorgar y administrar la asignación del Incentivo al Servidor Público del Mes.',
            'ruta_descripcion' => 'incentivos.empleado.mes.descripcion',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "ADMN_INC_19", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 19.1,
            'proceso_padre_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'nombre' => 'INCENTIVO EMPLEADO DEL MES - SUBPROCESO',
            'identificador' => 'subproceso_incentivo_empleado_mes',
            'tipo' => 'SUBPROCESO',
            'descripcion' => 'Sub Proceso que permite la distribución de premios por sub áreas',
            'ruta_descripcion' => 'incentivos.empleado.mes.descripcion',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "SUB_EA", "inicializa_proceso" => true]]);
    }
}
