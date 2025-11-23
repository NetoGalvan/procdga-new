<?php

namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use App\Models\Reporte;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ReportesP08Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $reporteMtto = Reporte::create([
            'nombre' => 'SOLICITUDES DE SERVICIO DE MANTENIMIENTO',
            'identificador' => 'reporte_ss_mantenimiento',
            'descripcion' => 'Generar reporte de las diferentes solicitudes de servicio de mantenimiento hechas al área.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.reporte.mantenimiento'
        ]);
        $reporteMtto->syncRoles([Role::select('id')->where('name', 'JUD_MTTO')->first()->id]);

        $reporteTransporte = Reporte::create([
            'nombre' => 'SOLICITUDES DE SERVICIO DE TRANSPORTE',
            'identificador' => 'reporte_ss_transporte',
            'descripcion' => 'Generar reporte de las diferentes solicitudes de servicio de transporte hechas al área.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.reporte.transporte'
        ]);
        $reporteTransporte->syncRoles([Role::select('id')->where('name', 'JUD_TRANSPORTE')->first()->id]);

        $reporteTelefonia = Reporte::create([
            'nombre' => 'SOLICITUDES DE SERVICIO DE TELEFONÍA',
            'identificador' => 'reporte_ss_telefonia',
            'descripcion' => 'Generar reporte de las diferentes solicitudes de servicio de telefonia hechas al área.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.reporte.telefonia'
        ]);
        $reporteTelefonia->syncRoles([Role::select('id')->where('name', 'JUD_TELEFONIA')->first()->id]);

        $reporteImpresiones = Reporte::create([
            'nombre' => 'SOLICITUDES DE SERVICIO DE IMPRESIONES',
            'identificador' => 'reporte_ss_impresiones',
            'descripcion' => 'Generar reporte de las diferentes solicitudes de servicio de impresiones hechas al área.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.reporte.impresiones'
        ]);
        $reporteImpresiones->syncRoles([Role::select('id')->where('name', 'JUD_IMPRE')->first()->id]);

        $reporteLimpieza = Reporte::create([
            'nombre' => 'SOLICITUDES DE SERVICIO DE LIMPIEZA',
            'identificador' => 'reporte_ss_limpieza_estibas',
            'descripcion' => 'Generar reporte de las diferentes solicitudes de servicio de limpieza hechas al área.',
            'proceso_id' => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            'ruta' => 'solicitud.servicio.reporte.limpieza.estibas'
        ]);
        $reporteLimpieza->syncRoles([Role::select('id')->where('name', 'JUD_LIMPIEZA')->first()->id]);

    }
}
