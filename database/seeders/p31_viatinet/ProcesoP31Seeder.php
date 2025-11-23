<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\Proceso;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ProcesoP31Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 31,
            'nombre' => 'VIATINET',
            'identificador' => 'viatinet',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite solicitar un viático',
            'ruta_descripcion' => 'viatinet.descripcion',
            'icono' => 'fas fa-plane-departure',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "ENLACE_CAPTURA_VIATICO", "inicializa_proceso" => true]]);
    }
}
