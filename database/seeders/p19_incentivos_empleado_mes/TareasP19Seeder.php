<?php

namespace Database\Seeders\p19_incentivos_empleado_mes;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class TareasP19Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TAREAS
        $tarea = Tarea::create([
            'nombre' => 'SELECCIÓN DE QUINCENA DE PAGO',
            'identificador' => 'SELECCIONAR_QUINCENA_PAGO',
            'descripcion' => 'Seleccionar de quincena de pago',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.seleccion.quincena.pago'
        ]);
        $tarea->attachRoles(["ADMN_INC_19"]);

        $tarea = Tarea::create([
            'nombre' => 'ASIGNACIÓN DE PREMIOS POR ÁREA',
            'identificador' => 'ASIGNAR_PREMIOS_POR_AREA',
            'descripcion' => 'Asignar los premios por unidad administrativa',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.asignacion.premios.por.unidad'
        ]);
        $tarea->attachRoles(["ADMN_INC_19"]);

        $tarea = Tarea::create([
            'nombre' => 'REVISIÓN DE SOLICITUDES DE PREMIO',
            'identificador' => 'REVISAR_SOLICITUDES_PREMIO',
            'descripcion' => 'Revisar las solicitudes de premio por unidad',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.revision.solicitudes.premio'
        ]);
        $tarea->attachRoles(["ADMN_INC_19"]);

        $tarea = Tarea::create([
            'nombre' => 'GENERACIÓN DE ARCHIVOS DE PAGO',
            'identificador' => 'GENERAR_ARCHIVOS_PAGO',
            'descripcion' => 'Generar los archivos de pago',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.generar.archivos.pago'
        ]);
        $tarea->attachRoles(["ADMN_INC_19"]);

        // TAREAS SUBPROCESO
        $tarea = Tarea::create([
            'nombre' =>  'DISTRIBUCIÓN DE PREMIOS POR ÁREAS',
            'identificador' =>  'DISTRIBUIR_PREMIOS_POR_SUBAREA',
            'descripcion' => 'Subproceso, distribución de premios por sub áreas',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'subproceso_incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.subproceso.distribucion.premios.subarea'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'ASIGNACIÓN DE PREMIOS POR EMPLEADO',
            'identificador' =>  'ASIGNAR_PREMIOS_POR_EMPLEADO',
            'descripcion' => 'Subproceso, asignación de premios por empleado',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'subproceso_incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.subproceso.asignacion.premios.empleado'
        ]);
        $tarea->attachRoles(["OPER_INC_19"]);

        $tarea = Tarea::create([
            'nombre' =>  'AUTORIZACIÓN DE SOLICITUDES',
            'identificador' =>  'AUTORIZAR_SOLICITUDES',
            'descripcion' => 'Subproceso, autorización de solicitudes',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'subproceso_incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.subproceso.autorizacion.solicitudes'
        ]);
        $tarea->attachRoles(["SUB_EA"]);


        // NOTIFICACIONES
        $tarea = Tarea::create([
            'nombre' => 'NOTIFICACIÓN DEL LISTADO DE SOLICITANTES DEL PREMIO DE INCENTIVO',
            'identificador' => 'NOTIFICACION_LISTADO_SOLICITANTES_PREMIO_INCENTIVO_SUB_EA',
            'descripcion' => 'Notificación del listado de solicitantes del premio de incentivo',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.notificacion.listado.solicitantes.premio.incentivo.subea'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'NOTIFICACIÓN DEL LISTADO DE SOLICITANTES DEL PREMIO DE INCENTIVO',
            'identificador' => 'NOTIFICACION_LISTADO_SOLICITANTES_PREMIO_INCENTIVO_OPER_INC_19',
            'descripcion' => 'Notificación del listado de solicitantes del premio de incentivo',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'incentivo_empleado_mes')->first()->proceso_id,
            'ruta' => 'incentivos.empleado.mes.notificacion.listado.solicitantes.premio.incentivo.operinc19'
        ]);
        $tarea->attachRoles(["OPER_INC_19"]);

    }
}
