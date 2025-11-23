<?php

namespace Database\Seeders\p08_solicita_servicios;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use App\Models\Proceso;

class ManualesP08Seeder extends Seeder {

    public function run()
    {
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            "nombre" => "SOLICITUD DE MANTENIMIENTO",
            "identificador" => "manual_servicio_mantenimiento",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p08_servicio_mantenimiento.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            "nombre" => "SOLICITUD DE REPRODUCCIÓN DE FORMATOS, GUILLOTINA Y ENGARGOLADO",
            "identificador" => "manual_servicio_impresion",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p08_servicio_impresion.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            "nombre" => "SOLICITUD DE TRANSPORTE DE BIENES O PERSONAL",
            "identificador" => "manual_servicio_transporte",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p08_servicio_transporte.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            "nombre" => "SOLICITUD DE TELEFONÍA",
            "identificador" => "manual_servicio_telefonia",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p08_servicio_telefonia.pdf"
        ]);
        Manual::create([
            "proceso_id" => Proceso::where('identificador', 'solicitud_servicios')->first()->proceso_id,
            "nombre" => "SOLICITUD DE LIMPIEZA Y ESTIBAS",
            "identificador" => "manual_servicio_limpieza",
            "descripcion" => "",
            "ruta" => "pdf/manuales/p08_servicio_limpieza.pdf"
        ]);
    }
}
