<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use App\Models\Proceso;
use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareasP16Seeder extends Seeder
{
    public function run()
    {
        // PROCESO
        $tarea = Tarea::create([
            'nombre' => 'ASIGNAR PRESUPUESTO A ÁREAS',
            'identificador' => 'ASIGNAR_PRESUPUESTO_A_AREAS',
            'descripcion' => 'ASIGNACIÓN DEL PRESUPUESTO DISPONIBLE PARA TIEMPO EXTRAORDINARIO Ó EXCEDENTE POR ÁREA.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.presupuesto.por.area'
        ]);
        $tarea->attachRoles(["ADMIN_TIEMPO_EXTRA"]);

        $tarea = Tarea::create([
            'nombre' => 'REVISIÓN Y AUTORIZACIÓN DE HORAS POR ÁREAS',
            'identificador' => 'REVISIÓN_Y_AUTORIZACIÓN_DE_HORAS_POR_AREAS',
            'descripcion' => 'REVISION Y AUTORIZACIÓN DE LAS HORAS ASIGNADAS A LOS EMPLEADOS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tiempo_extraordinario_excedente')->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.revision.por.empleado'
        ]);
        $tarea->attachRoles(["ADMIN_TIEMPO_EXTRA"]);

        // SUB PROCESO
        $tarea = Tarea::create([
            'nombre' => 'ASIGNAR PRESUPUESTO A SUB ÁREAS',
            'identificador' => 'ASIGNAR_PRESUPUESTO_A_SUB_AREAS',
            'descripcion' => 'ASIGNAR PRESUPUESTO A SUB ÁREAS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_tiempo_extraordinario_excedente")->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.asignacion.presupuesto.areas'
        ]);
        $tarea->attachRoles(["ENLACE_TIEMPO_EXTRA"]);

        $tarea = Tarea::create([
            'nombre' => 'REVISIÓN Y AUTORIZACIÓN DE HORAS POR SUB ÁREAS',
            'identificador' => 'REVISIÓN_Y_AUTORIZACIÓN_DE_HORAS_POR_SUB_ÁREAS',
            'descripcion' => 'REVISION Y AUTORIZACIÓN DE LAS HORAS ASIGNADAS A LOS EMPLEADOS POR SUB ÁREAS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_tiempo_extraordinario_excedente")->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.revision.sub.areas'
        ]);
        $tarea->attachRoles(["ENLACE_TIEMPO_EXTRA"]);

        // SUB PROCESO SUB TAREA
        $tarea = Tarea::create([
            'nombre' => 'ASIGNACIÓN DE HORAS',
            'identificador' => 'ASIGNACIÓN_DE_HORAS',
            'descripcion' => 'ASIGNACIÓN DE HORAS EXTRAS O EXCEDENTES POR EMPLEADO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_tiempo_extraordinario_excedente")->first()->proceso_id,
            'ruta' => 'tiempo.extraordinario.excedente.horas.por.empleado'
        ]);
        $tarea->attachRoles(["OPER_TIEMPO_EXTRA"]);

    }
}
