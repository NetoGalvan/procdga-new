<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP21Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 21,
            'nombre' => 'PREMIO DE ADMINISTRACIÓN',
            'identificador' => 'premio_administracion',
            'tipo' => 'PROCESO',
            'descripcion' => 'Permitr la evaluación y postulación de los candidatos para partcipar en el otorgamiento de estmulos y recompensas.',
            'ruta_descripcion' => 'premio.administracion.descripcion',
            'icono' => 'fas fa-trophy',
            'activo' => false
        ]);
        $proceso->attachRoles([["name" => "ADMN_PA_21", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 21.1,
            'nombre' => 'INSCRIPCIÓN AL PREMIO DE ADMINISTRACIÓN',
            'identificador' => 'premio_administracion_inscripcion',
            'tipo' => 'PROCESO',
            'descripcion' => 'Inscribir al empleado al proceso de premio de administración.',
            'ruta_descripcion' => 'premio.administracion.inscripcion.descripcion',
            'icono' => 'fas fa-pencil-alt',
            'activo' => false
        ]);
        $proceso->attachRoles([["name" => "OPER_PA_21", "inicializa_proceso" => true]]);
    }
}
