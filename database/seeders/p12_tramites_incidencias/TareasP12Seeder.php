<?php

namespace Database\Seeders\p12_tramites_incidencias;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use App\Models\Proceso;

class TareasP12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // INCIDENCIA INDIVIDUAL
        $tarea = Tarea::create([
            'nombre' => 'SELECCIONAR TIPO DE CAPTURA',
            'identificador' => "T01_SELECCIONAR_TIPO_CAPTURA",
            'descripcion' => "SELECCIONAR TIPO DE CAPTURA",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.seleccionar.tipo.captura'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST", "CAPT_KDX"]);
        
        $tarea = Tarea::create([
            'nombre' => "ALTA DE INCIDENCIA",
            'identificador' => 'T02_ALTA_INCIDENCIA',
            'descripcion' => 'ALTA DE INCIDENCIA',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.alta.incidencia'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST", "CAPT_KDX"]);

        $tarea = Tarea::create([
            'nombre' => "CANCELACIÓN DE INCIDENCIA",
            'identificador' => 'T02_CANCELACION_INCIDENCIA',
            'descripcion' => 'CANCELACIÓN DE INCIDENCIA',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.cancelacion.incidencia'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST", "CAPT_KDX"]); 
        
        $tarea = Tarea::create([
            'nombre' => "APLICACIÓN DE NOTAS BUENAS",
            'identificador' => 'T02_APLICACION_NOTAS_BUENAS',
            'descripcion' => 'SELECCIONAR FECHAS Y NOTAS BUENAS PARA JUSTIFICACIÓN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.aplicacion.notas.buenas'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST", "CAPT_KDX"]); 
    
        $tarea = Tarea::create([
            'nombre' => 'FORMATO DE SOLICITUD',
            'identificador' => 'T03_FORMATO_SOLICITUD',
            'descripcion' => 'IMPRIMIR FORMATO DE SOLICITUD',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.formato.solicitud'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST"]);
        
        $tarea = Tarea::create([
            'nombre' => 'APROBAR SOLICITUD',
            'identificador' => 'T04',
            'descripcion' => 'APROBAR SOLICITUD',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.aprobar.solicitud'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

        $tarea = Tarea::create([
            'nombre' => 'AUTORIZAR SOLICITUD',
            'identificador' => 'T05',
            'descripcion' => 'AUTORIZAR SOLICITUD',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.autorizar.solicitud'
        ]);
        $tarea->attachRoles(["CTRL_KDX"]);

        $tarea = Tarea::create([
            'nombre' => 'RESPUESTA A SOLICITUD',
            'identificador' => 'N01_RESPUESTA_SOLICITUD',
            'descripcion' => 'RESPUESTA A SOLICITUD',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.respuesta.solicitud'
        ]);
        $tarea->attachRoles(["EMPLEADO_GRAL", "INI_JUST", "CAPT_KDX"]);
        
        // INCIDENCIA GRUPAL
        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - TIPO DE CAPTURA',
            'identificador' => "T01_GRUPAL_TIPO_CAPTURA",
            'descripcion' => "INCIDENCIA GRUPAL - TIPO DE CAPTURA",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.tipo.captura'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        
        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - ALTA',
            'identificador' => "T02_GRUPAL_ALTA",
            'descripcion' => "INCIDENCIA GRUPAL - ALTA",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.alta'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
       
        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - CANCELACION - SELECCIÓN DE INCIDENCIA',
            'identificador' => "T02_GRUPAL_CANCELACION_INCIDENCIA",
            'descripcion' => "INCIDENCIA GRUPAL - CANCELACION - SELECCIÓN DE INCIDENCIA",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.cancelacion.incidencia'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);

        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - CANCELACION - SELECCIÓN DE EMPLEADOS',
            'identificador' => "T03_GRUPAL_CANCELACION_EMPLEADOS",
            'descripcion' => "INCIDENCIA GRUPAL - CANCELACION - SELECCIÓN DE EMPLEADOS",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.cancelacion.empleados'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        
        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - AUTORIZAR',
            'identificador' => "T04_GRUPAL_AUTORIZAR",
            'descripcion' => "INCIDENCIA GRUPAL - AUTORIZAR",
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.autorizar'
        ]);
        $tarea->attachRoles(["CTRL_KDX"]);
                
        $tarea = Tarea::create([
            'nombre' => 'INCIDENCIA GRUPAL - RESPUESTA A SOLICITUD',
            'identificador' => 'N01_INCIDENCIA_GRUPAL_RESPUESTA',
            'descripcion' => 'INCIDENCIA GRUPAL - RESPUESTA A SOLICITUD',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'tramites_incidencias')->first()->proceso_id,
            'ruta' => 'tramite.incidencia.grupal.respuesta'
        ]);
        $tarea->attachRoles(["CAPT_KDX"]);
        
    }
}
