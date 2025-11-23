<?php

namespace Database\Seeders\p06_servicio_social;

use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class TareasP06Seeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'INICIO DE PROCESO',
            'identificador' => 'T01',
            'descripcion' => 'Seleccionar un prestador de Servico Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.seleccionar.prestador'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'ASIGNAR DATOS DE ENTREVISTA',
            'identificador' =>  'T02',
            'descripcion' => 'Asignar fecha, hora y lugar de entrevista',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.asignar.datos.entrevista'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'CAPTURA RESULTADO DE ENTREVISTA',
            'identificador' =>  'T03',
            'descripcion' => 'Captura de resultado de entrevista al prestador de Servicio Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.captura.resultado.entrevista'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'ASIGNACIÓN DE FUNCIONES',
            'identificador' =>  'T04',
            'descripcion' => 'Asignación de funciones, fechas y horarios del prestador de Servicio Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.asignacion.labores'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'IMPRESIÓN DE CARTA DE INICIO',
            'identificador' =>  'T05',
            'descripcion' => 'Impresión de carta de inicio del Servicio Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.impresion.carta.inicio'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' =>  'REGISTRAR EVENTOS',
            'identificador' =>  'T06',
            'descripcion' => 'Registrar eventos durante la prestación del Servicio Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.registrar.eventos'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' =>  'IMPRESIÓN DE CARTA DE FIN',
            'identificador' =>  'T07',
            'descripcion' => 'Impresión de carta de finalización del Servicio Social',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.impresion.carta.fin'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' =>  'VALIDAR LIBERACIÓN O BAJA DEL CANDIDATO',
            'identificador' =>  'T08',
            'descripcion' => 'Validar si el servicio del prestador ya se puede liberar o en su defecto dar de baja',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.validar.liberacion.o.baja.prestador'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        // Notificaciones
        $tarea = Tarea::create([
            'nombre' => 'CITA DEL CANDIDATO PARA EXAMEN PSICOMÉTRICO',
            'identificador' => 'TANOTA01',
            'descripcion' => 'Notificación de cita del candidato',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.cita.examen.candidato'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'CARTA DE ACEPTACIÓN',
            'identificador' => 'TANOTA02',
            'descripcion' => 'Notificación de carta de aceptación',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.carta.aceptacion'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'CARTA DE TERMINO',
            'identificador' => 'TANOTA03',
            'descripcion' => 'Notificación de carta de termino',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.carta.termino'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'BAJA DE CANDIDATO',
            'identificador' => 'TANOTA04',
            'descripcion' => 'Notificación de que se dio de baja al candidato',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.baja.candidato'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' => 'NUEVO SEGUIMIENTO AGREGADO',
            'identificador' => 'TANOTA05',
            'descripcion' => 'Notificación de que se agrego un nuevo seguimiento',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.nuevo.segumiento'
        ]);
        $tarea->attachRoles(["PROG_SS"]);

        $tarea = Tarea::create([
            'nombre' => 'TIEMPO RESTANTE PARA CARTA DE INICIO',
            'identificador' => 'TANOTA06',
            'descripcion' => 'Notificación de que se aproxima la fecha para creación de carta de inicio',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'servicio.social.notificacion.monitoreo.carta.inicio'
        ]);
        $tarea->attachRoles(["SUB_EA"]);
    }
}
