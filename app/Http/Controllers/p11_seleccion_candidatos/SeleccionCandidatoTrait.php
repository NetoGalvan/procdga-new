<?php
namespace App\Http\Controllers\p11_seleccion_candidatos;

use Illuminate\Http\Request;
use App\Models\p11_seleccion_candidatos\SeleccionCandidatoEstructura;
use App\Models\p11_seleccion_candidatos\Candidato;
use App\Models\Proceso;
use App\Http\Traits\RegistroInstancias;
use App\Models\p11_seleccion_candidatos\DetallesCandidato;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use DB;

trait SeleccionCandidatoTrait
{

    use RegistroInstancias;

    /* public function crearSeleccionCandidatos ( $instancia, $folio )
    {

        $candidatos = new SeleccionCandidatoEstructura();
        $candidatos->estatus_trabajo = 'WORKING';
        $candidatos->instancia_id = $instancia->instancia_id;
        $candidatos->folio = $folio;
        $candidatos->plaza_id = 47;
        $candidatos->save();
        return $candidatos;

    } */

    // Guarda datos T01 y utiliza otros 2 métodos
    public function guardarTarea1CitaPsicometrico ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        // Obtenemos al Usuario
        $usuarios = Auth::user();
        // La Unidad a la que pertenece el Usuario
        $unidadAdmin = DB::table('areas')
            ->join('unidades_administrativas', 'areas.identificador_unidad', 'unidades_administrativas.identificador_unidad')
            ->where('areas.area_id', $usuarios->area_id)
            ->first();
        // La plazas
        $plazas = DB::table('p24_catalogo_plazas')->where('plaza_id', $request->numPlaza)->first();

