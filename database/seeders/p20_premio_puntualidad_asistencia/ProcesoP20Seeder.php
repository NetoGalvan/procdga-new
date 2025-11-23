<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;

class ProcesoP20Seeder extends Seeder
{
    public function run()
    {
        $proceso = Proceso::create([
            'numero_proceso' => 20,
            'nombre' => 'ADMINISTRACIÓN DE PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'premio_puntualidad_asistencia',
            'tipo' => 'PROCESO',
            'descripcion' => 'Evaluar la asistencia y puntualidad de los empleados por un periodo de 6 meses',
            'ruta_descripcion' => 'premio.puntualidad.asistencia.descripcion',
            'icono' => 'fas fa-award',
        ]);
        $proceso->attachRoles([["name" => "ADMIN_PREMIO_PUNTUALIDAD", "inicializa_proceso" => true]]);

        $proceso = Proceso::create([
            'numero_proceso' => 20.1,
            'proceso_padre_id' => Proceso::where('identificador', 'premio_puntualidad_asistencia')->first()->proceso_id,
            'nombre' => 'SUBPROCESO - INSCRIPCIÓN AL PREMIO DE PUNTUALIDAD Y ASISTENCIA',
            'identificador' => 'subproceso_premio_puntualidad_asistencia',
            'tipo' => 'SUBPROCESO',
            'descripcion' => 'Evaluar la asistencia y puntualidad de los empleados por un periodo de 6 meses',
            'ruta_descripcion' => 'subproceso.premio.puntualidad.asistencia.descripcion',
        ]);
        $proceso->attachRoles([["name" => "ENLACE_PREMIO_PUNTUALIDAD", "inicializa_proceso" => true]]);
    }
}
