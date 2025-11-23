<?php

namespace Database\Seeders\p02_tramites_issste;

use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class TareasP02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' =>  'REVISIÓN DE FOLIOS',
            'identificador' =>  'T01',
            'descripcion' => 'REVISIÓN DE FOLIOS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'tramites.issste.revision.folios'
        ]);
        $tarea->attachRoles(["JUD_PRES"]);

        $tarea = Tarea::create([
            'nombre' =>  'RESPUESTA DEL ISSSTE',
            'identificador' =>  'T02',
            'descripcion' => 'ESPERAR LA RESPUESTA DEL ISSSTE PARA SABER SI FUE ACEPTADO O RECHAZADO UN MOVIMIENTO.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'tramites.issste.respuesta.issste'
        ]);
        $tarea->attachRoles(["JUD_PRES"]);

        $tarea = Tarea::create([
            'nombre' =>  'CORRECCIÓN DE FOLIOS RECHAZADOS POR EL ISSSTE',
            'identificador' =>  'TR03',
            'descripcion' => 'CORREGIR LOS FOLIOS RECHAZADOS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_issste')->first()->proceso_id,
            'ruta' => 'tramites.issste.corregir.folios'
        ]);
        $tarea->attachRoles(["JUD_PRES"]);
    }
}
