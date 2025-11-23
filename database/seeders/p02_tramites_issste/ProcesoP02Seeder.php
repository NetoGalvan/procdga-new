<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 2,
            'nombre' => 'TRÁMITES ISSSTE',
            'identificador' => 'tramites_issste',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite agilizar los documentos requeridos por el ISSSTE con respecto a las altas, bajas y modificaciones de la plantilla de personal de la SecretarÍa de Finanzas.',
            'ruta_descripcion' => 'tramites.issste.descripcion',
            'icono' => 'fas fa-file-medical',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "JUD_PRES", "inicializa_proceso" => true]]);
    }
}
