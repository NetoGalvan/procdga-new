<?php

namespace Database\Seeders\p07_pago_prestaciones;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use Spatie\Permission\Models\Role;
use App\Models\Proceso;

class TareasProcesoPagoPrestacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TAREAS
        $tarea = Tarea::create([
            'nombre' => 'CREACIÓN DEL ESQUEMA DE DATOS',
            'identificador' => 'CREAR_ESQUEMA_DE_DATOS',
            'descripcion' => 'Creación del esquema de datos',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.esquema.datos'
        ]);
        $tarea->attachRoles(["JO_PRES"]);

        $tarea = Tarea::create([
            'nombre' => 'ENVIAR NÓMINA A VALIDACIÓN',
            'identificador' => 'ENVIAR_NOMINA_A_VALIDACION',
            'descripcion' => 'Enviar nómina a validación',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.enviar.nomina'
        ]);
        $tarea->attachRoles(["JO_PRES"]);

        $tarea = Tarea::create([
            'nombre' => 'VALIDAR NÓMINA DE LAS UNIDADES ADMINISTRATIVAS',
            'identificador' => 'VALIDAR_NOMINA_UNIDADES_ADMINISTRATIVAS',
            'descripcion' => 'Validar nómina de las unidades administrativas',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.validar.nomina'
        ]);
        $tarea->attachRoles(["JUD_PRES"]);

        $tarea = Tarea::create([
            'nombre' => 'APROBAR NÓMINA DE LAS UNIDADES ADMINISTRATIVAS',
            'identificador' => 'APROBAR_NOMINA_UNIDADES_ADMINISTRATIVAS',
            'descripcion' => 'Aprobar nómina de las unidades administrativas',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.aprobar.nomina'
        ]);
        $tarea->attachRoles(["SUB_PRES"]);

        $tarea = Tarea::create([
            'nombre' => 'EXPORTAR NÓMINA',
            'identificador' => 'EXPORTAR_NOMINA',
            'descripcion' => 'Exportar nómina',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.exportar.nomina'
        ]);
        $tarea->attachRoles(["JO_PRES"]);

        // SUBTAREAS
        $tarea = Tarea::create([
            'nombre' => 'CAPTURA DE CANDIDATOS',
            'identificador' => 'CAPTURA_CANDIDATOS',
            'descripcion' => 'Captura de candidatos',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.capturar.candidatos'
        ]);
        $tarea->attachRoles(["JUD_RH"]);

        $tarea = Tarea::create([
            'nombre' => 'APROBAR CANDIDATOS',
            'identificador' => 'APROBAR_CANDIDATOS',
            'descripcion' => 'Aprobar candidatos',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where("identificador", "subproceso_pago_prestaciones")->first()->proceso_id,
            'ruta' => 'pago.prestacion.aprobar.candidatos'
        ]);
        $tarea->attachRoles(["SUB_EA"]);

    }
}
