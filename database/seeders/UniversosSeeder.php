<?php

namespace Database\Seeders;

use App\Models\Universo;
use Illuminate\Database\Seeder;

class UniversosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Universo::create(['nombre'=>'EXCLUSIVO PARA PRESUPUESTO', 'identificador' => '0']);
        Universo::create(['nombre'=>'APOYO A SERVIDORES', 'identificador' => 'A']);
        Universo::create(['nombre'=>'BECARIOS', 'identificador' => 'B']);
        Universo::create(['nombre'=>"JUZGADOS CIVICOS - CONFIANZA", 'identificador' => 'C']);
        Universo::create(['nombre'=>"JUZGADOS CIVICOS - BASE", 'identificador' => 'C1']);
        Universo::create(['nombre'=>'ASISTENTES ADMINISTRATIVOS PGJDF', 'identificador' => 'D']);
        Universo::create(['nombre'=>'EVENTUALES ORDINARIOS', 'identificador' => 'E']);
        Universo::create(['nombre'=>'FILARMONICA', 'identificador' => 'F']);
        Universo::create(['nombre'=>'GALENOS', 'identificador' => 'G']);
        Universo::create(['nombre'=>'HONORARIOS', 'identificador' => 'H']);
        Universo::create(['nombre'=>'JUSTICIA', 'identificador' => 'J']);
        Universo::create(['nombre'=>'PERSONAL DE ENLACE', 'identificador' => 'K']);
        Universo::create(['nombre'=>'LIDER DE PROYECTO', 'identificador' => 'L']);
        Universo::create(['nombre'=>'MANDOS MEDIOS', 'identificador' => 'M']);
        Universo::create(['nombre'=>'TECNICO OPERATIVO', 'identificador' => 'O']);
        Universo::create(['nombre'=>'PLANTA ASFALTO', 'identificador' => 'P']);
        Universo::create(['nombre'=>'DEFENSORIA DE OFICIO - CONFIANZA', 'identificador' => 'Q']);
        Universo::create(['nombre'=>'DEFENSORIA DE OFICIO - BASE', 'identificador' => 'Q1']);
        Universo::create(['nombre'=>'RESIDENTES', 'identificador' => 'R']);
        Universo::create(['nombre'=>'SERVIDORES PUBLICOS', 'identificador' => 'S']);
        Universo::create(['nombre'=>'UNIVERSO T', 'identificador' => 'T']);
        Universo::create(['nombre'=>'V', 'identificador' => 'V']);
        Universo::create(['nombre'=>'HOMOLOGOS A MANDOS MEDIOS', 'identificador' => 'W']);
        Universo::create(['nombre'=>'EVENTUALES EXTRAORDINARIOS', 'identificador' => 'X']);
        Universo::create(['nombre'=>'HOMOLOGOS A SERVIDORES PUBLICOS SUPERIORES', 'identificador' => 'Z']);
        Universo::create(['nombre'=>'SIN DEFINIR', 'identificador' => 'PR']);
    }
}
