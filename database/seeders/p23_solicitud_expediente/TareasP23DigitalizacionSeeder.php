<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class TareasP23DigitalizacionSeeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' =>  'BUSQUEDA DE EXPEDIENTE',
            'identificador' =>  'TDIG01',
            'descripcion' => 'Buscar los datos del expediente en fichero.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'digitalizacion.archivos.buscar.datos.expediente'
        ]);
        $tarea->attachRoles(["OPER_DIG_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'CREACIÓN DE EXPEDIENTE',
            'identificador' =>  'TDIG02',
            'descripcion' => 'Crear la ficha del expediente a digitalizar asi ingresar los datos del empleado correspondientes al expediente a digitalizar.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'digitalizacion.archivos.creacion.expediente'
        ]);
        $tarea->attachRoles(["OPER_DIG_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'ACTUALIZACIÓN DE EXPEDIENTE',
            'identificador' =>  'TDIG03',
            'descripcion' => 'Corregir datos personas de la ficha del empleado, digitalizar y cargar un nuevo expediente digital',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'digitalizacion.archivos.actualizacion.expediente'
        ]);
        $tarea->attachRoles(["OPER_DIG_23"]);
    }
}
