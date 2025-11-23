<?php

namespace Database\Seeders\p11_seleccion_candidatos;

use Illuminate\Database\Seeder;
use App\Models\Tarea;
use App\Models\Area;
use App\Models\Proceso;

class TareasP11Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tarea = Tarea::create([
            'nombre' => 'Inicio de proceso - Solicitud de cita',
            'identificador' => 'T01',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.cita.examen'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Validación de propuestas',
            'identificador' => 'TS02',
            'descripcion' => 'Validar candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.validacion.propuestas'
        ]);
        $tarea->attachRoles(["SRIO_FZAS"]);

        $tarea = Tarea::create([
            'nombre' => 'Asignación de fecha de cita',
            'identificador' => 'T02',
            'descripcion' => 'Asignar fecha para psicometricos',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.asignacion.fecha.examen.psicometricos'
        ]);
        $tarea->attachRoles(["EVAL"]);

        $tarea = Tarea::create([
            'nombre' => 'Selección de Candidatos de Personal de Estructura - Notificación de Cita de Examen Psicométrico',
            'identificador' => 'TNOTA01',
            'descripcion' => 'Notificacion de fecha para examen psicometrico',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.notificacion.citas'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Selección de Candidatos de Personal de Estructura - Notificación de Autorización de Candidato',
            'identificador' => 'TNOTA02',
            'descripcion' => 'Notificacion de fecha para examen psicometrico',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.notificacion.citas'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Selección de Candidatos de Personal de Estructura - Notificación de Rechazo de Candidato',
            'identificador' => 'TNOTA03',
            'descripcion' => 'Notificacion de fecha para examen psicometrico',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.notificacion.rechazo.candidatosSrios'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Selección de Candidatos de Personal de Estructura - Notificación de Validación o Rechazo de Candidatos',
            'identificador' => 'TNOTA04',
            'descripcion' => 'Notificacion de fecha para examen psicometrico',
            'tipo' => 'NOTIFICACION',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.notificacion.rechazos'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Captura de resultados de examenes',
            'identificador' => 'T03',
            'descripcion' => 'Calificar examen psicometrico del candidato estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.vista.captura.resultados'
        ]);
        $tarea->attachRoles(["EVAL"]);

        $tarea = Tarea::create([
            'nombre' => 'Selección de candidato',
            'identificador' => 'T04',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.candidato.ocupar.plaza'
        ]);
        $tarea->attachRoles(["INI_CAND"]);

        $tarea = Tarea::create([
            'nombre' => 'Revisión de candidato',
            'identificador' => 'T05',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.candidato.comentarios'
        ]);
        $tarea->attachRoles(["DGA"]);

        $tarea = Tarea::create([
            'nombre' => 'Autorización de candidato',
            'identificador' => 'T06',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.candidatos.autorizaciones'
        ]);
        $tarea->attachRoles(["SRIO_FZAS"]);

        $tarea = Tarea::create([
            'nombre' => 'Asignar fecha de ingreso',
            'identificador' => 'T07',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.candidatos.fecha.ingresos1'
        ]);
        $tarea->attachRoles(["DGA"]);

        $tarea = Tarea::create([
            'nombre' => 'Número de validación del candidato',
            'identificador' => 'T08',
            'descripcion' => 'Iniciar proceso seleccion de candidatos estructura',
            'tipo' => 'TAREA',
            'proceso_id' => Proceso::where('identificador', 'seleccion_candidatos')->first()->proceso_id,
            'ruta' => 'seleccion.candidatos.candidatos.generacion.numero.validacion'
        ]);
        $tarea->attachRoles(["INI_CAND"]);
    }
}
