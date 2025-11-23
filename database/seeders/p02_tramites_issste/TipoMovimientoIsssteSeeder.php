<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoMovimientoIsssteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_movimientos_issste')->insert(['nombre' => 'ALTA', 'identificador' => 'ALTAS']);
        DB::table('tipos_movimientos_issste')->insert(['nombre' => 'BAJA', 'identificador' => 'BAJAS']);
        DB::table('tipos_movimientos_issste')->insert(['nombre' => 'MODIFICACION', 'identificador' => 'REANUDACIONES']);
    }
}
