<?php

namespace Database\Seeders\p15_asistencia;

use App\Models\Catalogo;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class CatalogosP15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogo = Catalogo::create([
            'nombre' => 'HORARIOS',
            'identificador' => 'catalogo_horarios',
            'descripcion' => 'Administra los horarios de los empleados.',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.catalogo.horarios'
        ]);
        $catalogo->attachRoles(["CONTROL_ASISTENCIA"]);
        
        $catalogo = Catalogo::create([
            'nombre' => 'DÍAS FESTIVOS',
            'identificador' => 'catalogo_dias_festivos',
            'descripcion' => 'Administra los días festivos del año',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.catalogo.dias.festivos'
        ]);
        $catalogo->attachRoles(["CONTROL_ASISTENCIA"]);
        
        $catalogo = Catalogo::create([
            'nombre' => 'BIOMÉTRICOS',
            'identificador' => 'catalogo_biometricos',
            'descripcion' => 'Administra los biométricos',
            'proceso_id' => Proceso::where('identificador', 'asistencia')->first()->proceso_id,
            'ruta' => 'asistencia.catalogo.biometricos'
        ]);
        $catalogo->attachRoles(["CONTROL_ASISTENCIA"]);
    }
}
