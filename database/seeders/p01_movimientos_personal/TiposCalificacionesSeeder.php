<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\TipoCalificacionPsicometrico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposCalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TipoCalificacionPsicometrico::create(['nombre' => 'RECOMENDABLE', 'identificador' => "recomendable"]);
        TipoCalificacionPsicometrico::create(['nombre' => 'NO RECOMENDABLE', 'identificador' => "no_recomendable"]);
        TipoCalificacionPsicometrico::create(['nombre' => 'RECOMENDABLE CON RESERVAS', 'identificador' => "recomendable_con_reservas"]);
    }
}
