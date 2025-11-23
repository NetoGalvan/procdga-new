<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class TareasP23SolicitudSeeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' =>  'SOLICITUD Y SELECCIÓN DE TIPO DE PRÉSTAMO',
            'identificador' =>  'TSOL01',
            'descripcion' => 'Establecer los datos de la solicitud: tipo de solicitud, descripción de los documentos requeridos y datos del solicitante.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.solicitud.prestamo.expediente'
        ]);
        $tarea->attachRoles(["INI_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'AUTORIZACIÓN DE LA SOLICITUD',
            'identificador' =>  'TSOL02',
            'descripcion' => 'Revisar los datos de la solicitud',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.autorizacion.solicitud'
        ]);
        $tarea->attachRoles(["CTRL_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'PREPARACIÓN DE EXPEDIENTE',
            'identificador' =>  'TSOL03',
            'descripcion' => 'Verificar la existencia del expediente',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.preparacion.expediente'
        ]);
        $tarea->attachRoles(["OPER_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'CARGA DE EXPEDIENTE DIGITAL PREPARADO',
            'identificador' =>  'TSOL04',
            'descripcion' => 'Descargar, revisar y preparar el expediente digitalizado de acuerdo a los requerimientos de la solicitud.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.carga.expediente.digital'
        ]);
        $tarea->attachRoles(["OPER_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'DESCARGA DE EXPEDIENTE DIGITAL',
            'identificador' =>  'TSOL05',
            'descripcion' => 'Descargar el expediente digital solicitado',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.descarga.expediente.digital'
        ]);
        $tarea->attachRoles(["INI_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'ENTREGA DE EXPEDIENTE',
            'identificador' =>  'TSOL06',
            'descripcion' => 'Imprimir el código de préstamo del expediente AGREGAR NOTA AL PIE DESCRIBIENDO QUE ES Y QUE ELEMENTOS TIENE',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.entrega.expediente'
        ]);
        $tarea->attachRoles(["OPER_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' =>  'DEVOLUCIÓN DE EXPEDIENTE',
            'identificador' =>  'TSOL07',
            'descripcion' => 'Dar seguimiento al estado del expediente y capturar las condiciones físicas de devolución',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.devolucion.expediente'
        ]);
        $tarea->attachRoles(["OPER_EXP_23"]);

        // Notificaciones
        $tarea = Tarea::create([
            'nombre' => 'RECHAZO DE SOLICITUD DE EXPEDIENTE',
            'identificador' => 'TNOTA01',
            'descripcion' => 'RECHAZO DE SOLICITUD DE EXPEDIENTE',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.rechazo.solicitud.expediente'
        ]);
        $tarea->attachRoles(["INI_EXP_23"]);

        $tarea = Tarea::create([
            'nombre' => 'DATOS DE LA CITA PARA ENTREGA DE EXPEDIENTE',
            'identificador' => 'TNOTA02',
            'descripcion' => 'DATOS DE LA CITA PARA ENTREGA DE EXPEDIENTE',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'solicitud.expediente.datos.cita.entrega.expediente'
        ]);
        $tarea->attachRoles(["INI_EXP_23"]);
    }
}
