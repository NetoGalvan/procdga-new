<?php

namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use App\Models\Proceso;

class TareasP08Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // T01
        $tarea = Tarea::create([
            'nombre' => 'SELECCIÓN DE SERVICIO',
            'identificador' => 'SELECCION_DE_SERVICIO',
            'descripcion' => 'Iniciar Proceso Solicitud de Servicios',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.seleccionar.servicio'
        ]);
        $tarea->attachRoles(["JUD_RM"]);

        // T02
        $tarea = Tarea::create([
            'nombre' => 'DESGLOSE DE SERVICIO',
            'identificador' => 'DESGLOSE_DE_SERVICIO_MTTO',
            'descripcion' => 'Desglosa del proceso de solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.desglose.servicio'
        ]);
        $tarea->attachRoles(["JUD_MTTO"]);

        $tarea = Tarea::create([
            'nombre' => 'DESGLOSE DE SERVICIO',
            'identificador' => 'DESGLOSE_DE_SERVICIO_TRANSPORTE',
            'descripcion' => 'Desglosa del proceso de solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.desglose.servicio'
        ]);
        $tarea->attachRoles(["JUD_TRANSPORTE"]);

        $tarea = Tarea::create([
            'nombre' => 'DESGLOSE DE SERVICIO',
            'identificador' => 'DESGLOSE_DE_SERVICIO_IMPRESION',
            'descripcion' => 'Desglosa del proceso de solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.desglose.servicio'
        ]);
        $tarea->attachRoles(["JUD_IMPRE"]);

        $tarea = Tarea::create([
            'nombre' => 'DESGLOSE DE SERVICIO',
            'identificador' => 'DESGLOSE_DE_SERVICIO_TELEFONIA',
            'descripcion' => 'Desglosa del proceso de solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.desglose.servicio'
        ]);
        $tarea->attachRoles(["JUD_TELEFONIA"]);

        $tarea = Tarea::create([
            'nombre' => 'DESGLOSE DE SERVICIO',
            'identificador' => 'DESGLOSE_DE_SERVICIO_LIMPIEZA',
            'descripcion' => 'Desglosa del proceso de solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.desglose.servicio'
        ]);
        $tarea->attachRoles(["JUD_LIMPIEZA"]);

        // T03
        $tarea = Tarea::create([
            'nombre' => 'EJECUCIÓN DE SERVICIO',
            'identificador' => 'EJECUCION_DE_SERVICIO_MTTO',
            'descripcion' => 'Completa la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.ejecucion.servicio'
        ]);
        $tarea->attachRoles(["JUD_MTTO"]);

        $tarea = Tarea::create([
            'nombre' => 'EJECUCIÓN DE SERVICIO',
            'identificador' => 'EJECUCION_DE_SERVICIO_TRANSPORTE',
            'descripcion' => 'Completa la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.ejecucion.servicio'
        ]);
        $tarea->attachRoles(["JUD_TRANSPORTE"]);

        $tarea = Tarea::create([
            'nombre' => 'EJECUCIÓN DE SERVICIO',
            'identificador' => 'EJECUCION_DE_SERVICIO_IMPRESION',
            'descripcion' => 'Completa la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.ejecucion.servicio'
        ]);
        $tarea->attachRoles(["JUD_IMPRE"]);

        $tarea = Tarea::create([
            'nombre' => 'EJECUCIÓN DE SERVICIO',
            'identificador' => 'EJECUCION_DE_SERVICIO_TELEFONIA',
            'descripcion' => 'Completa la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.ejecucion.servicio'
        ]);
        $tarea->attachRoles(["JUD_TELEFONIA"]);

        $tarea = Tarea::create([
            'nombre' => 'EJECUCIÓN DE SERVICIO',
            'identificador' => 'EJECUCION_DE_SERVICIO_LIMPIEZA',
            'descripcion' => 'Completa la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.ejecucion.servicio'
        ]);
        $tarea->attachRoles(["JUD_LIMPIEZA"]);

        // T04
        $tarea = Tarea::create([
            'nombre' => 'CONFIRMACIÓN DE SERVICIO',
            'identificador' => 'CONFIRMACION_DE_SERVICIO',
            'descripcion' => 'Finaliza la solicitud de servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.confirmacion.servicio'
        ]);
        $tarea->attachRoles(["JUD_RM"]);


        // Notificación de NUEVA solicitud de servicio del JUD_RM a los JUDs
        $tarea = Tarea::create([
            'nombre' => 'NUEVA SOLICITUD DE SERVICIO',
            'identificador' => 'NOTIFICACION_NUEVA_SOLICITUD_SERVICIO_MTTO',
            'descripcion' => 'Notifición para el Subdirector de Conservación y Mantenimiento que hubo una solicitud de servicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.jud'
        ]);
        $tarea->attachRoles(["JUD_MTTO"]);

        $tarea = Tarea::create([
            'nombre' => 'NUEVA SOLICITUD DE SERVICIO',
            'identificador' => 'NOTIFICACION_NUEVA_SOLICITUD_SERVICIO_TRANSPORTE',
            'descripcion' => 'Notifición para el Subdirector de Conservación y Mantenimiento que hubo una solicitud de servicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.jud'
        ]);
        $tarea->attachRoles(["JUD_TRANSPORTE"]);

        $tarea = Tarea::create([
            'nombre' => 'NUEVA SOLICITUD DE SERVICIO',
            'identificador' => 'NOTIFICACION_NUEVA_SOLICITUD_SERVICIO_IMPRE',
            'descripcion' => 'Notifición para el Subdirector de Conservación y Mantenimiento que hubo una solicitud de servicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.jud'
        ]);
        $tarea->attachRoles(["JUD_IMPRE"]);

        $tarea = Tarea::create([
            'nombre' => 'NUEVA SOLICITUD DE SERVICIO',
            'identificador' => 'NOTIFICACION_NUEVA_SOLICITUD_SERVICIO_TELEFONIA',
            'descripcion' => 'Notifición para el Subdirector de Conservación y Mantenimiento que hubo una solicitud de servicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.jud'
        ]);
        $tarea->attachRoles(["JUD_TELEFONIA"]);

        $tarea = Tarea::create([
            'nombre' => 'NUEVA SOLICITUD DE SERVICIO',
            'identificador' => 'NOTIFICACION_NUEVA_SOLICITUD_SERVICIO_LIMPIEZA',
            'descripcion' => 'Notifición para el Subdirector de Conservación y Mantenimiento que hubo una solicitud de servicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.jud'
        ]);
        $tarea->attachRoles(["JUD_LIMPIEZA"]);

        // Notificación que fue RECHAZADA la solicitud de servicio de los JUDs al JUD_RM
        $tarea = Tarea::create([
            'nombre' => 'SOLICITUD DE SERVICIO RECHAZADA',
            'identificador' => 'NOTIFICACION_RECHAZADA_SOLICITUD_SERVICIO_JUD',
            'descripcion' => 'Notifición para el Jefe de Recursos Materiales indicándole que fue rechazada su solicitud de servicio por el JUD',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.rechazada.jud'
        ]);
        $tarea->attachRoles(["JUD_RM"]);


        // Notificación que fue ACEPTADA la solicitud de servicio por parte de los JUDs al JUD_RM
        $tarea = Tarea::create([
            'nombre' => 'SOLICITUD DE SERVICIO ACEPTADA - ENTREGABLES',
            'identificador' => 'NOTIFICACION_ACEPTADA_SOLICITUD_SERVICIO_JUD',
            'descripcion' => 'Notifición para el Jefe de Recursos Materiales indicándole que fue aceptada su solicitud de servicio por el JUD',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.aceptada.jud'
        ]);
        $tarea->attachRoles(["JUD_RM"]);

        // Notificación que fue COMPLETADA la solicitud de servicio por parte de los JUDs al JUD_RM
        $tarea = Tarea::create([
            'nombre' => 'SOLICITUD DE SERVICIO COMPLETADA',
            'identificador' => 'NOTIFICACION_COMPLETADA_SOLICITUD_SERVICIO_JUD',
            'descripcion' => 'Notifición para el Jefe de Recursos Materiales indicándole que fue complertada su solicitud de servicio por el JUD',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.notificacion.completada.jud'
        ]);
        $tarea->attachRoles(["JUD_RM"]);
    }
}
