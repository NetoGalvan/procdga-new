<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use Database\Seeders\p23_solicitud_expediente\ProcesoP23Seeder;
use Database\Seeders\p23_solicitud_expediente\ReportesP23Seeder;
use Database\Seeders\p23_solicitud_expediente\TareasP23DigitalizacionSeeder;
use Database\Seeders\p23_solicitud_expediente\TareasP23SolicitudSeeder;
use Database\Seeders\p23_solicitud_expediente\ManualesP23Seeder;
use Database\Seeders\p23_solicitud_expediente\DatabaseHistoricoSeederP23;

class DatabaseSeederP23 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP23Seeder::class);
        $this->call(ReportesP23Seeder::class);
        $this->call(TareasP23DigitalizacionSeeder::class);
        $this->call(TareasP23SolicitudSeeder::class);
        $this->call(ManualesP23Seeder::class);
        $this->call(DatabaseHistoricoSeederP23::class);
    }
}
