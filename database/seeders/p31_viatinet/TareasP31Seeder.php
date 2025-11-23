<?php

namespace Database\Seeders\p31_viatinet;

use App\Models\Area;
use App\Models\Proceso;
use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareasP31Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // T01 - CREAR SOLICITUD
        $tarea = Tarea::create([
            'nombre' => 'CREAR SOLICITUD',
            'identificador' => 'T01',
            'descripcion' => 'CREAR LA SOLICITUD DEL VIÁTICO PARA LA COMISIÓN',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.solicitud.viatico'
        ]);
        $tarea->attachRoles(["ENLACE_CAPTURA_VIATICO"]);
        
        // T02 - AGREGAR COMISIONADOS
        $tarea = Tarea::create([
            'nombre' => 'AGREGAR COMISIONADOS',
            'identificador' => 'T02',
            'descripcion' => 'AGREGAR COMISIONADOS A LA SOLICITUD DEL VIÁTICO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.agregar.comisionados'
        ]);
        $tarea->attachRoles(["ENLACE_CAPTURA_VIATICO"]);
        
        // T03 -  CONSULTAR TÉRMINOS Y CONDICIONES
        $tarea = Tarea::create([
            'nombre' => 'TÉRMINOS Y CONDICIONES',
            'identificador' => 'T03',
            'descripcion' => 'CONSULTAR LOS TÉRMINOS Y CONDICIONES DE LA SOLICITUD',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.consultar.terminos'
        ]);
        $tarea->attachRoles(["ENLACE_CAPTURA_VIATICO"]);
        
        // T04 -  REVISIÓN SOLICITUD
        $tarea = Tarea::create([
            'nombre' => 'REVISIÓN DE SOLICITUD POR EL TITULAR DEL ÓRGANO',
            'identificador' => 'T04',
            'descripcion' => 'REVISIÓN DE LA SOLICITUD DEL VIÁTICO PARA LA COMISIÓN POR TITULAR DEL ÓRGANO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.revision.organo'
        ]);
        $tarea->attachRoles(["TITULAR_ORGANO"]);
      
        // T05 -  REVISIÓN SOLICITUD
        $tarea = Tarea::create([
            'nombre' => 'REVISIÓN DE SOLICITUD POR EL TITULAR DE LA SEC. DE ADMINISTRACION',
            'identificador' => 'T05',
            'descripcion' => 'REVISIÓN DE LA SOLICITUD DEL VIÁTICO PARA LA COMISIÓN POR EL TITULAR DE SECRETARÍA DE ADMINISTRACIÓN Y FINANZAS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.revision.administracion'
        ]);
        $tarea->attachRoles(["TITULAR_ADMINISTRACION"]);
        
        // T06 -  AUTORIZAR SOLICITUD
        $tarea = Tarea::create([
            'nombre' => 'AUTORIZACIÓN DEL VIÁTICO',
            'identificador' => 'T06',
            'descripcion' => 'AUTORIZACIÓN DE LA SOLICITUD DEL VIÁTICO',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.autorizacion'
        ]);
        $tarea->attachRoles(["AUTORIZADOR_VIATICO"]);
        
        // T07 - COMPROBACIÓN DE GATOS  
        $tarea = Tarea::create([
            'nombre' => 'COMPROBACIÓN DE GASTOS',
            'identificador' => 'T07',
            'descripcion' => 'COMPROBACIÓN DE GASTOS',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'viatinet')->first()->proceso_id,
            'ruta' => 'viatinet.comprobacion.gastos'
        ]);
        $tarea->attachRoles(["ENLACE_CAPTURA_VIATICO"]);
      
    }
}
