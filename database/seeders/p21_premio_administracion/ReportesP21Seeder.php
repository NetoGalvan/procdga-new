<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP21Seeder extends Seeder
{
    public function run()
    {
        // Reporte 1.  Reporte Ejecutivo de Premios de administración    // Para el rol ADMN_PA_21
        $reporteEjecutivoPremioAdministracion = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DE PREMIOS DE ADMINISTRACIÓN',
            'identificador' => 'reporte_ejecutivo_premios_administración',
            'descripcion' => 'Generar reporte ejecutivo de todas las convocatorias',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.premio.administracion'
        ]);
        $reporteEjecutivoPremioAdministracion->syncRoles([ Role::select('id')->where('name', 'ADMN_PA_21')->first()->id ]);

        // Reporte 2. Listado de candidatos Premio de administración de una convocatoria    // Para el rol ADMN_PA_21, OPER_PA_21 y AUTZ_PA_21
        $reporteCandidatosPremioAdministracionConvocatoria = Reporte::create([
            'nombre' => 'LISTA DE CANDIDATOS DE UNA CONVOCATORIA',
            'identificador' => 'listado_candidatos_premio_administración_una_convocatoria',
            'descripcion' => 'Generar reporte de candidatos premio de administración de una convocatoria.',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion')->first()->proceso_id,
            'ruta' => 'reporte.listado.candidatos.convocatoria.premio.administracion'
        ]);
        $reporteCandidatosPremioAdministracionConvocatoria->syncRoles([Role::select('id')->where('name', 'ADMN_PA_21')->first()->id, Role::select('id')->where('name', 'OPER_PA_21')->first()->id, Role::select('id')->where('name', 'AUTZ_PA_21')->first()->id]);
    }
}