        DB::beginTransaction();
        try {
            // Se guardan los datos en la tabla principal del P11 p11_seleccion_cadidatos
            $candidatoEstructura->unidad_administrativa_id = $unidadAdmin->unidad_administrativa_id;
            $candidatoEstructura->nombre_unidad = $unidadAdmin->nombre_unidad;
            $candidatoEstructura->identificador_unidad = $unidadAdmin->identificador_unidad;
            $candidatoEstructura->plaza_id = $plazas->plaza_id;
            $candidatoEstructura->numero_plaza = $plazas->numero_plaza;
            $candidatoEstructura->save();

            DB::commit();
            // Despues pasa los datos para seguir el guardado
            return $this->guardarCandidatosSeleccionados($request, $candidatoEstructura);

        } catch (\Throwable $th) {

            DB::rollback();
            return $th;
        }


    }

    // Guarda datos T01 y utiliza otros 2 métodos
    public function guardarCandidatosSeleccionados ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        DB::beginTransaction();
        try {
            // Se recorre los candidatos capturados y se guardan en la Tabla p11_candidatos
        foreach ( json_decode($request->arregloTablaCandidatos) as $candidatos ) {
            $candidato = new Candidato();
            $candidato->nombre_candidato = $candidatos->nombre;
            $candidato->apellido_paterno_candidato = $candidatos->apePaterno;
            $candidato->apellido_materno_candidato = $candidatos->apeMaterno;
            $candidato->rfc = $candidatos->rfc;
            $candidato->no_empleado = $candidatos->noEmpleado;
            $candidato->save();

            DB::commit();
            // Despues de guardar pasa esos datos para guardar el detalle de los candidatos para guardar y crear la relación
            $detalles = $this->guardarDetalleCandidatos($candidatos, $candidatoEstructura, $candidato);
        }

        return $detalles;

        } catch (\Throwable $th) {

            DB::rollback();
            return $th;
        }


    }

    // Guarda datos T01 y utiliza otros 2 métodos
    public function guardarDetalleCandidatos ( $candidatos, SeleccionCandidatoEstructura $candidatoEstructura, Candidato $candidato )
    {
        DB::beginTransaction();
        try {
            // Guarda el detalle del candidato y su relación en la tabla p11_detalles
            $detalles = new DetallesCandidato();
            $detalles->candidato_id = $candidato->candidato_id;
            $detalles->seleccion_candidato_id = $candidatoEstructura->seleccion_candidato_id;
            $detalles->plaza_id = 47;
            $detalles->folio = $candidatoEstructura->folio;
            $detalles->tipo_movimiento = $candidatos->tipoMovimiento;
            $detalles->observaciones_titular = $candidatos->observaciones;
            $detalleGuardado = $detalles->save();

            DB::commit();
            // Despues de guardar se regresa respuesta
            return $detalleGuardado;

        } catch (\Throwable $th) {

            DB::rollback();
            return $th;
        }

    }

    // Método encargado de guardar la selección de la TS02 Validación de Candidatos
    public function guardarValidacionCandidatos ( $request,  $candidatoEstructura )
    {
        $validado = 0;
        $rechazado = 0;
        DB::beginTransaction();
        try {
            // Recorremos el arreglo de datos de la Tabla e Iniciamos la Validación para el Guardado
            foreach ( json_decode($request['dataTableCandidatos']) as $key => $tablaCandidato ) {

                // Con el id del candidato se obtiene el detalle del mismo
                $detalleCandidato = $candidatoEstructura->getDetalleCandidatos($tablaCandidato->candidato_id);
                // Se genera el nombre de la variable dinamica con el ID  y el NAME del INPUT del SELECT para obtener el valor seleccionado
                $estatusTitularDinamico = 'titularSolicitante_'.$tablaCandidato->candidato_id;
                // Con esa variable se puede saber que valor se debe guardar
                $detalleCandidato->update([ 'aceptacion_srio' => $request[$estatusTitularDinamico] ]);

                // Si algun candidato fue validado se contabiliza para generar la siguiente tarea
                if ( $request[$estatusTitularDinamico] == 'VALIDADO' ) {
                    $validado ++;
                } else {
                    // Si no se contabilizan los rechazos
                    $rechazado ++;
                }
            }

            DB::commit();

            // Despues de guardar se regresa respuesta
            $respuesta = [ 'estatus' => true, 'validado' => $validado, 'rechazado' => $rechazado];
            return $respuesta;

        } catch (\Throwable $th) {
            DB::rollback();

            // Si surge algun error se regresa respuesta
            $respuesta = [ 'estatus' => false, 'error' => $th];
            return $respuesta;
        }

    }

    // Método encargado de guardar los datos para el Examen Psicométrico del Candidato T02
    public function guardarFechas ( $request, $candidatoEstructura )
    {
        DB::beginTransaction();
        try {

            foreach ( json_decode($request['dataTableCandidatos']) as $key => $tablaCandidato ) {
                // Con el id del candidato se obtiene el detalle del mismo
                $detalleCandidato = $candidatoEstructura->getDetalleCandidatos($tablaCandidato->candidato_id);
                // Se genera el nombre de la variable dinamica con el ID  y el NAME de los INPUTS para obtener el valor seleccionado
                $fechaCita = 'fecha_cita_'.$tablaCandidato->candidato_id;
                $horaCita = 'hora_cita_'.$tablaCandidato->candidato_id;
                $lugarCita = 'lugar_cita_'.$tablaCandidato->candidato_id;
                // Con esa variable se puede saber que valor se debe guardar y actualizar
                $guardado = $detalleCandidato->update([
                    'fecha_cita' => $request[$fechaCita],
                    'hora_cita' => $request[$horaCita],
                    'lugar_cita' => $request[$lugarCita],
                ]);

            }

            DB::commit();

            // Despues de actualizar se regresa respuesta
            $respuesta = [ 'estatus' => true, 'guardado' => $guardado];
            return $respuesta;

        } catch (\Throwable $th) {
            DB::rollback();

            // Si surge algun error se regresa respuesta
            $respuesta = [ 'estatus' => false, 'error' => $th];
            return $respuesta;
        }

        /* $validos = false;
        foreach ( json_decode($request->arregloTablaCandidatos) as $candidatos ) {
            // $detalles = $candidatoEstructura->getDetalleCandidatos($candidatos->candidato_id);
            $detalles->fecha_cita = $candidatos->fhEval;

            $detalles->hora_cita = $candidatos->horaEval;
            $detalles->lugar_cita = $candidatos->lugarEval;

            $validos = $detalles->save();
        }

        return $validos; */

    }

    public function guardarDatos ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $validos = false;

        $detalles = $candidatoEstructura->getDetalleCandidatos($request->candidato_id);

        $candidatoInfos = $candidatoEstructura->getCandidatos($request->candidato_id);

        $detalles->sintesis_evaluacion = $request->sintesisEvaluacion;
        $detalles->nombre_elabora = $request->elabora;

        $candidatoInfos->apellido_paterno_candidato = $request->apePaterno;
        $candidatoInfos->apellido_materno_candidato = $request->apeMaterno;
        $candidatoInfos->nombre_candidato = $request->nombre;
        $candidatoInfos->fecha_nacimiento = $request->fhNacimiento;
        $detalles->fecha_evaluacion = $request->fhEvaluacion;
        $candidatoInfos->sexo_id = $request->sexo;
        $candidatoInfos->estado_civil_id = $request->estadoCivil;
        $detalles->aceptacion_eval = $request->aceptacion_eval;

        $detalles->motivo_evaluacion = $request->motivoEvaluacion;
        $detalles->folio_contraloria = $request->folioContraloria;
        $candidatoInfos->escolaridad = $request->escolaridad;

        $validos = $detalles->save();
        $candidatoInfos->save();

        return $validos;

    }

    public function guardarDatosEvaluaciones ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $validos = false;

        $detalles = $candidatoEstructura->getDetalleCandidatos($request->candidato_id_1);

        $detalles->resultados_eval_personalidad = collect($request->arregloPersonalidad);
        $detalles->resultados_eval_capacidades = collect($request->arregloCapacidades);
        ;

        $detalles->resultados_eval_habilidades = collect($request->arregloHabilidades);
        $detalles->resultados_eval_integridad = collect($request->arregloIntegridad);
        $detalles->resultados_eval_grafica = collect($request->arregloValidez);
        $detalles->fecha_evaluacion = $request->fhEvaluacion;

        $validos = $detalles->save();

        return $validos;

    }

    public function guardarPlazaOcupar ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $validos = false;

        foreach ( json_decode($request->arregloTablaCandidatos) as $candidatos ) {
            $detalles = $candidatoEstructura->getDetalleCandidatos($candidatos->candidato_id);
            $detalles->aceptacion_titular = $candidatos->validacionSecretarios;

            $validos = $detalles->save();
        }
        $validos = $detalles->save();

        return $validos;

    }

    public function guardarComentarios ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $validos = false;
        $candidatoEstructura->comentarios_dga = $request->comentarioDga;

        $validos = $candidatoEstructura->save();

        return $validos;

    }

    public function guardarFechasIngresosIn ( Request $request, DetallesCandidato $candidatosEstructura )
    {

        $candidatosEstructura->fecha_alta = $request->fecha_alta;
        $validos = $candidatosEstructura->save();

        return $validos;

    }

    public function guardarAutorizacionCandidatos ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $rechazado = false;
        $candidatoSeleccionado = DetallesCandidato::where(
                [
                        [
                                'seleccion_candidato_id',
                                '=',
                                $candidatoEstructura->seleccion_candidato_id
                        ],
                        [
                                'aceptacion_titular',
                                '=',
                                'ACEPTADO'
                        ]
                ])->first();
        $candidatoSeleccionado->aceptacion_srio = $request->aceptacion_srio;
        $candidatoSeleccionado->save();
        $candidatoEstructura->aceptacion_srio = $request->aceptacion_srio;
        if ( $request->aceptacion_srio == 'RECHAZADO' ) {

            $candidatoEstructura->instancia->crearInstanciaTarea('TNOTA03', 'NOTIFICACION_NO_LEIDO');
            $candidatoEstructura->instancia->crearInstanciaTarea('TNOTA04', 'NOTIFICACION_NO_LEIDO');
            $rechazado = true;
        }
        // dd($candidatoEstructura);
        $validos = $candidatoEstructura->save();

        return array(
                $validos,
                $rechazado
        );

    }

    // Valida el Form de la T01, (Con los ajustes tal vez no se usara)
    function validarForm ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $requestObj = new Request(json_decode($request->arregloTablaCandidatos, true));

        $messages = [
                'tiposMovimientos.required' => 'El campo no pude estar vacio',

                'nombre.required' => 'El campo Nombre no pude estar vacio',
                'apePaterno.required' => 'El campo Apellido Paterno no pude estar vacio',
                'apeMaterno.required' => 'El campo Apellido Maternono pude estar vacio',
                'rfc.required' => 'El campo RFC no pude estar vacio',
                'homoclave.required' => 'El campo Homoclave no pude estar vacio',
                'observaciones.required' => 'El campo Observaciones no pude estar vacio'
        ];
        $input = json_decode($request->arregloTablaCandidatos, true);

        $arregloMensajes = [];
        for ( $i = 0; $i < count($input); $i ++ ) {

            $arrayErrores = [];
            foreach ( $input[$i] as $key => $value ) {

                $arrayErrores[$key] = $value;
            }
            $rules = [
                    'tiposMovimientos' => 'required',
                    'nombre' => 'required',
                    'apePaterno' => 'required',
                    'apeMaterno' => 'required',
                    'rfc' => 'required',
                    'homoclave' => 'required',
                    'observaciones' => 'required'
            ];

            $validator = Validator::make($arrayErrores, $rules)->passes();
            $arregloMensajes[$i] = $validator;
            $arregloMensajes['mensajesForm' . $i] = Validator::make($arrayErrores, $rules, $messages);
        }

        if ( count($arregloMensajes) > 2 ) {
            $formValido = ((($arregloMensajes[0] + $arregloMensajes[1] == 0) ? false : $arregloMensajes[0] +
                    $arregloMensajes[1] == 1) ? false : true);
            $arregloMensajes['validos'] = $formValido;
        }

        $arregloMensajes['validos'] = $arregloMensajes[0];

        return $arregloMensajes;

    }

    // Valida el Form de la TS02, (Con los ajustes tal vez no se usara)
    public function validarFormTareaTS02 ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $messages = [

                'validacionSecretarios.required' => 'El campo Observaciones no pude estar vacio',
                'validacionSecretarios.not_in' => 'Seleccione una opcion valida para "Validaci�n del Secretario"'
        ];
        $input = json_decode($request->arregloTablaCandidatos, true);

        $arregloMensajes = [];
        for ( $i = 0; $i < count($input); $i ++ ) {

            $arrayErrores = [];
            foreach ( $input[$i] as $key => $value ) {

                $arrayErrores[$key] = $value;
            }
            $rules = [
                    'validacionSecretarios' => [
                            'required',
                            Rule::notIn([
                                    '-1'
                            ])
                    ]
            ];

            $validator = Validator::make($arrayErrores, $rules)->passes();
            $arregloMensajes[$i] = $validator;
            $arregloMensajes['mensajesForm' . $i] = Validator::make($arrayErrores, $rules, $messages);
        }

        if ( count($arregloMensajes) > 2 ) {
            $formValido = ((($arregloMensajes[0] + $arregloMensajes[1] == 0) ? false : $arregloMensajes[0] +
                    $arregloMensajes[1] == 1) ? false : true);
            $arregloMensajes['validos'] = $formValido;
        }
        else {
            $arregloMensajes['validos'] = $arregloMensajes[0];
        }

        return $arregloMensajes;

    }

    // Valida el Form de la T02, (Con los ajustes tal vez no se usara)
    public function validarFormTareaT02 ( Request $request, SeleccionCandidatoEstructura $candidatoEstructura )
    {

        $messages = [

                'fhEval.required' => 'El campo fecha Evaluaci�n no puede estar vacio',
                'horaEval.required' => 'El campo Hora Evaluaci�n no puede estar vacio',
                'lugarEval.required' => 'El campo Lugar Evaluaci�n no puede estar vacio'
        ];
        $input = json_decode($request->arregloTablaCandidatos, true);

        $arregloMensajes = [];
        for ( $i = 0; $i < count($input); $i ++ ) {

            $arrayErrores = [];
            foreach ( $input[$i] as $key => $value ) {

                $arrayErrores[$key] = $value;
            }
            $rules = [
                    'fhEval' => 'required',
                    'horaEval' => 'required',
                    'lugarEval' => 'required'
            ];

            $validator = Validator::make($arrayErrores, $rules)->passes();
            $arregloMensajes[$i] = $validator;
            $arregloMensajes['mensajesForm' . $i] = Validator::make($arrayErrores, $rules, $messages);
        }

        if ( count($arregloMensajes) > 2 ) {
            $formValido = ((($arregloMensajes[0] + $arregloMensajes[1] == 0) ? false : $arregloMensajes[0] +
                    $arregloMensajes[1] == 1) ? false : true);
            $arregloMensajes['validos'] = $formValido;
        }
        else {
            $arregloMensajes['validos'] = $arregloMensajes[0];
        }

        return $arregloMensajes;

    }

    public function validarFormDatosEmpleadosT03 ( Request $request )
    {

        $messages = [

                'fhEval.required' => 'El campo fecha Evaluaci�n no puede estar vacio',
                'horaEval.required' => 'El campo Hora Evaluaci�n no puede estar vacio',
                'lugarEval.required' => 'El campo Lugar Evaluaci�n no puede estar vacio'
        ];

        $rules = [
                'apePaterno' => 'required',
                'apeMaterno' => 'required',
                'nombre' => 'required',
                'fhNacimiento' => 'required',
                'edad' => [
                        'required',
                        'numeric'
                ],
                'sexo' => [
                        'required',
                        Rule::notIn([
                                '-1'
                        ])
                ],
                'estadoCivil' => [
                        'required',
                        Rule::notIn([
                                '-1'
                        ])
                ],
                'escolaridad' => 'required',
                'puestoActual' => 'required',
                'tipoMovimiento' => 'required',
                'motivoEvaluacion' => 'required',
                'folioContraloria' => 'required',
                'elabora' => 'required',
                'fhEvaluacion' => 'required',
                'aceptacion_eval' => 'required',
                'sintesisEvaluacion' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator->validate();

    }

    public function validarFormCandidatosEmpleadosT04 ( Request $request )
    {

        $messages = [
                'validacionSecretarios.required' => "Seleccione una opcion valida para 'Desicion de Titular'"
        ];

        $rules = [

                'validacionSecretarios' => [
                        'required',
                        Rule::notIn([
                                '-1'
                        ])
                ]
        ];

        $encontrados = 0;
        $input = json_decode($request->arregloTablaCandidatos, true);

        $arregloMensajes = [];
        for ( $i = 0; $i < count($input); $i ++ ) {

            $arrayErrores = [];
            foreach ( $input[$i] as $key => $value ) {
                if ( $value == 'ACEPTADO' ) {

                    $encontrados ++;
                }
                $arrayErrores[$key] = $value;
            }

            $validator = Validator::make($arrayErrores, $rules)->passes();
            $arregloMensajes[$i] = $validator;
            $arregloMensajes['mensajesForm' . $i] = Validator::make($arrayErrores, $rules, $messages);
        }
        if ( $encontrados > 1 ) {

            $arregloMensajes = [];
            $arregloMensajes[0] = false;
            $arregloMensajes['mensajesForm0'] = array(
                    "No puede Aceptar a dos Candidatos"
            );
        }
        else {
            if ( count($arregloMensajes) > 2 ) {
                $formValido = ((($arregloMensajes[0] + $arregloMensajes[1] == 0) ? false : $arregloMensajes[0] +
                        $arregloMensajes[1] == 1) ? false : true);
                $arregloMensajes['validos'] = $formValido;
            }
            else {
                $arregloMensajes['validos'] = $arregloMensajes[0];
            }
        }

        return $arregloMensajes;

    }

    public function validarFormT05 ( Request $request )
    {

        $messages = [
                'comentarioDga.required' => 'El campo Comentarios no puede estar vacio'
        ];

        $rules = [

                'comentarioDga' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator->validate();

    }

    public function validarFormT06 ( Request $request )
    {

        $messages = [
                'aceptacion_srio.required' => 'El campo no pude estar vacio'
        ];

        $rules = [
                'aceptacion_srio' => [
                        'required',
                        Rule::notIn([
                                '-1',
                                ''
                        ])
                ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator->validate();

    }

    public function validarFormT07 ( Request $request )
    {

        $messages = [
                'fecha_alta.required' => 'El campo no pude estar vacio',
                'fecha_alta.date' => 'La fecha no es valida'
        ];

        $rules = [
                'fecha_alta' => [
                        'required',
                        'date_format:d/m/Y'
                ]
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator->validate();

    }

    public function crearInstanciaSeleccionCandidatos ($candidatoEstructura)
    {
        $proceso = Proceso::select('proceso_id')
                        ->where('nombre', 'Selección de candidatos de personal de estructura')
                        ->first();

        return $this->crearInstancia($proceso, $candidatoEstructura, 'INICIO');
    }

    public function actualizarEstatusTarea ( $instanciaTarea, $estatus )
    {

        $instanciaTarea->estatus = $estatus;
        return $instanciaTarea->save();

    }

    public function crearFolio($instancia, $intanciaTarea) {
        $instancia->folio  = $this->crearFolioProceso($instancia->instancia_id, $intanciaTarea->id);
        return $instancia->save();
    }

}
