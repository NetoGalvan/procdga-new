<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;
use App\Models\p01_movimientos_personal\LugarCitaPsicometrico;

class LugaresCitaPsicometricoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LugarCitaPsicometrico::create([
            'nombre' => 'ÁREA DE MOVIMIENTOS DE PERSONAL DE LA SECRETARÍA DE FINANZAS',
            'direccion' => 'DR. LAVISTA 144, CUAUHTÉMOC, 06720 CUAUHTEMOC, CDMX',
            'telefono' => '5555883388',
            'extension' => '12345',
            'dependencia_id' => Dependencia::where("identificador", "secretaria_finanzas")->first()->dependencia_id
        ]);
    }
}
