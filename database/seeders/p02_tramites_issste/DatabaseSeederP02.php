<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;

class DatabaseSeederP02 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoMovimientoIsssteSeeder::class);
        $this->call(TipoNombramientoSeeder::class);
        $this->call(ProcesoP02Seeder::class);
        $this->call(TareasP02Seeder::class);
        $this->call(CatalogosP02Seeder::class);
        $this->call(ReportesP02Seeder::class);
        $this->call(ManualesP02Seeder::class);
    }
}
