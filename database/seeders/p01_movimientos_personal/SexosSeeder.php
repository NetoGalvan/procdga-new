<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\Sexo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Sexo::create(['nombre' => 'FEMENINO', 'identificador' => "F"]);
        Sexo::create(['nombre' => 'MASCULINO', 'identificador' => "M"]);
    }
}
