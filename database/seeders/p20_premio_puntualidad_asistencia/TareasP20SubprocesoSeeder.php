<?php

namespace Database\Seeders\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;

class TareasP20SubprocesoSeeder extends Seeder
{
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'ASIGNACIÓN DE ÁREAS',
            'identificador' => 'ASIGANCION_DE_AREAS',
            'descripcion' => 'Dar indicaciones precisas a los operadores del proceso de premio de puntualidad y asistencia.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_premio_puntualidad_asistencia")->first()->proceso_id,
            'ruta' => 'captura.instrucciones.proceso'
        ]);
        $tarea->attachRoles(["ENLACE_PREMIO_PUNTUALIDAD"]);

        $tarea = Tarea::create([
            'nombre' => 'REGISTRO DE EMPLEADOS',
            'identificador' => 'REGISTRO_DE_EMPLEADOS',
            'descripcion' => 'Evaluar a los empleados que están interesados en recibir el premio de puntualidad en la quincena de pago indicada.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_premio_puntualidad_asistencia")->first()->proceso_id,
            'ruta' => 'evaluacion.adicion.empleados'
        ]);
        $tarea->attachRoles(["OPER_PREMIO_PUNTUALIDAD"]);

        $tarea = Tarea::create([
            'nombre' => 'APROBACIÓN Y ENVÍO DE SOLICITUDES',
            'identificador' => 'APROBACION_ENVIO_SOLICITUDES',
            'descripcion' => 'Mostrar el listado de las sub unidades administrativas incluídas en el proceso para pago de premio de puntualidad y asistencia.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_premio_puntualidad_asistencia")->first()->proceso_id,
            'ruta' => 'autorizacion.solicitudes'
        ]);
        $tarea->attachRoles(["ENLACE_PREMIO_PUNTUALIDAD"]);
    }
}
