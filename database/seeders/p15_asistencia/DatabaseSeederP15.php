<?php

namespace Database\Seeders\p15_asistencia;

use Illuminate\Database\Seeder;

class DatabaseSeederP15 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProcesoP15Seeder::class);
        $this->call(ReportesP15Seeder::class);
        $this->call(CatalogosP15Seeder::class);
        $this->call(P15DiasFestivosSeeder::class);
        $this->call(P15HorariosTableSeeder::class);
        $this->call(P15HorariosIntervalosTableSeeder::class);
        $this->call(BiometricosSeeder::class);
    }
}
