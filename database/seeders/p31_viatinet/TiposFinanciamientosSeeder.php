<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\p31_viatinet\TipoFinanciamiento;
use Illuminate\Database\Seeder;

class TiposFinanciamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFinanciamiento::create([
            'nombre' => 'NO',
            'identificador' => 'no',
        ]);

        TipoFinanciamiento::create([
            'nombre' => 'PARCIAL SOLO PASAJES',
            'identificador' => 'parcial_solo_pasajes',
        ]);

        TipoFinanciamiento::create([
            'nombre' => 'PARCIAL SOLO VIATICOS',
            'identificador' => 'parcial_solo_viaticos',
        ]);

        TipoFinanciamiento::create([
            'nombre' => 'PARCIAL VIATICOS Y PASAJES',
            'identificador' => 'parcial_viaticos_pasajes',
        ]);

        TipoFinanciamiento::create([
            'nombre' => 'TOTAL',
            'identificador' => 'total',
        ]);
    }
}
