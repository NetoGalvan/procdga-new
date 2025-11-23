<?php

namespace Database\Seeders\p12_tramites_incidencias;

use App\Models\Catalogo;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class CatalogosP12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogo = Catalogo::create([
            'nombre' => 'TIPOS DE INCIDENCIAS',
            'identificador' => 'catalogo_tipos_incidencias',
            'descripcion' => 'Administra los tipos de incidencias.',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.catalogo.tipos.incidencias'
        ]);
        $catalogo->attachRoles(["CTRL_KDX"]);
    }
}
