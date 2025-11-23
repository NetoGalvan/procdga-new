<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use Database\Seeders\p21_premio_administracion\ProcesoP21Seeder;
use Database\Seeders\p21_premio_administracion\TareasP21Seeder;
use Database\Seeders\p21_premio_administracion\TareasP21SeederInscripcion;
use Database\Seeders\p21_premio_administracion\ReportesP21Seeder;
use Database\Seeders\p21_premio_administracion\ManualesP21Seeder;
use Database\Seeders\p21_premio_administracion\UsersP21Seeder;

class DatabaseSeederP21 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP21Seeder::class);
        $this->call(TareasP21Seeder::class);
        $this->call(TareasP21SeederInscripcion::class);
        $this->call(ReportesP21Seeder::class);
        $this->call(ManualesP21Seeder::class);
    }
}
