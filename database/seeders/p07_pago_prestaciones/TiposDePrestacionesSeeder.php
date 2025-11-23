<?php

namespace Database\Seeders\p07_pago_prestaciones;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDePrestacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_prestaciones')->insert(['nombre' => 'DÍA DEL NIÑO', 'identificador' => 'dia_del_nino']);
        DB::table('tipos_prestaciones')->insert(['nombre' => 'DÍA DE LA MADRE', 'identificador' => 'dia_de_la_madre']);
        DB::table('tipos_prestaciones')->insert(['nombre' => 'DÍA DEL PADRE', 'identificador' => 'dia_del_padre']);
        DB::table('tipos_prestaciones')->insert(['nombre' => 'ÚTILES ESCOLARES', 'identificador' => 'utiles_escolaes']);
    }
}
