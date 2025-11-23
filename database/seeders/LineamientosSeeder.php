<?php

namespace Database\Seeders;

use App\Models\Lineamiento;
use Illuminate\Database\Seeder;

class LineamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA EL PROCEDIMIENTO DE AMONESTACIONES Y SANCIONES ADMINISTRATIVAS", 
            "identificador" => "amonestaciones_sanciones_administrativas",
            "ruta" => "pdf/lineamientos/1_amonestaciones_sanciones_administrativas.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA EL PROCEDIMIENTO DE TRÁMITE DE SOLICITUDES PARA LA APLICACIÓN DE DESCUENTOS POR FALTAS INJUSTIFICADAS Y SANCIONES DISCIPLINARIAS ASÍ COMO REINTEGROS", 
            "identificador" => "descuentos_faltas_injustificadas",
            "ruta" => "pdf/lineamientos/2_descuentos_faltas_injustificadas.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE INCIDENCIAS", 
            "identificador" => "aplicacion_incidencias",
            "ruta" => "pdf/lineamientos/3_aplicacion_incidencias.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE MOVIMIENTOS DE PERSONAL", 
            "identificador" => "movimientos_personal",
            "ruta" => "pdf/lineamientos/4_movimientos_personal.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACION DE NOTAS BUENAS", 
            "identificador" => "aplicaciones_notas_buenas",
            "ruta" => "pdf/lineamientos/5_aplicaciones_notas_buenas.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE PAGO DE TIEMPO EXTRAORDINARIO Y EXCEDENTE", 
            "identificador" => "tiempo_extra_excedente",
            "ruta" => "pdf/lineamientos/6_tiempo_extra_excedente.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE SELECCIÓN DE CANDIDATOS DE PERSONAL DE ESTRUCTURA", 
            "identificador" => "seleccion_candidatos_estructura",
            "ruta" => "pdf/lineamientos/7_seleccion_candidatos_estructura.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE SERVICIO SOCIAL", 
            "identificador" => "servicio_social",
            "ruta" => "pdf/lineamientos/8_servicio_social.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE SOLICITUD DE ADQUISICIONES", 
            "identificador" => "solicitud_adquisiciones",
            "ruta" => "pdf/lineamientos/9_solicitud_adquisiciones.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DE SOLICITUD DE SERVICIOS", 
            "identificador" => "solicitud_servicios",
            "ruta" => "pdf/lineamientos/10_solicitud_servicios.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DEL INCENTIVO AL SERVIDOR PÚBLICO DEL MES", 
            "identificador" => "empleado_mes",
            "ruta" => "pdf/lineamientos/11_empleado_mes.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DEL PREMIO DE ADMINISTRACIÓN", 
            "identificador" => "premio_administracion",
            "ruta" => "pdf/lineamientos/12_premio_administracion.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LA APLICACIÓN DEL PREMIO POR ASISTENCIA Y PUNTUALIDAD", 
            "identificador" => "premio_asistencia_puntualidad",
            "ruta" => "pdf/lineamientos/13_premio_asistencia_puntualidad.pdf"
        ]);
        Lineamiento::create([
            "nombre" => "LINEAMIENTOS PARA LOS PROCEDIMIENTOS ADMINISTRATIVOS Y O LABORALES", 
            "identificador" => "administrativos_laborales",
            "ruta" => "pdf/lineamientos/14_administrativos_laborales.pdf"
        ]);
    }
}
