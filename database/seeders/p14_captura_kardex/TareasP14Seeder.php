<?php

namespace Database\Seeders\p14_captura_kardex;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Proceso;

class TareasP14Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'Historial Kardex - Inicio de proceso',
            'identificador' => 'T01',
            'descripcion' => 'Iniciar Proceso Captura de Historial',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'historial')->first()->proceso_id,
            'ruta' => 'historial.kardex.t01'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        $tarea = Tarea::create([
            'nombre' => 'Historial Kardex - Búsqueda de Historial',
            'identificador' => 'T02',
            'descripcion' => 'Búsqueda de Historial Kardex',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'historial')->first()->proceso_id,
            'ruta' => 'historial.kardex.t02'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        //dependiendo de si es creación de uno nuevo o edición de alguno existente, se toma un camino distinto en esta tarea tres
        $tarea = Tarea::create([
            'nombre' => 'Historial Kardex - Creación de Historial',
            'identificador' => 'T03A',
            'descripcion' => 'Creación de un Historial Kardex.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'historial')->first()->proceso_id,
            'ruta' => 'historial.kardex.creacion'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        $tarea = Tarea::create([
            'nombre' => 'Historial Kardex - Edición de Historial',
            'identificador' => 'T03B',
            'descripcion' => 'Edición de un Historial Kardex existente.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'historial')->first()->proceso_id,
            'ruta' => 'historial.kardex.edicion'
        ]);
        $tarea->attachRoles(["QA_KDX"]);
        //notificacion final para cuando se edita un historial
        $tarea = Tarea::create([
            'nombre' => 'Historial Kardex - Notificación de Historial',
            'identificador' => 'T04B',
            'descripcion' => 'Notificación de edición de Historial Kardex.',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'historial')->first()->proceso_id,
            'ruta' => 'historial.kardex.notificacion'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
    }
}
