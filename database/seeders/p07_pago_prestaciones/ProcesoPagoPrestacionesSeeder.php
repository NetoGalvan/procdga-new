<?php

namespace Database\Seeders\p07_pago_prestaciones;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoPagoPrestacionesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 7,
            'nombre' => 'PAGO DE PRESTACIONES',
            'identificador' => 'pago_prestaciones',
            'tipo' => 'PROCESO',
            'descripcion' => 'Proceso que permite el Pago de Prestaciones a los trabajadores',
            'ruta_descripcion' => 'pago.prestacion.descripcion',
            'icono' => 'fas fa-file-invoice',
            'activo' => false
        ]);
        $proceso->attachRoles([["name" => "JO_PRES", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 7.1,
            'proceso_padre_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'nombre' => 'SUBPROCESO - PAGO DE PRESTACIONES',
            'identificador' => 'subproceso_pago_prestaciones',
            'tipo' => 'SUBPROCESO',
            'descripcion' => 'Proceso que permite el Pago de Prestaciones a los trabajadores',
            'ruta_descripcion' => 'pago.prestacion.descripcion',
            'activo' => false
        ]);
        $proceso->attachRoles([["name" => "JUD_RH", "inicializa_proceso" => true]]);
    }
}
