<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Reporte;
use Spatie\Permission\Models\Role;

class ReportesP20Seeder extends Seeder
{
    public function run()
    {
        // Reporte 1. REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA
        // Para el rol ADMIN_PREMIO_PUNTUALIDAD, ENLACE_PREMIO_PUNTUALIDAD y OPER_PREMIO_PUNTUALIDAD
        $reporte = Reporte::create([
            'nombre' => 'REPORTE EJECUTIVO DE PROCESOS EJECUTADOS PARA PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'reporte_ejecutivo_premios_administración',
            'descripcion' => 'Generar reporte ejecutivo del proceso de premio y puntualidad',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'reporte.ejecutivo.premio.puntualidad.asistencia'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_PREMIO_PUNTUALIDAD')->first()->id, Role::select('id')->where('name', 'ENLACE_PREMIO_PUNTUALIDAD')->first()->id, Role::select('id')->where('name', 'OPER_PREMIO_PUNTUALIDAD')->first()->id ]);

        // Reporte 2. REIMPRESIÓN RELACIÓN DE EMPLEADOS PREMIO DE PUNTUALIDAD Y ASISTENCIA
        // Para el rol ADMIN_PREMIO_PUNTUALIDAD
        $reporte = Reporte::create([
            'nombre' => 'REIMPRESIÓN RELACIÓN DE EMPLEADOS PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'reporte_reimpresion_relacion_empleados',
            'descripcion' => 'Reimprimir relación de empleados',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'reporte.reimpresion.relacion.empleados'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_PREMIO_PUNTUALIDAD')->first()->id ]);

        // Reporte 3. REIMPRESIÓN DE LAYOUT PREMIO PUNTUALIDAD Y ASISTENCIA
        // Para el rol ADMIN_PREMIO_PUNTUALIDAD
        $reporte = Reporte::create([
            'nombre' => 'REIMPRESIÓN DE LAYOUT PREMIO PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'reporte_reimpresion_layout_premio',
            'descripcion' => 'Reimprimir layout del proceso',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'reporte.reimpresion.layout.premio'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ADMIN_PREMIO_PUNTUALIDAD')->first()->id ]);

        // // Reporte 4. OPERADOR REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA
        // // Para el rol OPER_PREMIO_PUNTUALIDAD
        // $reporte = Reporte::create([
        //     'nombre' => 'OPERADOR REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA',
        //     'identificador' => 'reporte_operador_listado_solicitantes',
        //     'descripcion' => 'Listado de solicitantes',
        //     'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
        //     'ruta' => 'reporte.operador.listado.solicitantes'
        // ]);
        // $reporte->syncRoles([ Role::select('id')->where('name', 'OPER_PREMIO_PUNTUALIDAD')->first()->id ]);

        // Reporte 5. ENLACE REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA
        // Para el rol ENLACE_PREMIO_PUNTUALIDAD
        $reporte = Reporte::create([
            'nombre' => 'REPORTE LISTADO DE SOLICITANTES PREMIO PUNTUALIDAD Y ASISTENCIA CON TARJETA ELECTRÓNICA',
            'identificador' => 'reporte_enlace_listado_solicitantes',
            'descripcion' => 'Listado de solicitantes',
            'proceso_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'ruta' => 'reporte.enlace.listado.solicitantes'
        ]);
        $reporte->syncRoles([ Role::select('id')->where('name', 'ENLACE_PREMIO_PUNTUALIDAD')->first()->id, Role::select('id')->where('name', 'OPER_PREMIO_PUNTUALIDAD')->first()->id ]);
    }
}
