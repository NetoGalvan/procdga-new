<?php

namespace Database\Seeders\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Seeder;
use Database\Seeders\p22_reportes_dias_efectivamente_laborados\ProcesoP22Seeder;
use Database\Seeders\p22_reportes_dias_efectivamente_laborados\TareasP22Seeder;
use Database\Seeders\p22_reportes_dias_efectivamente_laborados\UsersP22Seeder;
use Database\Seeders\p22_reportes_dias_efectivamente_laborados\ManualesP22Seeder;

class DatabaseSeederP22 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP22Seeder::class);
        $this->call(TareasP22Seeder::class);
        $this->call(ManualesP22Seeder::class);
    }
}
