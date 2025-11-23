<?php

namespace Database\Seeders\p02_tramites_issste;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoNombramientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'BASE', 'identificador' => 1]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'CONFIANZA', 'identificador' => 2]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'EVENTUAL', 'identificador' => 3]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'BASE / LISTA DE RAYA', 'identificador' => 4]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'LISTA DE RAYA', 'identificador' => 5]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'OTROS', 'identificador' => 6]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'CONTINUACION VOLUNTARIA', 'identificador' => 7]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'PENSIONISTA', 'identificador' => 8]);
        DB::table('tipos_nombramientos_issste')->insert(['nombre' => 'APORTACIÓN VOLUNTARIA(S.A.R)', 'identificador' => 9]);
    }
}
