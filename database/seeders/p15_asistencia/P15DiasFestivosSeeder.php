<?php

namespace Database\Seeders\p15_asistencia;

use App\Models\p15_asistencia\DiaFestivo;
use App\Models\p15_asistencia\DiaFestivoFecha;
use Illuminate\Database\Seeder;

class P15DiasFestivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiaFestivo::create([
            "nombre" => "AÑO NUEVO"
        ]);
        DiaFestivo::create([
            "nombre" => "DÍA DE LA CONSTITUCIÓN MEXICANA"
        ]);
        DiaFestivo::create([
            "nombre" => "NATALICIO DE BENITO JUÁREZ"
        ]);
        DiaFestivo::create([
            "nombre" => "DÍA DEL TRABAJO"
        ]);
        DiaFestivo::create([
            "nombre" => "DÍA DE LA INDEPENDENCIA DE MÉXICO"
        ]);
        DiaFestivo::create([
            "nombre" => "ANIVERSARIO DE LA REVOLUCIÓN MEXICANA"
        ]);
        DiaFestivo::create([
            "nombre" => "NAVIDAD"
        ]);

        DiaFestivoFecha::create([
            "fecha" => "2023-05-01",
            "descripcion" => "DÍA DEL TRABAJO" 
        ]);
    }
}
