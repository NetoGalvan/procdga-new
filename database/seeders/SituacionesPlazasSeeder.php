<?php

namespace Database\Seeders;

use App\Models\SituacionPlaza;
use Illuminate\Database\Seeder;

class SituacionesPlazasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SituacionPlaza::create(['nombre' => 'CANCELADA', 'identificador' => 'B']);
        SituacionPlaza::create(['nombre' => 'CONFIANZA', 'identificador' => 'C']);
        SituacionPlaza::create(['nombre' => 'HONORARIOS', 'identificador' => 'H']);
        SituacionPlaza::create(['nombre' => 'CARACTER SOCIAL', 'identificador' => 'S']);
        SituacionPlaza::create(['nombre' => 'SANCIÓN', 'identificador' => '0']);
        SituacionPlaza::create(['nombre' => 'DEFINITIVO Y/O PROPIEDAD', 'identificador' => '1' ]);
        SituacionPlaza::create(['nombre' => 'LICENCIA CON SUELDO', 'identificador' => '2']);
        SituacionPlaza::create(['nombre' => 'LICENCIA A MEDIO SUELDO', 'identificador' => '3']);
        SituacionPlaza::create(['nombre' => 'LICENCIA SIN SUELDO', 'identificador' => '4']);
        SituacionPlaza::create(['nombre' => 'INTERINATO', 'identificador' => '5']);
        SituacionPlaza::create(['nombre' => 'PROVISIONAL', 'identificador' => '6']);
        SituacionPlaza::create(['nombre' => 'VACANTE', 'identificador' => '7']);
        SituacionPlaza::create(['nombre' => 'CONGELADA', 'identificador' => '8']);
        SituacionPlaza::create(['nombre' => 'SUSPENSIÓN', 'identificador' => '9']);
        SituacionPlaza::create(['nombre' => 'EVENTUAL ORDINARIO', 'identificador' => 'O']);
        SituacionPlaza::create(['nombre' => 'EVENTUAL EXTRAORDINARIO', 'identificador' => 'E']);
        SituacionPlaza::create(['nombre' => 'TEMPORAL', 'identificador' => 'T']);
        SituacionPlaza::create(['nombre' => 'SIN DEFINIR', 'identificador' => 'P']);
    }
}
