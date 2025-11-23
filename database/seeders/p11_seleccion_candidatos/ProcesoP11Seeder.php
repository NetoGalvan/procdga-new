<?php

namespace Database\Seeders\p11_seleccion_candidatos;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP11Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $proceso = Proceso::create([
            'numero_proceso' => 11,
            'nombre' => 'SELECCIÓN DE CANDIDATOS DE PERSONAL DE ESTRUCTURA',
            'identificador' => 'seleccion_candidatos',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite generar los formatos requeridos por el Sistema Integral Desconcentrado de Nómina SUN',
            'ruta_descripcion' => 'seleccion.candidatos.descripcion',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "INI_CAND", "inicializa_proceso" => true]]);
    }
}

