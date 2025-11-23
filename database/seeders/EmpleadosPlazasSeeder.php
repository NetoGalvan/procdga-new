<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Plaza;
use App\Models\UnidadAdministrativa;
use Illuminate\Support\Carbon;

class EmpleadosPlazasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empleados = Empleado::all();

        foreach ($empleados as $key => $empleado) {
            // Se obtiene la plaza que concuerde con el Empleado
            $plaza = Plaza::where('numero_plaza', $empleado->numero_plaza)->first();
            // Si la plaza es nueva y no existe en la tabla de plazas la damos de alta antes de seguir con la creación o actualización del Empleado
            if ( !$plaza ) {
                $plaza = Plaza::create([
                    'numero_plaza' => trim($empleado->numero_plaza),
                    'unidad_administrativa' => trim($empleado->unidad_administrativa),
                    'subunidad' => trim($empleado->subunidad),
                    'direccion_administrativa' => trim($empleado->direccion_administrativa),
                    'subdireccion' => trim($empleado->subdireccion),
                    'jud' => trim($empleado->jud),
                    'oficina' => trim($empleado->oficina),
                    'codigo_puesto' => trim($empleado->codigo_puesto),
                    'nivel_salarial' => trim($empleado->nivel_salarial),
                    'codigo_universo' => trim($empleado->codigo_universo),
                    'puesto' => trim($empleado->puesto),
                    'codigo_situacion_empleado' => trim($empleado->codigo_situacion_empleado),
                    'last_modified' => Carbon::now()->format('Y-m-d'),
                ]);
            }
            // Se obtiene la Unidad Administrativa que concuerde con el Empleado
            $unidadAdm = UnidadAdministrativa::where('identificador', $empleado->unidad_administrativa)->first();

            // Validamos cuando un empleado no tenga apellido paterno le asiganmos el materno en su lugar
            $apellidoPaterno = empty($empleado->apellido_paterno) ? $empleado->apellido_materno : $empleado->apellido_paterno;
            $apellidoMaterno = empty($empleado->apellido_paterno) ? "" : $empleado->apellido_materno;

            // Actualizamos los datos faltantes del empleado
            $empleado->update([
                'plaza_id' => isset($plaza) ? $plaza->plaza_id : null,
                'unidad_administrativa_nombre' => isset($unidadAdm) ? $unidadAdm->nombre : null,
                'activo' => true,
                'apellido_paterno' => $apellidoPaterno,
                'apellido_materno' => $apellidoMaterno,
            ]);
            // Despues de Actualizar o Crear al Empleado se coloca como "activo" = true a la Plaza también
            $plaza->update(['activo' => true]);
        }

    }
}
