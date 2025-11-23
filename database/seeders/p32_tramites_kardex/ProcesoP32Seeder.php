<?php

namespace Database\Seeders\p32_tramites_kardex;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP32Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 32,
            'nombre' => 'TRÁMITES KARDEX',
            'identificador' => 'tramites_kardex',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso que permite administrar las Hojas de servicio, Comprobantes de servicio y Hojas de evaluación que requieren las diferentes unidades administrativas',
            'ruta_descripcion' => 'tramites.kardex.descripcion',
            'ruta_lista_tramites' => 'tramites.kardex.detalles.proceso',
            'icono' => 'fas fa-file-alt'
        ]);
        $proceso->attachRoles([
            ["name" => "CAPTURA_KARDEX", "inicializa_proceso" => true], 
            "ADMIN_KARDEX", 
            "TECNICO_OPERATIVO_KARDEX"
        ]);
    }
}
