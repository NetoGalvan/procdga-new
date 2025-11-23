<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\Catalogo;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class CatalogosP06Seeder extends Seeder
{
    public function run()
    {
        $catalogo = Catalogo::create([
            'nombre' => 'INSTITUCIONES',
            'identificador' => 'CATINSTITUCIONES',
            'descripcion' => 'Administra las instituciones para el servicio social.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.catalogo.instituciones'
        ]);
        $catalogo->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id]);

        $catalogo = Catalogo::create([
            'nombre' => 'PRESTADORES',
            'identificador' => 'CATPRESTADORES',
            'descripcion' => 'Administra los prestadores para el servicio social.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.catalogo.prestadores'
        ]);
        $catalogo->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id]);

        $catalogo = Catalogo::create([
            'nombre' => 'ÁREAS DE ADSCRIPCIÓN',
            'identificador' => 'CATAREASDEADSCRIPCIÓN',
            'descripcion' => 'Administra las áreas de adscripción para realizar el servicio social',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.catalogo.areas.adscripcion'
        ]);
        $catalogo->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id]);
    }
}
