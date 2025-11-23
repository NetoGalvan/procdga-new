<?php

namespace Database\Seeders\p21_premio_administracion;

use Illuminate\Database\Seeder;
use App\Models\Proceso;
use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;

class TareasP21SeederInscripcion extends Seeder
{
    public function run()
    {
        // Tareas para Premio Administracion - Inscripción
        $tarea = Tarea::create([
            'nombre' =>  'BUSQUEDA Y GENERACIÓN DE FORMATOS',
            'identificador' =>  'TPAI01',
            'descripcion' => 'Buscar que el empleado esté activo y que pertenezca a la unidad administrativa del operador.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion_inscripcion')->first()->proceso_id,
            'ruta' => 'inscripcion.premio.administracion.busqueda.generacion.formatos'
        ]);
        $tarea->attachRoles(["OPER_PA_21"]);

        $tarea = Tarea::create([
            'nombre' =>  'CAPTURA Y EVALUACIÓN DE CURSOS',
            'identificador' =>  'TPAI02',
            'descripcion' => 'Capturar la información laboral del empleado.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion_inscripcion')->first()->proceso_id,
            'ruta' => 'inscripcion.premio.administracion.captura.evaluacion.cursos'
        ]);
        $tarea->attachRoles(["OPER_PA_21"]);

        $tarea = Tarea::create([
            'nombre' =>  'VALIDACIÓN DE CURSOS',
            'identificador' =>  'TPAI03',
            'descripcion' => 'Validar los cursos tomados por el candidato inscrito al premio de administración.',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'premio_administracion_inscripcion')->first()->proceso_id,
            'ruta' => 'inscripcion.premio.administracion.validacion.cursos'
        ]);
        $tarea->attachRoles(["OPER_CAP_21"]);
    }
}
