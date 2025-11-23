<?php

namespace Database\Seeders\p01_movimientos_personal;

use App\Models\Tarea;
use App\Models\Area;
use App\Models\Proceso;
use Illuminate\Database\Seeder;

class TareasP01Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // GENERAL
        $tarea = Tarea::create([
            'nombre' => 'SELECCIÓN DE TIPO DE MOVIMIENTO',
            'identificador' => 'T01',
            'descripcion' => 'SELECCIONAR TIPO DE MOVIMIENTO Y LLENAR DATOS PRINCIPALES',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.seleccionar.movimiento'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        // ALTAS
        $tarea = Tarea::create([
            'nombre' =>  'ALTA - LLENADO DE PROPUESTA',
            'identificador' => 'TA02',
            'descripcion' => 'CAPTURAR PROPUESTA',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.capturar.propuesta'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'ALTA - FECHA DE EXAMEN PSICOMÉTRICO',
            'identificador' => 'TA03',
            'descripcion' => 'CREAR CITA PARA EXAMEN PSICOMÉTRICO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.cita.psicometrico'
        ]);
        $tarea->attachRoles(["COO_EVAL"]);

        $tarea = Tarea::create([
            'nombre' => 'ALTA - CALIFICACIÓN DE EXAMEN PSICOMÉTRICO',
            'identificador' => 'TA04',
            'descripcion' => 'CALIFICAR EXAMEN PSICOMÉTRICO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.psicometrico.calificacion'
        ]);
        $tarea->attachRoles(["COO_EVAL"]);

        $tarea = Tarea::create([
            'nombre' => 'ALTA - LLENADO DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TA05',
            'descripcion' => 'LLENAR DOCUMENTO ALIMENTARIO DE ALTAS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);
        
        $tarea = Tarea::create([
            'nombre' => 'ALTA - LISTA DE DOCUMENTOS',
            'identificador' => 'TA06',
            'descripcion' => 'LISTAR DOCUMENTACIÓN QUE DEBE CONTENER EL EXPEDIENTE ACTIVO DEL PROCESO DE CONTRATACIÓN DE PERSONAL',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.lista.documentacion'

        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'ALTA - PROCESAMIENTO ANTE EL SUN',
            'identificador' => 'TA07',
            'descripcion' => 'FINALIZAR MOVIMIENTO DE PERSONAL ANTE EL SUN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.procesamiento.sun'
        ]);
        $tarea->attachRoles(["JUD_MP"]);

        $tarea = Tarea::create([
            'nombre' => 'ALTA - GENERACIÓN DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TA08',
            'descripcion' => 'IMPRIMIR DOCUMENTO ALIMENTARIO DE ALTA GENERADO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.documento.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        // BAJAS
        $tarea = Tarea::create([
            'nombre' => 'BAJA - LLENADO DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TB02',
            'descripcion' => 'LLENADO DE DOCUMENTO ALIMENTARIO DE MOVIMIENTO DE PERSONAL PARA BAJA',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.bajas.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'BAJA - PROCESAMIENTO ANTE EL SUN',
            'identificador' => 'TB03',
            'descripcion' => 'PROCESAMIENTO DE MOVIMIENTO ANTE EL SUN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.bajas.procesamiento.sun'
        ]);
        $tarea->attachRoles(["JUD_MP"]);

        $tarea = Tarea::create([
            'nombre' => 'BAJA - GENERACIÓN DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TB04',
            'descripcion' => 'GENERAR PDF DEL REPORTE DE MOVIMIENTO DE PERSONAL',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.bajas.documento.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        // REANUDACIONES
        $tarea = Tarea::create([
            'nombre' => 'REANUDACIÓN O INTERINATO - LLENADO DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TR02',
            'descripcion' => 'LLENADO DE DOCUMENTO ALIMENTARIO DE MOVIMIENTO DE PERSONAL PARA REANUDACIÓN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.reanudaciones.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'REANUDACIÓN O INTERINATO - PROCESAMIENTO ANTE EL SUN',
            'identificador' => 'TR03',
            'descripcion' => 'PROCESAMIENTO DE MOVIMIENTO ANTE EL SUN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.reanudaciones.procesamiento.sun'
        ]);
        $tarea->attachRoles(["JUD_MP"]);

        $tarea = Tarea::create([
            'nombre' => 'REANUDACIÓN O INTERINATO - GENERACIÓN DE DOCUMENTO ALIMENTARIO',
            'identificador' => 'TR04',
            'descripcion' => 'GENERACIÓN DE PDF DE DOCUMENTO ALIMENTARIO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.reanudaciones.documento.alimentario'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'DOCUMENTACIÓN',
            'identificador' => 'T09',
            'descripcion' => 'SUBIR DOCUMENTACIÓN SOLICITADA PARA EL TRÁMITE',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.subir.documentacion'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL"]);

        // NOTIFICACIONES 
        $tarea = Tarea::create([
            'nombre' => 'FECHA CITA DE EXAMEN PSICOMÉTRICO',
            'identificador' => 'TANOTA01',
            'descripcion' => 'NOTIFICA AL ENLACE ADMINISTRATIVO LA CITA PARA EL EXAMEN PSICOMÉTRICO DEL EMPLEADO',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.altas.notificacion.cita.psicometrico'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'MOVIMIENTO DE PERSONAL NO AUTORIZADO',
            'identificador' => 'TANOTA02',
            'descripcion' => 'MOVIMIENTO DE PERSONAL NO AUTORIZADO',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'movimientos_personal')->first()->proceso_id,
            'ruta' => 'movimiento.personal.notificacion.personal.no.autorizado'
        ]);
        $tarea->attachRoles(["SUB_EA"]);
    }
}
