<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\RegimenIssste;
use Illuminate\Database\Seeder;

class RegimenesIsssteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegimenIssste::create(['nombre' => 'AMPARADOS', 'identificador' => "A"]);
        RegimenIssste::create(['nombre' => 'BONO DE PENSIÓN EN UNA CUENTA INDIVIDUAL', 'identificador' => "C"]);
        RegimenIssste::create(['nombre' => 'RÉGIMEN DEL ARTÍCULO 10MO. TRANSITORIO DE LA LEY DEL ISSSTE', 'identificador' => "R"]);
    }
}
