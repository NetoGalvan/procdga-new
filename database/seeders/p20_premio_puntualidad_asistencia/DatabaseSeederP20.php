<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\ProcesoP20Seeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\TareasP20Seeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\TareasP20SubprocesoSeeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\UsersP20Seeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\ReportesP20Seeder;
use Database\Seeders\p20_premio_puntualidad_asistencia\ManualesP20Seeder;

class DatabaseSeederP20 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP20Seeder::class);
        $this->call(TareasP20Seeder::class);
        $this->call(TareasP20SubprocesoSeeder::class);
        $this->call(ReportesP20Seeder::class);
        $this->call(ManualesP20Seeder::class);
    }
}
