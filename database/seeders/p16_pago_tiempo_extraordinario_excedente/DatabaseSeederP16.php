<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Seeder;

class DatabaseSeederP16 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProcesoP16Seeder::class);
        $this->call(TareasP16Seeder::class);
        $this->call(CatalogosP16Seeder::class);
        $this->call(P16CatalogoTabuladorSueldoTecnicoOperativo::class);
        $this->call(ReportesP16Seeder::class);
        /* $this->call(AreasProcesosSeeder::class); */
        $this->call(ManualesP16Seeder::class);
    }
}
