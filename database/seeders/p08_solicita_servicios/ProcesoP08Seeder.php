<?php

namespace Database\Seeders\p08_solicita_servicios;
use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP08Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 8,
            'nombre' => 'SOLICITUD DE SERVICIO',
            'identificador' => 'solicitud_servicios',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso optimizado que permite administrar los requerimientos de los servicios de mantenimiento, transporte, impresión y teléfonia que requieren las diferentes unidades administrativas',
            'ruta_descripcion' => 'solicitud.servicio.descripcion',
        ]);
        $proceso->attachRoles([["name" => "JUD_RM", "inicializa_proceso" => true]]);
    }
}
