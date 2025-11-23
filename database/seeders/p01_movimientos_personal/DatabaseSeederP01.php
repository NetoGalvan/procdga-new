<?php

namespace Database\Seeders\p01_movimientos_personal;

use Illuminate\Database\Seeder;

class DatabaseSeederP01 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BancosSeeder::class);
        $this->call(TiposCalificacionesSeeder::class);
        $this->call(TiposMovimientosSeeder::class);
        $this->call(TiposMovimientosHonorariosSeeder::class);
        $this->call(EstadosCivilesTableSeeder::class);
        $this->call(SexosSeeder::class);
        $this->call(SituacionesEmpleadosSeeder::class);
        $this->call(TiposPagosSeeder::class);
        $this->call(TurnosSeeder::class);
        $this->call(RegimenesIsssteSeeder::class);
        $this->call(NivelesEstudiosTableSeeder::class);
        $this->call(LugaresCitaPsicometricoTableSeeder::class);
        $this->call(ZonasPagadorasSeeder::class);
        $this->call(ProcesoP01Seeder::class);
        $this->call(TiposDocumentosP01Seeder::class);
        $this->call(TareasP01Seeder::class);
        $this->call(ReportesP01Seeder::class);
        $this->call(ManualesP01Seeder::class);
    }
}
