<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use Database\Seeders\p06_servicio_social\CatalogoInstitucionSeeder;
use Database\Seeders\p06_servicio_social\EscuelaSeeder;
use Database\Seeders\p06_servicio_social\PrestadorSeeder;
use Database\Seeders\p06_servicio_social\ProgramasInstitucionSeeder;
use Database\Seeders\p06_servicio_social\ProcesoP06Seeder;
use Database\Seeders\p06_servicio_social\CatalogosP06Seeder;
use Database\Seeders\p06_servicio_social\TareasP06Seeder;
use Database\Seeders\p06_servicio_social\TareasP06SeederSubProceso;
use Database\Seeders\p06_servicio_social\ReportesP06Seeder;
use Database\Seeders\p06_servicio_social\ManualesP06Seeder;
use Database\Seeders\p06_servicio_social\CatAreasAdscripcionSeeder;
use Database\Seeders\p06_servicio_social\HistoricoP06Seeder;

class DatabaseSeederP06 extends Seeder
{
    public function run()
    {
        $this->call(CatAreasAdscripcionSeeder::class);
        $this->call(CatalogoInstitucionSeeder::class);
        $this->call(EscuelaSeeder::class);
        $this->call(ProgramasInstitucionSeeder::class);
        $this->call(PrestadorSeeder::class);
        $this->call(ProcesoP06Seeder::class);
        $this->call(CatalogosP06Seeder::class);
        $this->call(TareasP06Seeder::class);
        $this->call(TareasP06SeederSubProceso::class);
        $this->call(ReportesP06Seeder::class);
        $this->call(ManualesP06Seeder::class);
        $this->call(HistoricoP06Seeder::class);
    }
}
