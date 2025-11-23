<?php

namespace Database\Seeders\p23_solicitud_expediente;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP23Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 23,
            'nombre' => 'DIGITALIZACIÓN DE ARCHIVO',
            'identificador' => 'digitalizacion_archivo',
            'tipo' => 'PROCESO',
            'descripcion' => 'Generar la ficha del expediente y carga del expediente digitalizado.',
            'ruta_descripcion' => 'digitalizacion.archivo.descripcion',
            'icono' => 'fas fa-file-upload',
        ]);
        $proceso->attachRoles([["name" => "OPER_DIG_23", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 23.1,
            'nombre' => 'SOLICITUD Y PRÉSTAMO DE EXPEDIENTES',
            'identificador' => 'solicitud_prestamo_expedientes',
            'tipo' => 'PROCESO',
            'descripcion' => 'Cubrir y dar seguimiento a las solicitudes de préstamo de expedientes de empleados.',
            'ruta_descripcion' => 'solicitud.prestamo.expedientes.descripcion',
            'icono' => 'fas fa-file-export',
            'activo' => false,
        ]);
        $proceso->attachRoles([["name" => "INI_EXP_23", "inicializa_proceso" => true]]);
    }
}
