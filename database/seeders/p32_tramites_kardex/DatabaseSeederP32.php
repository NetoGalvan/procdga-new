<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use Database\Seeders\p32_tramites_kardex\ProcesoP32Seeder;
use Database\Seeders\p32_tramites_kardex\TareasP32Seeder;
use Database\Seeders\p32_tramites_kardex\TiposTramitesKardexSeeder;
use Database\Seeders\p32_tramites_kardex\ReportesP32Seeder;

class DatabaseSeederP32 extends Seeder
{
    public function run()
    {
        $this->call(ProcesoP32Seeder::class);
        $this->call(TareasP32Seeder::class);
        $this->call(TiposTramitesKardexSeeder::class);
        $this->call(ReportesP32Seeder::class);
        $this->call(ManualesP32Seeder::class);
        $this->call(FormatosSeederP32::class);
        $this->call(CatalogosP32Seeder::class);
    }
}
