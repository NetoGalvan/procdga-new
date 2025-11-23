<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP23Seeder extends Seeder
{
    public function run()
    {
        // Reporte 1. REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN
        // Para el rol OPER_DIG_23 y CTRL_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DETALLE DE DIGITALIZACIÓN',
            'identificador' => 'reporte_ejecutivo_detalle_digitalizacion',
            'descripcion' => 'Generar reporte ejecutivo detalle de digitalización',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.detalle.digitalizacion'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'OPER_DIG_23')->first()->id, Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id ]);

        // Reporte 2. REPORTE EJECUTIVO DIGITALIZACIÓN DE ARCHIVO
        // Para el rol OPER_DIG_23 y CTRL_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DIGITALIZACIÓN DE ARCHIVO',
            'identificador' => 'reporte_ejecutivo_digitalizacion_archivo',
            'descripcion' => 'Generar reporte ejecutivo del proceso digitalización de archivo',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.digitalizacion.archivo'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'OPER_DIG_23')->first()->id, Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id ]);

        // Reporte 3. REPORTE EJECUTIVO EXPEDIENTES DIGITALIZADOS EN EL PERIODO
        // Para el rol CTRL_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO EXPEDIENTES DIGITALIZADOS EN EL PERIODO',
            'identificador' => 'reporte_ejecutivo_expedientes_digitalizados',
            'descripcion' => 'Generar reporte ejecutivo de expedientes digitalizados en el periodo',
            'proceso_id' => Proceso::where('identificador', 'digitalizacion_archivo')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.expedientes.digitalizados'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id ]);

        // Reporte 4. REPORTE EJECUTIVO CÓDIGOS DE SEGURIDAD PARA SOLICITUD DE EXPEDIENTE
        // Para el rol CTRL_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO CÓDIGOS DE SEGURIDAD PARA SOLICITUD DE EXPEDIENTE',
            'identificador' => 'reporte_ejecutivo_codigos_seguridad',
            'descripcion' => 'Generar reporte ejecutivo códigos de seguridad para solicitud de expediente',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.codigos.seguridad',
            'activo' => false
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id ]);

        // Reporte 5. REPORTE EJECUTIVO SOLICITUD DE PRÉSTAMO DE ARCHIVO
        // Para el rol CTRL_EXP_23 y OPER_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO SOLICITUD DE PRÉSTAMO DE ARCHIVO',
            'identificador' => 'reporte_ejecutivo_solicitud_prestamo_archivo',
            'descripcion' => 'Generar reporte ejecutivo solicitud de préstamo de archivo',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.solicitud.prestamo.archivo',
            'activo' => false
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id, Role::select('id')->where('name', 'OPER_EXP_23')->first()->id ]);

        // Reporte 6. REPORTE EJECUTIVO DETALLE DE PRÉSTAMO
        // Para el rol CTRL_EXP_23 y OPER_EXP_23
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DETALLE DE PRÉSTAMO',
            'identificador' => 'reporte_ejecutivo_detalle_prestamo',
            'descripcion' => 'Generar reporte ejecutivo detalle de préstamo',
            'proceso_id' => Proceso::where('identificador', 'solicitud_prestamo_expedientes')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.detalle.prestamo',
            'activo' => false
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'CTRL_EXP_23')->first()->id, Role::select('id')->where('name', 'OPER_EXP_23')->first()->id ]);
    }
}
