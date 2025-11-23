<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\SituacionEmpleado;
use Illuminate\Database\Seeder;

class SituacionesEmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SituacionEmpleado::create([
            'nombre' => 'SANCIONADO', 
            'codigo' => '0',
            'identificador' => '0'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'DEFINITIVO', 
            'codigo' => '1',
            'identificador' => '1'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'LICENCIA CON SUELDO', 
            'codigo' => '2',
            'identificador' => '2'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'LICENCIA CON MEDIO SUELDO', 
            'codigo' => '3',
            'identificador' => '3'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'LICENCIA SIN SUELDO', 
            'codigo' => '4',
            'identificador' => '4'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'INTERINO', 
            'codigo' => '5',
            'identificador' => '5'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'PROVISIONAL', 
            'codigo' => '6',
            'identificador' => '6'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'SITUACION INVALIDA', 
            'codigo' => '7',
            'identificador' => '7'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'SUSPENDIDA', 
            'codigo' => '9',
            'identificador' => '9'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'BAJA', 
            'codigo' => 'B',
            'identificador' => 'B'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'CONFIANZA', 
            'codigo' => 'C',
            'identificador' => 'C'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'EVENTUAL EXTRAORDINARIO', 
            'codigo' => 'E',
            'identificador' => 'E'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'HONORARIOS', 
            'codigo' => 'H',
            'identificador' => 'H'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'EVENTUAL ORDINARIO', 
            'codigo' => 'O',
            'identificador' => 'O'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'CARACTER SOCIAL', 
            'codigo' => 'S',
            'identificador' => 'S'
        ]);
        SituacionEmpleado::create([
            'nombre' => 'TEMPORAL', 
            'codigo' => 'T',
            'identificador' => 'T'
        ]);
    }
}
