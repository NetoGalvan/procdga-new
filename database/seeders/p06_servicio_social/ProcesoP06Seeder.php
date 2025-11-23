<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP06Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 6,
            'nombre' => 'SERVICIO SOCIAL',
            'identificador' => 'servicio_social',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite realizar el tramite de servicio social de un candidato',
            'ruta_descripcion' => 'servicio.social.descripcion',
            'icono' => 'fas fa-address-card',
        ]);
        $proceso->attachRoles([["name" => "SUB_EA", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 6.1,
            'nombre' => 'SERVICIO SOCIAL - NOMINA',
            'identificador' => 'servicio_social_nomina',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite realizar la nómina de los candidatos',
            'ruta_descripcion' => 'servicio.social.nomina.descripcion',
            'icono' => 'fas fa-money-check-alt',
        ]);
        $proceso->attachRoles([["name" => "PROG_SS", "inicializa_proceso" => true]]);
    }
}
