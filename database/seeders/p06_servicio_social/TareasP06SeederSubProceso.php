<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use App\Models\Proceso;


class TareasP06SeederSubProceso extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' =>  'SELECCIÓN DE TIPO DE NÓMINA',
            'identificador' =>  'SUBT01',
            'descripcion' => 'Inicio de proceso',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social_nomina')->first()->proceso_id,
            'ruta' => 'servicio.social.sub.seleccion.tipo.nomina'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' =>  'VALIDACIÓN DE NÓMINA',
            'identificador' =>  'SUBT02',
            'descripcion' => 'Validar la nómina de los prestadores',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social_nomina')->first()->proceso_id,
            'ruta' => 'servicio.social.sub.validacion.nomina'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'CIERRE DE NÓMINA',
            'identificador' =>  'SUBT03',
            'descripcion' => 'Cierre de nómina de los prestadores',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social_nomina')->first()->proceso_id,
            'ruta' => 'servicio.social.sub.cierre.nomina'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' =>  'GENERACIÓN DE NÓMINA XLS',
            'identificador' =>  'SUBT04',
            'descripcion' => 'Generación de archivo xml con el listado de los prestadores aceptados a beca',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social_nomina')->first()->proceso_id,
            'ruta' => 'servicio.social.sub.generacion.xls'
        ]);
        $tarea->attachRoles(["PROG_SS"]);
    }
}
