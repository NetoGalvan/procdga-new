<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\p31_viatinet\TipoZonaTarifaria;
use Illuminate\Database\Seeder;

class TiposZonasTarifariasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoZonaTarifaria::create([
            'nombre' => 'I',
            "identificador" => 'zona_1_nacional',
            'tipo_ambito_id' => 1,
            "tarifa_a" => 1469,
            "tarifa_b" => 1108,
            "tarifa_c" => 867
        ]);

        TipoZonaTarifaria::create([
            'nombre' => 'II',
            "identificador" => 'zona_2_nacional',
            'tipo_ambito_id' => 1,
            "tarifa_a" => 1129,
            "tarifa_b" => 881,
            "tarifa_c" => 741
        ]);

        TipoZonaTarifaria::create([
            'nombre' => 'III',
            "identificador" => 'zona_3_nacional',
            'tipo_ambito_id' => 1,
            "tarifa_a" => 1104,
            "tarifa_b" => 794,
            "tarifa_c" => 643
        ]);
        
        TipoZonaTarifaria::create([
            'nombre' => 'I',
            "identificador" => 'zona_1_internacional',
            'tipo_ambito_id' => 2,
            "tarifa_a" => 554,
            "tarifa_b" => 533,
            "tarifa_c" => 492,
            "tarifa_d" => 432,
            "tarifa_e" => 368
        ]);

        TipoZonaTarifaria::create([
            'nombre' => 'II',
            "identificador" => 'zona_2_internacional',
            'tipo_ambito_id' => 2,
            "tarifa_a" => 512,
            "tarifa_b" => 492,
            "tarifa_c" => 451,
            "tarifa_d" => 388,
            "tarifa_e" => 308
        ]);
    }
}
