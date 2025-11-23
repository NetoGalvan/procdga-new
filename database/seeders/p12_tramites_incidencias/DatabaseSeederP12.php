<?php

namespace Database\Seeders\p12_tramites_incidencias;


use Database\Seeders\p12_tramites_incidencias\ProcesoP12Seeder;
use Database\Seeders\p12_tramites_incidencias\ReportesP12Seeder;
use Database\Seeders\p12_tramites_incidencias\TareasP12Seeder;
use Database\Seeders\p12_tramites_incidencias\TiposCapturaP12Seeder;
use Database\Seeders\p12_tramites_incidencias\TiposJustificacionesP12Seeder;
use Illuminate\Database\Seeder;

class DatabaseSeederP12 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Proceso 12 - Incidencias
        $this->call(TiposJustificacionesP12Seeder::class);
        $this->call(TiposIncidenciasP12Seeder::class);
        $this->call(TiposCapturaP12Seeder::class);
        $this->call(ProcesoP12Seeder::class);
        $this->call(TareasP12Seeder::class);
        $this->call(ReportesP12Seeder::class);
        $this->call(CatalogosP12Seeder::class);
        $this->call(ManualesP12Seeder::class);

        // Proceso 14 - Historial Kardex
        /* $this->call(ProcesoP14Seeder::class);
        $this->call(TareasP14Seeder::class); */
    }
}
