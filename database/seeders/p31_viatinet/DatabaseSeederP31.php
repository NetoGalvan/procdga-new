<?php

namespace Database\Seeders\p31_viatinet;

use Illuminate\Database\Seeder;

class DatabaseSeederP31 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TiposFinanciamientosSeeder::class);
        $this->call(TiposPartidasSeeder::class);
        $this->call(TiposZonasTarifariasSeeder::class);
        $this->call(LugaresZonasTarifariasSeeder::class);
        $this->call(ProcesoP31Seeder::class);
        $this->call(TiposDocumentosP31Seeder::class);
        $this->call(TareasP31Seeder::class); 
    }
}
