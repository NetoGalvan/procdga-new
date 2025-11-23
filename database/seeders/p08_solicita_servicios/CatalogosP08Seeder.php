<?php

namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use App\Models\Catalogo;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class CatalogosP08Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogo = Catalogo::create([
            'nombre' => 'VEHÍCULOS',
            'identificador' => 'CATVEHICULO',
            'descripcion' => 'Administra la asignación de vehículos a las áreas que tengan derecho a contar con un vehículo utilitario y los consumos de combustible y lubricantes así como registra el kilometraje recorrido por todos y cada uno de los vehículos.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.administrar.catalogo.vehiculos'
        ]);
        $catalogo->syncRoles([Role::select('id')->where('name', 'JUD_TRANSPORTE')->first()->id,
                                /* Role::select('id')->where('name', 'JUD_RM')->first()->id */]);

    }
}
