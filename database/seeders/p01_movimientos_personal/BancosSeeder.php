<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\Banco;
use Illuminate\Database\Seeder;

class BancosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Banco::create(['nombre' => 'AFIRME', 'abreviatura' => 'BAFI', 'numero_sucursal'=>'036', 'identificador' => "BAFI"]);
        Banco::create(['nombre' => 'BANORTE', 'abreviatura' => 'BNTE', 'numero_sucursal'=>'310', 'identificador' => "BNTE"]);
    }
}
