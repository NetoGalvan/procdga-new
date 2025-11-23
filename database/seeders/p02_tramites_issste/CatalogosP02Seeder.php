<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use App\Models\Catalogo;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class CatalogosP02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $catalogo = Catalogo::create([
            'nombre' => 'NIVELES SALARIALES',
            'identificador' => 'catalogo_niveles_salariales',
            'descripcion' => 'Administra la información de los Niveles Salariales.',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'niveles-salariales.index'
        ]);

        $catalogo->syncRoles([Role::where('name', 'JUD_PRES')->first()->id]); */
    }
}
