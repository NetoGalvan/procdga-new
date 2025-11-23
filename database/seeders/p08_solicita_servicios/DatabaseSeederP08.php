<?php

namespace Database\Seeders\p08_solicita_servicios;

use Illuminate\Database\Seeder;
use Database\Seeders\p08_solicita_servicios\ServiciosGeneralesSeeder;
use Database\Seeders\p08_solicita_servicios\ServiciosSeeder;
use Database\Seeders\p08_solicita_servicios\ProcesoP08Seeder;
use Database\Seeders\p08_solicita_servicios\TareasP08Seeder;
use Database\Seeders\p08_solicita_servicios\CatalogosP08Seeder;
use Database\Seeders\p08_solicita_servicios\ReportesP08Seeder;
use Database\Seeders\p08_solicita_servicios\VehiculosP08Seeder;

class DatabaseSeederP08 extends Seeder
{
    public function run()
    {
        $this->call(ServiciosGeneralesSeeder::class);
        $this->call(ServiciosSeeder::class);
        $this->call(ProcesoP08Seeder::class);
        $this->call(TareasP08Seeder::class);
        $this->call(CatalogosP08Seeder::class);
        $this->call(ReportesP08Seeder::class);
        $this->call(ManualesP08Seeder::class);
        $this->call(VehiculosP08Seeder::class);
    }
}
