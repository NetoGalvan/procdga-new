<?php

namespace Database\Seeders\p06_servicio_social;

use Illuminate\Database\Seeder;
use App\Models\Reporte;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ReportesP06Seeder extends Seeder
{

    public function run()
    {
        // Reporte 1    // Para el rol SUB_EA y PROG_SS
        $datosPersonalesPrestador = Reporte::create([
            'nombre' => 'DATOS PERSONALES DEL PRESTADOR',
            'identificador' => 'datos_personales_prestador',
            'descripcion' => 'Generar reporte con los datos de los prestadores de servicio social o prácticas profesionales.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reporte.datos.personales.prestador'
        ]);
        $datosPersonalesPrestador->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id]);

        // Reporte 2    // Para el rol SUB_EA y PROG_SS
        $reportePrestadoresUnidadAdmin = Reporte::create([
            'nombre' => 'PRESTADORES POR UNIDAD ADMINISTRATIVA',
            'identificador' => 'reporte_prestadores_unidad_administrativa',
            'descripcion' => 'Reporte ejecutivo de prestadores de servicio social o prácticas profesionales por unidad administrativa.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reporte.prestadores.por.unidad.administrativa'
        ]);
        $reportePrestadoresUnidadAdmin->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id]);

        // Reporte 3    // Para el rol SUB_EA y PROG_SS
        $reporteNominaServicioSocial = Reporte::create([
            'nombre' => 'NÓMINA DE SERVICIO SOCIAL',
            'identificador' => 'reporte_nomina_servicio_social',
            'descripcion' => 'Reporte ejecutivo de nómina de servicio social',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reporte.nomina.servicio.social'
        ]);
        $reporteNominaServicioSocial->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id]);

        // Reporte 4    // Para el rol SUB_EA y PROG_SS
        $reporteNominaPrestadoresServicioSocial = Reporte::create([
            'nombre' => 'NÓMINA PARA PRESTADORES DE SERVICIO SOCIAL',
            'identificador' => 'reporte_nomina_prestadores_servicio_social',
            'descripcion' => 'Nómina para prestadores de servicio social',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reporte.nomina.prestadores.servicio.social.excel'
        ]);
        $reporteNominaPrestadoresServicioSocial->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id, Role::select('id')->where('name', 'SUB_EA')->first()->id]);

        // Reporte 5    // Para el rol PROG_SS
        $reporteEscuelasProgramas = Reporte::create([
            'nombre' => 'REPORTE DE INSTITUCIONES, ESCUELAS Y PROGRAMAS',
            'identificador' => 'reporte_instituciones_escuelas_y_programas',
            'descripcion' => 'Reporte ejecutivo de todas las instituciones, escuelas y programas registrados.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reporte.instituciones.escuelas.programas'
        ]);
        $reporteEscuelasProgramas->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id]);

        // // Reporte 6    // Para el rol PROG_SS
        $reimpresionCartaInicioTermino = Reporte::create([
            'nombre' => 'REIMPRESIÓN DE CARTAS DE SERVICIO SOCIAL',
            'identificador' => 'reimpresion_cartas_servicio',
            'descripcion' => 'Reimpresión de carta de aceptación y carta de termino para servicio social o prácticas profesionales.',
            'proceso_id' => Proceso::where('identificador', 'servicio_social')->first()->proceso_id,
            'ruta' => 'reimpresion.cartas'
        ]);
        $reimpresionCartaInicioTermino->syncRoles([Role::select('id')->where('name', 'PROG_SS')->first()->id]);

    }
}
