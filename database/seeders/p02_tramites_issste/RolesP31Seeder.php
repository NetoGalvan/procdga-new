<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesP31Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'JUD_PRES', 'label'=> 'JUD_PRES', 'descripcion' => 'Jefe de Unidad Departamental del Área de Prestaciones']);
    }
}
