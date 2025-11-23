<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Proceso;

class TareasP32Seeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'SOLICITUD DE TRÁMITE',
            'identificador' => 'SOLICITUD_DE_TRAMITE',
            'descripcion' => 'Iniciar Proceso Solicitud de Trámite',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramites.kardex.solicitud.tramites'
        ]);
        $tarea->attachRoles(["CAPTURA_KARDEX"]);

        $tarea = Tarea::create([
            'nombre' => 'ASIGNACIÓN DE TRÁMITE',
            'identificador' => 'ASIGNACION_DE_TRAMITE',
            'descripcion' => 'Asigna el tramite al usuario correspondiente',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramites.kardex.asigancion.tramites'
        ]);
        $tarea->attachRoles(["ADMIN_KARDEX"]);

        $tarea = Tarea::create([
            'nombre' => 'GENERACIÓN DE DOCUMENTO HOJAS DE SERVICIO',
            'identificador' => 'GENERACION_DE_DOCUMENTO_HOJAS_SERVICIO',
            'descripcion' => 'Captura y generación de datos necesarios para la generación de Hojas de Servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramites.kardex.generacion.documento.hojas.servicio'
        ]);
        $tarea->attachRoles(["TECNICO_OPERATIVO_KARDEX"]);

        $tarea = Tarea::create([
            'nombre' => 'GENERACIÓN DE DOCUMENTO COMPROBANTES DE SERVICIO',
            'identificador' => 'GENERACION_DE_DOCUMENTO_COMPROBANTES_SERVICIO',
            'descripcion' => 'Captura y generación de datos necesarios para la generación de Comprobantes de Servicio',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramites.kardex.generacion.documento.comprobantes.servicio'
        ]);
        $tarea->attachRoles(["TECNICO_OPERATIVO_KARDEX"]);

        $tarea = Tarea::create([
            'nombre' => 'DESCARGAR DOCUMENTO',
            'identificador' => 'DESCARGAR_DOCUMENTO',
            'descripcion' => 'Descargar y obtener el documento correspondiente al tramite correspondiente',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'tramites_kardex')->first()->proceso_id,
            'ruta' => 'tramites.kardex.descargar.documento'
        ]);
        $tarea->attachRoles(["ADMIN_KARDEX"]);
    }
}
