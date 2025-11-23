<?php

namespace Database\Seeders\p14_captura_kardex;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP14Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 14,
            'nombre' => 'CAPTURA DE KARDEX',
            'identificador' => 'historial',
            'tipo' => 'PROCESO',
            'descripcion' => 'Captura y/o edición del Historial Kardex.',
            'ruta_descripcion' => 'historial.kardex.descripcion',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "CAPT_KDX", "inicializa_proceso" => true]]);
    }
}
