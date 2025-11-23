<?php

namespace Database\Seeders\p16_pago_tiempo_extraordinario_excedente;

use App\Models\Proceso;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ProcesoP16Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $proceso = Proceso::create([
            'numero_proceso' => 16,
            'nombre' => 'PAGO DE TIEMPO EXTRA Y EXCEDENTE',
            'identificador' => 'tiempo_extraordinario_excedente',
            'tipo' => 'PROCESO',
            'descripcion' => 'Asignación, Distribución, Revisión y Autorización del presupuesto asignado quincenalmente al tiempo extraordinario y excedente.',
            'ruta_descripcion' => 'tiempo.extraordinario.excedente.descripcion',
            'icono' => 'fas fa-user-clock',
        ]);
        $proceso->attachRoles([["name" => "ADMIN_TIEMPO_EXTRA", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 16.1,
            'proceso_padre_id' => Proceso::where("identificador", "tiempo_extraordinario_excedente")->first()->proceso_id,
            'nombre' => 'SUBPROCESO - PAGO DE TIEMPO EXTRA Y EXCEDENTE',
            'identificador' => 'subproceso_tiempo_extraordinario_excedente',
            'tipo' => 'SUBPROCESO',
            'descripcion' => 'Asignación, Distribución, Revisión y Autorización del presupuesto asignado quincenalmente al tiempo extraordinario y excedente.',
            'ruta_descripcion' => 'subproceso.tiempo.extraordinario.excedente.descripcion',
        ]);
        $proceso->attachRoles([["name" => "SUB_EA", "inicializa_proceso" => true]]);
    }
}
