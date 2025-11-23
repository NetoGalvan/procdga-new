<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\p01_movimientos_personal\NivelEstudio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesEstudiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NivelEstudio::create(['nombre' => 'PRIMARIA', 'identificador' => "primaria"]);
        NivelEstudio::create(['nombre' => 'SECUNDARIA', 'identificador' => "secundaria"]);
        NivelEstudio::create(['nombre' => 'PREPARATORIA', 'identificador' => "preparatoria"]);
        NivelEstudio::create(['nombre' => 'CARRERA TECNICA', 'identificador' => "carrera_tecnica"]);
        NivelEstudio::create(['nombre' => 'LICENCIATURA', 'identificador' => "licenciatura"]);
        NivelEstudio::create(['nombre' => 'ESPECIALIDAD', 'identificador' => "especialidad"]);
        NivelEstudio::create(['nombre' => 'MAESTRIA', 'identificador' => "maestria"]);
        NivelEstudio::create(['nombre' => 'DOCTORADO', 'identificador' => "doctorado"]);
    }
}
