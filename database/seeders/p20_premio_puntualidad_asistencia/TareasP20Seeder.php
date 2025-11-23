<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class TareasP20Seeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'DEFINIR LOS PARAMETROS CONVOCATORIA',
            'identificador' => 'DEFINIR_PARAMETROS_CONVOCATORIA',
            'descripcion' => 'Establecer la quincena de pago del premio de puntualidad y asistencia y seleccionar las unidades administrativas a incluir para la ejecución de este proceso',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "premio_puntualidad_asistencia")->first()->proceso_id,
            'ruta' => 'seleccion.quincena.unidades.administrativas'
        ]);
        $tarea->attachRoles(["ADMIN_PREMIO_PUNTUALIDAD"]);

        $tarea = Tarea::create([
            'nombre' =>  'RECEPCIÓN Y REVISIÓN DE SOLICITUDES',
            'identificador' =>  'RECEPCION_REVISION_SOLICITUDES',
            'descripcion' => 'Mostrar el listado de las unidades administrativas incluídas en el proceso para el pago de premio de puntualidad y asistencia y el estado de avance que tiene cada una de ellas.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'concentrado.revision.solicitudes'
        ]);
        $tarea->attachRoles(["ADMIN_PREMIO_PUNTUALIDAD"]);

        $tarea = Tarea::create([
            'nombre' =>  'GENERACIÓN DE ARCHIVOS PARA EL TRÁMITE',
            'identificador' =>  'GENERACION_ARCHIVOS_TRAMITE',
            'descripcion' => 'Generar y descargar los archivos para el pago al trabajador.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'generacion.archivos.pago'
        ]);
        $tarea->attachRoles(["ADMIN_PREMIO_PUNTUALIDAD"]);

        // Notificaciones
        $tarea = Tarea::create([
            'nombre' => 'LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'TNOTAPPA01',
            'descripcion' => 'listado de solicitantes',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'notificacion.listado.solicitantes'
        ]);
        $tarea->attachRoles(["ENLACE_PREMIO_PUNTUALIDAD"]);

        $tarea = Tarea::create([
            'nombre' => 'LISTADO DE SOLICITANTES PARA EL PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'TNOTAPPA02',
            'descripcion' => 'listado de solicitantes',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'notificacion.listado.solicitantes'
        ]);
        $tarea->attachRoles(["OPER_PREMIO_PUNTUALIDAD"]);

    }
}
