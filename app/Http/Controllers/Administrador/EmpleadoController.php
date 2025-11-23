<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alfabetico;
use App\Models\AlfabeticoArchivo;
use App\Models\Area;
use App\Models\UnidadAdministrativa;
use App\Models\Empleado;
use App\Models\Plaza;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EmpleadoController extends Controller
{
    protected $claves = [
        'sector',
        'unidad_administrativa',
        'numero_empleado',
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'nombre_completo',
        'rfc',
        'curp',
        'fecha_nacimiento',
        'sexo',
        'subunidad',
        'direccion_administrativa',
        'subdireccion',
        'jud',
        'oficina',
        'nomina',
        'codigo_universo',
        'nivel_salarial',
        'codigo_puesto',
        'puesto',
        'seccion_sindical',
        'codigo_situacion_empleado',
        'numero_plaza',
        'fecha_alta_empleado',
        'fecha_antiguedad',
        'codigo_turno',
        'zona_pagadora',
        'ssn',
        'dias_trabajados',
        'codigo_regimen_issste',
        'acct_no',
        'banco',
        'sueldo_bruto',
        'deducciones',
        'sueldo_neto',
        'hijos',
    ];

    public function index() {
        // Se muestran los Alfabéticos (Directorios) cargados
        $alfabeticos = Alfabetico::where('estatus', '!=', 'CANCELADO')->orderBy('quincena', 'desc')->get();

        // Agregamos el campo 'fecha_acomodo' para poner el listado descendente
        foreach ($alfabeticos as $key => $alfabetico) {
            // Si ya tiene la quincena capturada
            if ($alfabetico->quincena) {
                $cadena = $alfabetico->quincena;
                // Dividir la cadena en partes usando la coma como separador
                $partes = explode(", ", $cadena);
                // Obtener la segunda parte que contiene "16/05/2023 - 31/05/2023" (Ejemplo)
                $segundaParte = $partes[1];
                // Dividir la segunda parte en partes nuevamente usando el guion como separador
                $fechas = explode(" - ", $segundaParte);
                // Obtener la primera fecha que es "16/05/2023"
                $fechaInicio = $fechas[0];
                // Agregar el campo
                $alfabetico->fecha_acomodo = Carbon::createFromFormat('d/m/Y', $fechaInicio);
            } else {
                $alfabetico->fecha_acomodo = Carbon::now();
            }
        }

        $alfabeticos = $alfabeticos->sortByDesc('fecha_acomodo');

        // Para que no genere conflictos con JavaScript se reasigana y acomodado las pocisiones del Array
        $arrayTemporal = [];
        $indice = 0;
        foreach ($alfabeticos as $alfabetico) {
            $arrayTemporal[$indice] = $alfabetico; // Asignamos el elemento con el nuevo índice
            $indice++;
        }

        // Obtenemos sus relaciones
        foreach ($alfabeticos as $key => $alfabetico) {
            if ($alfabetico->archivoSinJson()->exists()) $alfabetico->archivoSinJson->cargadoPorUsuario;
        }

        // Finalmente regresamos el array ordenado y acomodado a alfabeticos
        $alfabeticos = $arrayTemporal;

        // Se muestran la lista mas actual de los Empleados
        $empleados = Empleado::select('*')->orderBy('apellido_paterno', 'asc')->with("area")->get();

        return view('administrador.empleados.index', compact('alfabeticos', 'empleados'));
    }

    public function iniciar(Request $request)
    {
        if (Alfabetico::where('estatus', 'EN_PROCESO')->exists()) {
            $mensaje = '¡Hay un Alfabético en proceso, debes concluir la carga o cancelar para agregar uno nuevo!';
            return redirect()
                    ->back()
                    ->with("error", $mensaje);
        } else {
            // Crear registro del Directorio
            $alfabetico = Alfabetico::create([
                "estatus" => "EN_PROCESO"
            ]);
            // Redirigir a Cargar Alfabético
            return  redirect()
                    ->route('alfabetico.carga.alfabetico', [$alfabetico]);
        }
    }

    /**
     * Cargar Alfabético
    */
    public function cargarAlfabetico(Request $request, Alfabetico $alfabetico) {
        $archivos = $alfabetico->archivo;

        if ($request->isMethod('post')) {
            // Cancelar proceso
            if ($request->accion == "cancelar") {
                $alfabetico->update(["estatus" => "CANCELADO"]);
                return redirect()->route("alfabetico.index")
                    ->with("success", "La carga se canceló correctamente.");
            }
            // Guarda los datos y finaliza la carga
            $carga = $this->guardarDatosAlfabeticoEmpleados($alfabetico, $request);
            if ($carga['estatus']) {
                // Enviar mensaje de confirmación.
                return redirect()->route('alfabetico.index')->with('success', $carga['mensaje']);
            } else {
                // Si surgen errores los regresa
                return redirect()
                        ->back()
                        ->with("error", $carga['mensaje']);
            }
        }

        return view('administrador.empleados.cargaAlfabetico', compact('alfabetico', 'archivos'));
    }

    /**
     * Guardar TXT
    */
    public function cargarAlfabeticoGuardarTXT(Request $request, Alfabetico $alfabetico) {
        $archivo = $this->guardarTxtConEmpleados($alfabetico, $request);
        if ( $archivo['estatus'] ) {
            return response()->json([
                'estatus' => $archivo['estatus'],
                'mensaje' => $archivo['mensaje'],
                'archivo' => $archivo['data'],
            ]);
        } else {
            return response()->json([
                'estatus' => $archivo['estatus'],
                'mensaje' => $archivo['mensaje'],
            ]);
        }
    }

    /**
     * Eliminar TXT
    */
    public function eliminarTXTArchivo(Request $request) {
        try {
            $txtArchivo = AlfabeticoArchivo::find($request->archivo_id);

            if ($txtArchivo) {
                $txtArchivo->delete();
            }
            $respuesta = [
                'estatus' => true,
                'mensaje' => '¡Archivo eliminado exitosamente!'
            ];
            return response()->json($respuesta);
        } catch (\Throwable $th) {
            $respuesta = [
                'estatus' => false,
                'mensaje' => '¡Ocurrió un error, Intente más tarde!',
                'data' => $th
            ];
            return response()->json($respuesta);
        }
    }

    /**
     * Editar Empleado
    */
    public function editarEmpleado(Request $request, Empleado $empleado) {

        if ($request->isMethod('post')) {
            // Guarda los datos
            $carga = $this->editarDatosEmpleado($empleado, $request);
            if ($carga['estatus']) {
                // Enviar mensaje de confirmación.
                return redirect()->back()->with('success', $carga['mensaje']);
            } else {
                // Si surgen errores los regresa
                return redirect()
                        ->back()
                        ->with("error", $carga['mensaje']);
            }
        }
        $areas = Area::activo()->orderByRaw('identificador::FLOAT')->get();
        return view('administrador.empleados.editarEmpleado', compact("empleado", "areas"));
    }

    /**
     * Método encargado de guardar el TXT
     * @param object $alfabetico
     * @param object $request (files, txt)
     */
    public function guardarTxtConEmpleados($alfabetico, $request) {
        $user = Auth::user();
        try {
            // Validamos si llega el archivo
            if ( $request->hasFile('file') ) {

                // Se obtiene el archivo TXT cargado
                $archivo        = $request->file('file')[0];
                $archivoNombre  = $archivo->getClientOriginalName();
                // Se obtienen su contenido
                $contenido  = $archivo->get();
                // Se divide por renglones que tiene el TXT
                $renglones  = explode("\n", $contenido);
                // Declaro un array donde se guardaran los datos
                $archivoTXT = [];

                // Se recorre cada renglon
                foreach ($renglones as $renglon) {
                    // El renglon lo dividimos por cada celda o campo
                    $renglonSeparado = explode("'", $renglon);
                    // Aquí se valida el tamaño del renglon, esto permite revisar que el Arhivo TXT tenga la estructura de un Alfábetico
                    if ( count($renglonSeparado) < 37 ) {
                        $respuesta = [
                            'estatus' => false,
                            'mensaje' => '¡El archivo no cumple con la estructura del alfábetico!',
                        ];
                        return $respuesta;
                    }
                    // Declaro un array donde guardar este nuevo renglo ya como array con su clave y valor
                    $renglonTexto = [];
                    foreach ($renglonSeparado as $key => $texto) {
                        // Al texto le sustituimos comillas dobles por simples y le quitamos los espacios
                        $textoSinComillas = str_replace('"', "'", $texto);
                        $textoEscaped = json_encode(trim($textoSinComillas), JSON_HEX_QUOT);
                        $renglonTexto[$this->claves[$key]] = $textoEscaped;
                    }
                    // Finalmente lo agregamos al array
                    array_push($archivoTXT, $renglonTexto);
                }
                // Ya generado el Array con los renglones se codifica a JSON
                $cantidadTXT = count($archivoTXT);
                $resultadoTXT = json_encode($archivoTXT);

                $existeArchivo = AlfabeticoArchivo::where('alfabetico_id', $alfabetico->alfabetico_id)->exists();
                if ( $existeArchivo ) {
                    AlfabeticoArchivo::where('alfabetico_id', $alfabetico->alfabetico_id)->update([
                        'empleados' => $resultadoTXT,
                        'nombre_archivo' => $archivoNombre,
                        'fecha_carga' => Carbon::now()->format('Y-m-d'),
                        'cantidad_empleados' => $cantidadTXT,
                        'cargado_por_usuario' => $user->id,
                        'area_id' => $user->area->area_id,
                    ]);
                    $archivoEmpleados = AlfabeticoArchivo::where('alfabetico_id', $alfabetico->alfabetico_id)->first();
                } else {
                    $archivoEmpleados = AlfabeticoArchivo::create([
                        'alfabetico_id' => $alfabetico->alfabetico_id,
                        'empleados' => $resultadoTXT,
                        'nombre_archivo' => $archivoNombre,
                        'fecha_carga' => Carbon::now()->format('Y-m-d'),
                        'cantidad_empleados' => $cantidadTXT,
                        'cargado_por_usuario' => $user->id,
                        'area_id' => $user->area->area_id,
                    ]);
                }
                // Finalmente se crea y guarda en el la tabla de archivos del p24
                $respuesta = [
                    'estatus' => true,
                    'mensaje' => '!Archivo cargado exitosamente¡',
                    'data' => $archivoEmpleados
                ];
                return $respuesta;
            } else {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡No se envío correctamente el archivo!',
                ];
                return $respuesta;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $respuesta = [
                'estatus' => false,
                'mensaje' => '!Error al guardar archivo, intente más tarde¡',
            ];
            return $respuesta;
        }


    }

    public function guardarDatosAlfabeticoEmpleados($alfabetico, $request) {

        $existeQuincena = Alfabetico::where('quincena', $request->quincena)->whereIn('estatus', ['EN_PROCESO', 'COMPLETADO'])->exists();
        if ( $existeQuincena ) {
            $respuesta = [
                'estatus' => false,
                'mensaje' => '¡Esa quincena ya fue capturada, seleccione otra!',
            ];
            return $respuesta;
        } else {
            // Antes de actualizar los campos de la Tabla Empleados con los datos del archivo Alfabético se deben validar varias cosas:
            // Si la Tabla Empleados esta vacia se llena toda la tabla con el primer Alfabético que se cargue y se liga con su plaza validando su "numero_plaza" y esos registos tanto empleados como plazas pasan a ser "activos" = true
            if ( $this->validarQuincena($request->quincena, $alfabetico->archivo) ) {
                $actualizado = $alfabetico->update([
                    'estatus' => 'COMPLETADO',
                    'quincena' => $request->quincena
                ]);
                if ( $actualizado ) {
                    $respuesta = [
                        'estatus' => true,
                        'mensaje' => '!La carga se realizo correctamente¡',
                    ];
                    return $respuesta;
                } else {
                    $respuesta = [
                        'estatus' => false,
                        'mensaje' => '¡Error al actualizar la quiencena en el Directorio!',
                    ];
                    return $respuesta;
                }
            } else {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡Error al actualizar el Alfabético de empleados!',
                ];
                return $respuesta;
            }
        }

    }

    /**
     * Método encargado de validar si la quincena es la más actual
     * @param object $alfabetico
     * @param object $request (quincena, archivo)
     */
    public function validarQuincena($quincena, $archivo) {

        $rolesSistema = ["SUPER_ADMIN"];
        // Se obtiene el Json del archivo
        $empleados = json_decode($archivo->empleados);

        try {
            // Iniciamos obteniendo con pluck, ya que ayuda a obtener el campo como arreglo y no como objeto
            $quincenas = Alfabetico::where('estatus', 'COMPLETADO')->pluck('quincena')->toArray();
            // Despúes se ingresa la quincena que viene al arreglo
            array_push($quincenas, $quincena);
            // Esta funcion regresa las quincenas ordenadas en el mismo arreglo
            usort($quincenas, 'compararQuincenas');
            // Ya que se acomodaron las quincenas anteriores con la nueva, obtenemos el último elemento del arreglo
            $ultimaQuincenaCargada = end($quincenas);
            // Si la ultima quincena es la misma que se esta capturando, indica que es la ultima consecutiva y se procede a realizar la actualización de Empleados y Plazas
            if ( $ultimaQuincenaCargada === $quincena ) {
                // Primero regresamos las Plazas a "activo" = false
                Plaza::query()->update(['activo' => false]);
                // Segundo regresamos los Empleados a "activo" = false y "plazas_id" a null
                Empleado::query()->update(['activo' => false, 'plaza_id' => null]);
                // Tercero regresamos los Usuarios a "activo" = false, excepto al SUPER_ADMIN, despues se valdiara si los que si vengan en el Alfabetico se Reactivan
                $usuarios = User::all();
                foreach ($usuarios as $key => $usuario) {
                    if ( $usuario->empleado()->exists() ) {
                        $usuario->update(['activo' => false]);
                    }
                }
                // Ahora recorremos el archivo actualizando los registros ya existentes y actualizando donde aplique
                foreach ($empleados as $key => $empleado) {

                    // Obtenemos la Plaza a traves del "numero_plaza" que tiene el Empleado para ligarlos
                    $plaza = Plaza::where('numero_plaza', json_decode($empleado->numero_plaza))->first();
                    // Validamos la Unidad Administrativa del empleado
                    $unidadAdm = UnidadAdministrativa::where('identificador', $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)))->first();
                    // Si la plaza es nueva y no existe en la tabla de plazas la damos de alta antes de seguir con la creación o actualización del Empleado
                    if ( !$plaza ) {
                        $plaza = Plaza::create([
                            'numero_plaza' => json_decode($empleado->numero_plaza),
                            'unidad_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)),
                            'subunidad' => $this->quitarCerosIzquierda(json_decode($empleado->subunidad)),
                            'direccion_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->direccion_administrativa)),
                            'subdireccion' => $this->quitarCerosIzquierda(json_decode($empleado->subdireccion)),
                            'jud' => $this->quitarCerosIzquierda(json_decode($empleado->jud)),
                            'oficina' => $this->quitarCerosIzquierda(json_decode($empleado->oficina)),
                            'codigo_puesto' => json_decode($empleado->codigo_puesto),
                            'nivel_salarial' => $this->quitarCerosIzquierda(json_decode($empleado->nivel_salarial)),
                            'codigo_universo' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_universo)),
                            'puesto' => json_decode($empleado->puesto),
                            'codigo_situacion_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_situacion_empleado)),
                            'last_modified' => Carbon::now()->format('Y-m-d'),
                        ]);
                    }

                    // Ahora si, validamos si el Empleado ya existe en el nuevo archivo a través de su "numero_empleado"
                    $empleadoAActualizarOCrear = Empleado::where('numero_empleado', $this->quitarCerosIzquierda(json_decode($empleado->numero_empleado)))->first();
                    // Si ya existe el Empleado en la tabla se actualizan sus datos
                    if ( $empleadoAActualizarOCrear ) {
                        // Obtenemos el campo de quincenas_activas
                        $quincenasActivasJson = $empleadoAActualizarOCrear->quincenas_activo;
                        // Lo decodificamos
                        $quincenasArray = json_decode($quincenasActivasJson);
                        // Validamos si existen datos de este empleado
                        $quincenasActivasArray = $quincenasArray == null ? array() : $quincenasArray;
                        // Validamos que esa quincena no exista en el Array
                        if ( !in_array($quincena, $quincenasActivasArray) ) {
                            // Agreamos la nueva quincena al Array
                            array_push($quincenasActivasArray, $quincena);
                            // Usamos la funcion que regresa las quincenas ordenadas en el mismo arreglo y usamos ese array para actualizar el campo 'quincenas_activo'
                            usort($quincenasActivasArray, 'compararQuincenas');
                        }
                        // A los campos se les decodifica y en caso de los numeros que tienen ceros a la izquierda se eliminan
                        $empleadoAActualizarOCrear->update([
                            'plaza_id' => isset($plaza) ? $plaza->plaza_id : null,
                            'sector' => $this->quitarCerosIzquierda(json_decode($empleado->sector)),
                            'unidad_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)),
                            'numero_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->numero_empleado)),
                            'apellido_paterno' => json_decode($empleado->apellido_paterno),
                            'apellido_materno' => json_decode($empleado->apellido_materno),
                            'nombre' => json_decode($empleado->nombre),
                            'nombre_completo' => json_decode($empleado->nombre_completo),
                            'rfc' => json_decode($empleado->rfc),
                            'curp' => json_decode($empleado->curp),
                            'fecha_nacimiento' => $this->fechasEstructura($empleado->fecha_nacimiento),
                            'sexo' => json_decode($empleado->sexo),
                            'subunidad' => $this->quitarCerosIzquierda(json_decode($empleado->subunidad)),
                            'direccion_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->direccion_administrativa)),
                            'subdireccion' => $this->quitarCerosIzquierda(json_decode($empleado->subdireccion)),
                            'jud' => $this->quitarCerosIzquierda(json_decode($empleado->jud)),
                            'oficina' => $this->quitarCerosIzquierda(json_decode($empleado->oficina)),
                            'nomina' => $this->quitarCerosIzquierda(json_decode($empleado->nomina)),
                            'codigo_universo' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_universo)),
                            'nivel_salarial' => $this->quitarCerosIzquierda(json_decode($empleado->nivel_salarial)),
                            'codigo_puesto' => json_decode($empleado->codigo_puesto),
                            'puesto' => json_decode($empleado->puesto),
                            'seccion_sindical' => $this->quitarCerosIzquierda(json_decode($empleado->seccion_sindical)),
                            'codigo_situacion_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_situacion_empleado)),
                            'numero_plaza' => json_decode($empleado->numero_plaza),
                            'fecha_alta_empleado' => $this->fechasEstructura($empleado->fecha_alta_empleado),
                            'fecha_antiguedad' => $this->fechasEstructura($empleado->fecha_antiguedad),
                            'codigo_turno' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_turno)),
                            'zona_pagadora' => $this->quitarCerosIzquierda(json_decode($empleado->zona_pagadora)),
                            'ssn' => json_decode($empleado->ssn),
                            'dias_trabajados' => $this->quitarCerosIzquierda(json_decode($empleado->dias_trabajados)),
                            'codigo_regimen_issste' => json_decode($empleado->codigo_regimen_issste),
                            'acct_no' => $this->quitarCerosIzquierda(json_decode($empleado->acct_no)),
                            'banco' => json_decode($empleado->banco),
                            'sueldo_bruto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_bruto)),
                            'deducciones' => $this->quitarCerosIzquierda(json_decode($empleado->deducciones)),
                            'sueldo_neto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_neto)),
                            'hijos' => $this->quitarCerosIzquierda(json_decode($empleado->hijos)),
                            'unidad_administrativa_nombre' => isset($unidadAdm) ? $unidadAdm->nombre : null,
                            'activo' => true,
                            'quincenas_activo' => json_encode($quincenasActivasArray),
                        ]);

                    } else {
                        $quincenasArray = [];
                        array_push($quincenasArray, $quincena);
                        // Si aún no existe el empleado en este nuevo archivo se creara, ya que indica que este nuevo archivo trae empleados nuevos
                        // A los campos se les decodifica y en caso de los numeros que tienen ceros a la izquierda se eliminan
                        $empleadoAActualizarOCrear =Empleado::create([
                            'plaza_id' => isset($plaza) ? $plaza->plaza_id : null,
                            'sector' => $this->quitarCerosIzquierda(json_decode($empleado->sector)),
                            'unidad_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)),
                            'numero_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->numero_empleado)),
                            'apellido_paterno' => json_decode($empleado->apellido_paterno),
                            'apellido_materno' => json_decode($empleado->apellido_materno),
                            'nombre' => json_decode($empleado->nombre),
                            'nombre_completo' => json_decode($empleado->nombre_completo),
                            'rfc' => json_decode($empleado->rfc),
                            'curp' => json_decode($empleado->curp),
                            'fecha_nacimiento' => $this->fechasEstructura($empleado->fecha_nacimiento),
                            'sexo' => json_decode($empleado->sexo),
                            'subunidad' => $this->quitarCerosIzquierda(json_decode($empleado->subunidad)),
                            'direccion_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->direccion_administrativa)),
                            'subdireccion' => $this->quitarCerosIzquierda(json_decode($empleado->subdireccion)),
                            'jud' => $this->quitarCerosIzquierda(json_decode($empleado->jud)),
                            'oficina' => $this->quitarCerosIzquierda(json_decode($empleado->oficina)),
                            'nomina' => $this->quitarCerosIzquierda(json_decode($empleado->nomina)),
                            'codigo_universo' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_universo)),
                            'nivel_salarial' => $this->quitarCerosIzquierda(json_decode($empleado->nivel_salarial)),
                            'codigo_puesto' => json_decode($empleado->codigo_puesto),
                            'puesto' => json_decode($empleado->puesto),
                            'seccion_sindical' => $this->quitarCerosIzquierda(json_decode($empleado->seccion_sindical)),
                            'codigo_situacion_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_situacion_empleado)),
                            'numero_plaza' => json_decode($empleado->numero_plaza),
                            'fecha_alta_empleado' => $this->fechasEstructura($empleado->fecha_alta_empleado),
                            'fecha_antiguedad' => $this->fechasEstructura($empleado->fecha_antiguedad),
                            'codigo_turno' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_turno)),
                            'zona_pagadora' => $this->quitarCerosIzquierda(json_decode($empleado->zona_pagadora)),
                            'ssn' => json_decode($empleado->ssn),
                            'dias_trabajados' => $this->quitarCerosIzquierda(json_decode($empleado->dias_trabajados)),
                            'codigo_regimen_issste' => json_decode($empleado->codigo_regimen_issste),
                            'acct_no' => $this->quitarCerosIzquierda(json_decode($empleado->acct_no)),
                            'banco' => json_decode($empleado->banco),
                            'sueldo_bruto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_bruto)),
                            'deducciones' => $this->quitarCerosIzquierda(json_decode($empleado->deducciones)),
                            'sueldo_neto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_neto)),
                            'hijos' => $this->quitarCerosIzquierda(json_decode($empleado->hijos)),
                            'unidad_administrativa_nombre' => isset($unidadAdm) ? $unidadAdm->nombre : null,
                            'activo' => true,
                            'quincenas_activo' => json_encode($quincenasArray)
                        ]);

                    }

                    // Despues de Actualizar o Crear al Empleado Validamos si tiene un Usario Creado
                    $usuarioEmpleado = User::where('numero_empleado', $empleadoAActualizarOCrear->numero_empleado)
                                            ->where('rfc', $empleadoAActualizarOCrear->rfc)
                                            ->where('curp', $empleadoAActualizarOCrear->curp)
                                            ->exists();
                    // Si tiene, se activa nuevamente su Usuario y Se Actualiza si relación
                    if ( $usuarioEmpleado ) {
                        $usuario =  User::where('numero_empleado', $empleadoAActualizarOCrear->numero_empleado)
                            ->where('rfc', $empleadoAActualizarOCrear->rfc)
                            ->where('curp', $empleadoAActualizarOCrear->curp)
                            ->first();
                        $usuario->update([
                            'activo' => true,
                            'empleado_id' => $empleadoAActualizarOCrear->empleado_id
                        ]);
                    }
                    // Despues de Actualizar o Crear al Empleado se coloca como "activo" = true a la Plaza también
                    if ( $plaza ) {
                        $plaza->update(['activo' => true]);
                    }

                }
                return true;
            } else {
                // Si no es la última no se actualiza Información General del Empleado como datos y Plaza, pero se valida si el Empleado aparece en esa Quincena para actualizar el campo de "quincenas_activo" y llevar el control de las quincenas donde si aparece
                foreach ($empleados as $key => $empleado) {
                    // Obtenemos al empleado
                    $empleadoAActualizarOCrear = Empleado::where('numero_empleado', $this->quitarCerosIzquierda(json_decode($empleado->numero_empleado)))->first();
                    // Si ya existe el Empleado en la tabla se actualizan sus datos
                    if ( $empleadoAActualizarOCrear ) {
                        // Obtenemos el campo de quincenas_activas
                        $quincenasActivasJson = $empleadoAActualizarOCrear->quincenas_activo;
                        // Lo decodificamos
                        $quincenasArray = json_decode($quincenasActivasJson);
                        // Validamos si existen datos de este empleado
                        $quincenasActivasArray = $quincenasArray == null ? array() : $quincenasArray;
                        // Validamos que esa quincena no exista en el Array
                        if ( !in_array($quincena, $quincenasActivasArray )) {
                            // Si aún no existe la quincena, Agreamos la nueva quincena al Array
                            array_push($quincenasActivasArray, $quincena);

                            // Usamos la funcion que regresa las quincenas ordenadas en el mismo arreglo
                            usort($quincenasActivasArray, 'compararQuincenas');

                            // Y finalmente actualizamos al Empleado, ya que indicaria que este empledo estaba activo en esa quincena (Alfabético)
                            $empleadoAActualizarOCrear->update([ 'quincenas_activo' => json_encode($quincenasActivasArray) ]);
                        }
                    } else {
                        // Validamos la Unidad Administrativa del empleado
                        $unidadAdm = UnidadAdministrativa::where('identificador', $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)))->first();
                        // Si hay un nuevo empleado se crea sin activar ni ligar nada
                        $quincenasArray = [];
                        array_push($quincenasArray, $quincena);

                        Empleado::create([
                            'plaza_id' => null,
                            'sector' => $this->quitarCerosIzquierda(json_decode($empleado->sector)),
                            'unidad_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)),
                            'numero_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->numero_empleado)),
                            'apellido_paterno' => json_decode($empleado->apellido_paterno),
                            'apellido_materno' => json_decode($empleado->apellido_materno),
                            'nombre' => json_decode($empleado->nombre),
                            'nombre_completo' => json_decode($empleado->nombre_completo),
                            'rfc' => json_decode($empleado->rfc),
                            'curp' => json_decode($empleado->curp),
                            'fecha_nacimiento' => $this->fechasEstructura($empleado->fecha_nacimiento),
                            'sexo' => json_decode($empleado->sexo),
                            'subunidad' => $this->quitarCerosIzquierda(json_decode($empleado->subunidad)),
                            'direccion_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->direccion_administrativa)),
                            'subdireccion' => $this->quitarCerosIzquierda(json_decode($empleado->subdireccion)),
                            'jud' => $this->quitarCerosIzquierda(json_decode($empleado->jud)),
                            'oficina' => $this->quitarCerosIzquierda(json_decode($empleado->oficina)),
                            'nomina' => $this->quitarCerosIzquierda(json_decode($empleado->nomina)),
                            'codigo_universo' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_universo)),
                            'nivel_salarial' => $this->quitarCerosIzquierda(json_decode($empleado->nivel_salarial)),
                            'codigo_puesto' => json_decode($empleado->codigo_puesto),
                            'puesto' => json_decode($empleado->puesto),
                            'seccion_sindical' => $this->quitarCerosIzquierda(json_decode($empleado->seccion_sindical)),
                            'codigo_situacion_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_situacion_empleado)),
                            'numero_plaza' => json_decode($empleado->numero_plaza),
                            'fecha_alta_empleado' => $this->fechasEstructura($empleado->fecha_alta_empleado),
                            'fecha_antiguedad' => $this->fechasEstructura($empleado->fecha_antiguedad),
                            'codigo_turno' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_turno)),
                            'zona_pagadora' => $this->quitarCerosIzquierda(json_decode($empleado->zona_pagadora)),
                            'ssn' => json_decode($empleado->ssn),
                            'dias_trabajados' => $this->quitarCerosIzquierda(json_decode($empleado->dias_trabajados)),
                            'codigo_regimen_issste' => json_decode($empleado->codigo_regimen_issste),
                            'acct_no' => $this->quitarCerosIzquierda(json_decode($empleado->acct_no)),
                            'banco' => json_decode($empleado->banco),
                            'sueldo_bruto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_bruto)),
                            'deducciones' => $this->quitarCerosIzquierda(json_decode($empleado->deducciones)),
                            'sueldo_neto' => $this->quitarCerosIzquierda(json_decode($empleado->sueldo_neto)),
                            'hijos' => $this->quitarCerosIzquierda(json_decode($empleado->hijos)),
                            'unidad_administrativa_nombre' => isset($unidadAdm) ? $unidadAdm->nombre : null,
                            'activo' => false,
                            'quincenas_activo' => json_encode($quincenasArray)
                        ]);
                    }
                }
                // Despues de regresa la respuesta
                return true;
            }

        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Método encargado de crear la estructura de las fechas ya que esta como cadena
     * @param object $alfabetico
     * @param object $request (fechas)
     */
    public function fechasEstructura($fecha) {
        $fechaCadena = date_create_from_format("dmY", json_decode($fecha));
        if ($fechaCadena) {
            return date_format($fechaCadena, "d-m-Y");
        } else {
            return "";
        }
    }

    /**
     * Método encargado de quitar los ceros
     * @param object $alfabetico
     * @param object $request (cadena)
     */
    function quitarCerosIzquierda($cadena) {
        // Elimina los ceros a la izquierda y cualquier otro carácter no numérico
        $cadena = ltrim($cadena, '0');
        // Verifica si la cadena está vacía después de quitar los ceros
        if ($cadena === '') {
            return '0'; // Si la cadena resultante está vacía, devuelve '0'
        } else {
            return $cadena;
        }

    }

    public function editarDatosEmpleado($empleado, $request) {

        /* dd($request->all()); */

        // Si el Switch indica que se va a "Activar"
        if ( $request->activo ) {
            // Se busca la plaza
            $plaza = Plaza::where('numero_plaza', $empleado->numero_plaza)->first();
            // Si la plaza es nueva y no existe en la tabla de plazas la damos de alta antes de seguir con la creación o actualización del Empleado
            if ( !$plaza ) {
                $plaza = Plaza::create([
                    'numero_plaza' => json_decode($empleado->numero_plaza),
                    'unidad_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->unidad_administrativa)),
                    'subunidad' => $this->quitarCerosIzquierda(json_decode($empleado->subunidad)),
                    'direccion_administrativa' => $this->quitarCerosIzquierda(json_decode($empleado->direccion_administrativa)),
                    'subdireccion' => $this->quitarCerosIzquierda(json_decode($empleado->subdireccion)),
                    'jud' => $this->quitarCerosIzquierda(json_decode($empleado->jud)),
                    'oficina' => $this->quitarCerosIzquierda(json_decode($empleado->oficina)),
                    'codigo_puesto' => json_decode($empleado->codigo_puesto),
                    'nivel_salarial' => $this->quitarCerosIzquierda(json_decode($empleado->nivel_salarial)),
                    'codigo_universo' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_universo)),
                    'puesto' => json_decode($empleado->puesto),
                    'codigo_situacion_empleado' => $this->quitarCerosIzquierda(json_decode($empleado->codigo_situacion_empleado)),
                    'last_modified' => Carbon::now()->format('Y-m-d'),
                ]);
            }
            // Se actualiza el empleado
            $actualizadoE = $empleado->update([
                'plaza_id' => $plaza->plaza_id,
                'activo' => true,
                'area_id' => $request->area_id
            ]);

            // Despues se actualiza la plaza
            $actualizadoP = $plaza->update(['activo' => true]);

            // Validamos si el Empleado ya tiene un Usuario Creado
            $usuarioEmpleado = User::where('numero_empleado', $empleado->numero_empleado)
                                    ->where('rfc', $empleado->rfc)
                                    ->where('curp', $empleado->curp)
                                    ->exists();
            if ( $usuarioEmpleado ) {
                // Si tiene al momento de activar al Empleado Activamos su Usuario
                $usuario =  User::where('numero_empleado', $empleado->numero_empleado)
                            ->where('rfc', $empleado->rfc)
                            ->where('curp', $empleado->curp)
                            ->first();
                $usuario->update([
                    'empleado_id' => $empleado->empleado_id,
                    'activo' => true,
                ]);
            }

            if ( $actualizadoE && $actualizadoP ) {
                $respuesta = [
                    'estatus' => true,
                    'mensaje' => '!Los datos del empleado se actualizaron correctamente¡',
                ];
                return $respuesta;
            } else {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡Error al actualizar los datos del empleado!',
                ];
                return $respuesta;
            }
        } else {
            // Se busca la plaza
            $plaza = Plaza::where('numero_plaza', $empleado->numero_plaza)->first();
            // Se actualiza el empleado
            $actualizadoE = $empleado->update([
                'plaza_id' => null,
                'activo' => false,
            ]);
            // Despues se actualiza la plaza
            $actualizadoP = $plaza->update(['activo' => false]);
            // Validamos si el Empleado ya tiene un Usuario Creado
            $usuarioEmpleado = User::where('numero_empleado', $empleado->numero_empleado)
                                    ->where('rfc', $empleado->rfc)
                                    ->where('curp', $empleado->curp)
                                    ->exists();
            if ( $usuarioEmpleado ) {
                // Si tiene al momento de activar al Empleado Activamos su Usuario
                $usuario =  User::where('numero_empleado', $empleado->numero_empleado)
                            ->where('rfc', $empleado->rfc)
                            ->where('curp', $empleado->curp)
                            ->first();
                $usuario->update([
                    'empleado_id' => $empleado->empleado_id,
                    'activo' => false,
                ]);
            }

            if ( $actualizadoE && $actualizadoP ) {
                $respuesta = [
                    'estatus' => true,
                    'mensaje' => '!Los datos del empleado se actualizaron correctamente¡',
                ];
                return $respuesta;
            } else {
                $respuesta = [
                    'estatus' => false,
                    'mensaje' => '¡Error al actualizar los datos del empleado!',
                ];
                return $respuesta;
            }
        }

    }

    public function getEmpleados(Request $request) {
        $rolesSistema = ["SUPER_ADMIN", "CONTROL_ASISTENCIA", "CTRL_KDX", "CAPT_KDX", "KARDEX", "OPER_TIEMPO_EXTRA", "OPER_DIG_23", "OPER_PA_21", "ADMN_PA_21"];
        $rolesUnidad = ["SUB_EA", "OPER_PREMIO_PUNTUALIDAD", "INI_JUST", "OPER_INC_19", "OPER_PA_21", "ADMN_PA_21", "ADMN_REP_22", "JUD_RH", "ENLACE_TIEMPO_EXTRA", "ENLACE_PREMIO_PUNTUALIDAD"];

        if (Auth::user()->hasRole($rolesSistema)) {
            $empleados = Empleado::where(function ($query) use ($request) {
                    $query->orWhere(DB::raw('upper("rfc")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                        ->orWhere(function ($query) use ($request) {
                            if (is_numeric($request->searchText)) {
                                $query->orWhere("numero_empleado", "LIKE", "%$request->searchText%");
                            };
                        });
                })
                ->orderBy('nombre')
                ->orderBy('apellido_paterno')
                ->orderBy('apellido_materno')
                ->get();                
        } else if (Auth::user()->hasRole($rolesUnidad)) {
            $empleados = Empleado::where(function ($query) {
                $query->where("unidad_administrativa", Auth::user()->area->unidadAdministrativa->identificador)
                    ->orWhereHas("area.unidadAdministrativa", function ($query) {
                        $query->where("identificador", Auth::user()->area->unidadAdministrativa->identificador);
                    });
            })->where(function ($query) use ($request) {
                $query->orWhere(DB::raw('upper("rfc")'), "LIKE", '%' . mb_strtoupper((string) $request->searchText) . '%')
                    ->orWhere(function ($query) use ($request) {
                        if (is_numeric($request->searchText)) {
                            $query->orWhere("numero_empleado", "LIKE", "%$request->searchText%");
                        };
                    });
            })
            ->orderBy('nombre')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->get();
        } else {
            $empleados = collect();
        }

        $empleados = $empleados->map(function ($item) {
            $item["id"] = json_encode($item);
            return $item;
        });

        return response()->json([
            "data" => $empleados
        ]);
    }
}
