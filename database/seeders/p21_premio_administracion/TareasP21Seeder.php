<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;

class TareasP21Seeder extends Seeder
{
    public function run()
    {
        // Tareas para Premio Administracion
        $tarea = Tarea::create([
            'nombre' =>  'INICIO DE CONVOCATORIA',
            'identificador' =>  'TPA01',
            'descripcion' => 'Lanzar la convocatoria correspondiente al premio de administración del año en curso.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.inicio.convocatoria'
        ]);
        $tarea->attachRoles(["ADMN_PA_21"]);

        $tarea = Tarea::create([
            'nombre' =>  'ELIMINACIÓN DE SOLICITUDES',
            'identificador' =>  'TPA02',
            'descripcion' => 'Generar el listado de candidatos para imprimir con los nombres de los solicitantes del premio pertenecientes a su unidad
            administratva.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.eliminacion.solicitudes'
        ]);
        $tarea->attachRoles(["AUTZ_PA_21"]);

        $tarea = Tarea::create([
            'nombre' =>  'ASIGNACIÓN DE PREMIOS',
            'identificador' =>  'TPA03',
            'descripcion' => 'Optmizar la asignación de premios realizada por el comité de evaluación.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.asignacion.premios'
        ]);
        $tarea->attachRoles(["ADMN_PA_21"]);

        $tarea = Tarea::create([
            'nombre' =>  'RECEPCIÓN DE INCONFORMIDADES',
            'identificador' =>  'TPA04',
            'descripcion' => 'Recabar inconformidades o declinaciones dentro de las fechas establecidas para está etapa.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.recepcion.inconformidades'
        ]);
        $tarea->attachRoles(["AUTZ_PA_21"]);

        // Notificaciones del Premio de Administración
        $tarea = Tarea::create([
            'nombre' => 'INICIO DE PROCESO',
            'identificador' => 'TNOTA01',
            'descripcion' => 'Notificación de inicio de proceso',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.notificacion.inicio.proceso'
        ]);
        $tarea->attachRoles(["OPER_PA_21"]);

        $tarea = Tarea::create([
            'nombre' => 'LISTADO FINAL DE LOS GANADORES',
            'identificador' => 'TNOTA02',
            'descripcion' => 'Listado final de los ganadores',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'premio.administracion.notificacion.listado.ganadores'
        ]);
        $tarea->attachRoles(["OPER_PA_21", "AUTZ_PA_21"]);
    }
}
