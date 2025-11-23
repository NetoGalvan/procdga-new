<?php

namespace Database\Seeders\p01_movimientos_personal;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP01Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 1,
            'nombre' => 'MOVIMIENTOS DE PERSONAL',
            'identificador' => 'movimientos_personal',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite generar los formatos requeridos por el SUN',
            'ruta_descripcion' => 'movimiento.personal.descripcion',
            'icono' => 'fas fa-users'
        ]);
        $proceso->attachRoles([["name" => "SUB_EA", "inicializa_proceso" => true]]);
    }
}
