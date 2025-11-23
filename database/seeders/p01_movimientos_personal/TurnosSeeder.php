<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\Turno;
use Illuminate\Database\Seeder;

class TurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Turno::create(['nombre' => 'MATUTINO DE 7 A 14 HRS', 'numero_horas_turno' => '7 HRS', 'identificador' => 1]);
        Turno::create(['nombre' => 'MATUTINO DE 8 A 15 HRS', 'numero_horas_turno' => '7 HRS', 'identificador' => 2]);
        Turno::create(['nombre' => 'MATUTINO DE 9 A 15 HRS', 'numero_horas_turno' => '6 HRS', 'identificador' => 3]);
        Turno::create(['nombre' => 'MATUTINO DE 6 A 14 HRS', 'numero_horas_turno' => '8 HRS', 'identificador' => 4]);
        Turno::create(['nombre' => 'VESPERTINO 15 A 21 HRS', 'numero_horas_turno' => '6 HRS', 'identificador' => 5]);
        Turno::create(['nombre' => 'VESPERTINO - NOCTURNO DE 16 A 23 HRS', 'numero_horas_turno' => '7 HRS', 'identificador' => 6]);
        Turno::create(['nombre' => '12 - 36 TURNO ESPECIAl', 'numero_horas_turno' => '8 HRS', 'identificador' => 7]);
        Turno::create(['nombre' => '12 - 48 TURNO ESPECIAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 8]);
        Turno::create(['nombre' => '12 - 24 TURNO ESPECIAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 9]);
        Turno::create(['nombre' => '24 - 24 TURNO ESPECIAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 10]);
        Turno::create(['nombre' => '24 - 48 TURNO ESPECIAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 11]);
        Turno::create(['nombre' => '24 - 72 TURNO ESPECIAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 12]);
        Turno::create(['nombre' => '24 - 00 TURNO SEMANAL', 'numero_horas_turno' => '8 HRS', 'identificador' => 13]);
        Turno::create(['nombre' => '12 HRS. SÁBADOS, DOMINGOS Y DÍAS FESTIVOS', 'numero_horas_turno' => '8 HRS', 'identificador' => 14]);
        Turno::create(['nombre' => 'MATUTINO 9 A 16 HRS', 'numero_horas_turno' => '8 HRS', 'identificador' => 15]);
        Turno::create(['nombre' => 'HONORARIOS DISCONTINUOS', 'numero_horas_turno' => '5 HRS', 'identificador' => 16]);
        Turno::create(['nombre' => 'HONORARIOS DISCONTINUOS', 'numero_horas_turno' => '4 HRS', 'identificador' => 17]);
        Turno::create(['nombre' => 'HONORARIOS DISCONTINUOS', 'numero_horas_turno' => '3 HRS', 'identificador' => 18]);
        Turno::create(['nombre' => 'HONORARIOS DISCONTINUOS', 'numero_horas_turno' => '2 HRS', 'identificador' => 19]);
        Turno::create(['nombre' => 'HONORARIOS DISCONTINUOS', 'numero_horas_turno' => '1 HRS', 'identificador' => 20]);
        Turno::create(['nombre' => 'HORARIO MIXTO ESTRUCTURA','numero_horas_turno'=> '8 HRS', 'identificador' => 21]);
    }
}
