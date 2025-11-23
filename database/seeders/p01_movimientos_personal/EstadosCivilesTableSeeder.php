<?php

namespace Database\Seeders\p01_movimientos_personal;

use Illuminate\Database\Seeder;
use App\Models\p01_movimientos_personal\EstadoCivil;    

class EstadosCivilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        EstadoCivil::Create([
            'nombre' => 'SOLTERO (A)',
            'identificador' => "soltero"
        ]);

        EstadoCivil::Create([
            'nombre' => 'CASADO (A)',
            'identificador' => "casado"
        ]);

        EstadoCivil::Create([
            'nombre' => 'UNIÓN LIBRE',
            'identificador' => "union_libre"
        ]);

        EstadoCivil::Create([
            'nombre' => 'DIVORCIADO (A)',
            'identificador' => "divorciado"
        ]);

        EstadoCivil::Create([
            'nombre' => 'VIUDO (A)',
            'identificador' => "viudo"
        ]);

        EstadoCivil::Create([
            'nombre' => 'OTRO',
            'identificador' => "otro"
        ]);
    }
}
