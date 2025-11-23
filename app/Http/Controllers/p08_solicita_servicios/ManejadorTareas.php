<?php

namespace App\Http\Controllers\p08_solicita_servicios;

use App\Http\Traits\RegistroInstancias;

use App\Models\p08_solicita_servicios\Servicio;
use App\Models\p08_solicita_servicios\ServicioGeneral;
use App\Models\p08_solicita_servicios\P08SolicitaServicio;
use App\Models\p08_solicita_servicios\P08DetalleSolicitaServicio;
use App\Models\p08_solicita_servicios\P08Vehiculo;
use App\Models\p08_solicita_servicios\P08BitacoraRutaGas;
use App\Models\User;
use App\Models\Area;
use App\Models\Proceso;
use App\Models\UnidadAdministrativa;
use App\Models\Dependencia;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;

trait ManejadorTareas
{
    use RegistroInstancias;

    public function crearSolicitudServicio($tipo_servicio) {
        $servicioGeneral = ServicioGeneral::where('clave', $tipo_servicio)->where('activo', true)->first();

        $solicitaServicio = P08SolicitaServicio::create(["estatus" => "EN_PROCESO", "servicio_general_id" => $servicioGeneral->servicio_general_id, "tipo_tramite" => mb_strtoupper($servicioGeneral->nombre_servicio_general)]);

        $areaUser = Auth::user()->area;

        $area = Area::select('*')
                ->where('area_id', $areaUser->area_id )
                ->where('activo', true)
                ->latest()
                ->first();

        // Ingresa datos del área que recibira el servicio
        $solicitaServicio->area_id = $area->area_id;

        return $solicitaServicio;
    }

    /**
     * Método encargado de guardar la Selección del servicio solicitado.
     * Es la T01 del P08.
     * @param object $solicitaServicio
     * @param object $request
     * @return object $servicioSolicitado
     */
    public function guardarTareaT01($solicitaServicio, $request) {

        $usuario = Auth::user();

        // Ingresa datos del servicio
        $solicitaServicio->texto_solicitud = $request->texto_solicitud;
        $solicitaServicio->contacto_servicio = $request->contacto_servicio;
        $solicitaServicio->contacto_correo = $request->contacto_correo;
        $solicitaServicio->telefono_servicio = $request->telefono_servicio;
        $solicitaServicio->ext_servicio = $request->ext_servicio;
        $solicitaServicio->direccion_servicio = $request->direccion_servicio;
        $solicitaServicio->urgente = isset($request->urgente) ? true : false;

        $solicitaServicio->creado_por_usuario = $usuario->id;
        $solicitaServicio->creado_por_nombre_completo = $usuario->nombre .' '. $usuario->apellido_paterno .' '. $usuario->apellido_materno;

        $solicitaServicio->sub_area = $request->sub_area;
        $solicitaServicio->cantidad_solicitud = isset($request->cantidad_solicitud) ? $request->cantidad_solicitud : null;
        $solicitaServicio->aceptado = true;

        // Ingresa datos del servicio solicitado
        $solicitaServicio->servicio_general_id = $request->servicio_general_id;
        $solicitaServicio->servicio_id = isset($request->tipo_servicio_id) ? $request->tipo_servicio_id : null;

        return $solicitaServicio->save();
    }

    /**
     * Método encargado de guardar las imagenes del servicio solicitado.
     * Es la T01 del P08.
     * @param object $solicitaServicio
     * @param object $request (files, imagenes)
     * @return object $servicioSolicitado
     */
    public function guardarImagenesTareaT01($solicitaServicio, $request) {

        try {
            $imagenesSolicitudServicio = [];
            // Validamos si llegaron las imagenes
            if ( $request->hasFile('file') ) {
                $imagenes = $request->file('file');

                foreach ($imagenes as $key => $imagen) {
                    // Se obtiene el nombre y se guardan en public
                    $nombreImagen = $solicitaServicio->folio .'-'. $imagen->getClientOriginalName();
                    $imagen->move( storage_path('app/public/solicitud_servicios'), $nombreImagen );

                    // Despues se obtiene para codificar en base64
                    $ruta = storage_path('app/public/solicitud_servicios/' . $nombreImagen);
                    $base64Imagen = base64_encode(file_get_contents($ruta));

                    // Se agrega al array que se guardara en la DB
                    $imagenesSolicitudServicio[] = $base64Imagen;

                    // Ya que se guardo, se elimina
                    if (File::exists($ruta)) {
                        File::delete($ruta);
                    }
                }
                // Finalmente se guarda en el servicio solicitado en curso
                $solicitaServicio->imagenes = json_encode($imagenesSolicitudServicio);
                $solicitaServicio->save();
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

    }

    /**
     * Método encargado de guardar los pdfs del servicio solicitado.
     * Es la T01 del P08.
     * @param object $solicitaServicio
     * @param object $request (files, pdfs)
     * @return object $servicioSolicitado
     */
    public function guardarPDFsTareaT01($solicitaServicio, $request) {

        try {

            $archivosSolicitudServicio = [];
            // Validamos si llegaron los pdfs
            if ($request->hasFile('file')) {
                // Se obtiene el archivo
                $archivo = $request->file('file');

                // Se obtiene el nombre y se guarda en public
                $nombrePDF = $solicitaServicio->folio .'-'. $archivo->getClientOriginalName();
                $archivo->move(storage_path('app/public/solicitud_servicios'), $nombrePDF);

                // Después se obtiene para codificar en base64
                $ruta = storage_path('app/public/solicitud_servicios/' . $nombrePDF);
                $base64archivo = base64_encode(file_get_contents($ruta));

                // Se agrega al array que se guardará en la DB
                $archivosSolicitudServicio[] = $base64archivo;

                // Ya que se guardó, se elimina
                if (File::exists($ruta)) {
                    File::delete($ruta);
                }

                // Finalmente se guarda en el servicio solicitado en curso
                $solicitaServicio->imagenes = json_encode($archivosSolicitudServicio);
                $solicitaServicio->save();
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

    }


    /**
     * Método encargado de guardar el desglose de servicio solicitado y guarda en la tabla detalles.
     * Es la T02 del P08.
     * @param object $solicitaServicio
     * @param object $request
     * @return object $servicioSolicitado
     */
    public function guardarTareaT02($solicitaServicio, $request) {

        $servicioJson = $request->arreglo_servicio;
        $detallesServicios = json_decode( $servicioJson );
        $existSolicitaServicio = P08SolicitaServicio::where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)->exists();

        if ( $existSolicitaServicio ) {

            try {
                foreach ( $detallesServicios as $detalle ){

                    // Se valida si ese detalle existe, es necesario cuando se regresa la tarea y se debe corregir
                    $noExisteDetalle = P08DetalleSolicitaServicio::where('p08_detalle_solicita_servicio_id',  $detalle->id )
                                                                ->where('p08_solicita_servicio_id', $solicitaServicio->p08_solicita_servicio_id)
                                                                ->doesntExist();
                    if ( $noExisteDetalle ) {
                        $detalleNuevo = new P08DetalleSolicitaServicio();
                        $detalleNuevo->p08_solicita_servicio_id = $solicitaServicio->p08_solicita_servicio_id;
                        $detalleNuevo->descripcion_servicio = $detalle->descripcion_servicio  ;
                        $detalleNuevo->fecha_estimada = $detalle->fecha_estimada;
                        $detalleNuevo->unidad = $detalle->unidad;
                        $detalleNuevo->estatus_detalle = 'EN_PROCESO';
                        $detalleNuevo->vobo_solicita = true;
                        $detalleNuevo->vobo_entrega = true;
                        $detalleNuevo->servicio_id = $detalle->servicio_id;
                        $detalleNuevo->save();
                    }
                }

                return true;
            } catch (\Throwable $th) {
                return false;
                //throw $th;
            }

        }
    }


    /**
     * Método encargado valida los datos requeridos del formulario y guardar el estatus_detalle de cada registro.
     * Es la T03 del P08.
     * @param object $solicitaServicio
     * @param object $request
     * @return object $servicioSolicitado
     */
    public function guardarTareaT03($solicitaServicio, $request) {
        $servicioJson = $request->arreglo_servicio;
        $detallesServicios = json_decode( $servicioJson );

        try {
            //Actualiza el estatus_detalle de la tabla por su id.
            foreach ($detallesServicios as $key => $detalle) {
                P08DetalleSolicitaServicio::where('p08_detalle_solicita_servicio_id', $detalle->id)
                            ->update([
                                'estatus_detalle' => $request['estatus_detalle_'.$detalle->id],
                                'fecha_entrega' => $request['fecha_entrega_'.$detalle->id],
                                'comentarios_servicio' => $request['comentarios_servicio_'.$detalle->id],
                                'asignado_a' => $request['asignado_a_'.$detalle->id] ? $request['asignado_a_'.$detalle->id] : 'N/A',
                                'confirmado_por' => $request['confirmado_por_'.$detalle->id] ? $request['confirmado_por_'.$detalle->id] : 'N/A',
                            ]);
            }

            $solicitaServicio->comentario_privado = $request->comentario_privado ? $request->comentario_privado : null;
            $solicitaServicio->estatus = 'COMPLETADO';
            $solicitaServicio->fecha_terminado = now();

            return $solicitaServicio->save();
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }


    /**
     * Método encargado de guardar la confirmació del servicio solicitado y regresa la validación para Finalizar el P08.
     * Es la T04 del P08.
     * @param object $solicitaServicio
     * @param object $request
     * @return object $servicioSolicitado
     */
    public function guardarTareaT04($solicitaServicio, $request) {
        $solicitaServicio->estatus = 'COMPLETADO';
        $solicitaServicio->comentario_satisfecho = $request->textarea_comentario_satisfecho;
        $solicitaServicio->comentarios_rechazo = '';
        $solicitaServicio->fecha_terminado = now();
        return $solicitaServicio->save();
    }


    /**
     * Método encargado actualizar el servicio solicitado si es rechazado y agregar un comentario.
     * Es la T06 del P08.
     * @param object $solicitaServicio
     * @param object $request
     * @return object $servicioSolicitado
     */
    public function rechazaT04yRegresaAT03($solicitaServicio, $request) {
        $solicitaServicio->comentarios_rechazo = ( $request->textarea_comentarios_rechazo ) ? $request->textarea_comentarios_rechazo : '';
        return $solicitaServicio->save();
    }



    /**
     * Método encargado de guardar los datos del Vehículo Nuevo.
     * Es el CATÁLOGO DE VEHÍCULOS del P08.
     * @param object $request
     * @return object $vehiculo
     */
    public function guardarVehiculo($request) {

        $vehiculoNuevo = new P08Vehiculo();

        if ( DB::table('p08_vehiculos')->where('placa', $request['placa'])->exists() ) {
            return false;
        } else {
            // Datos del vehículo
            $vehiculoNuevo->placa = $request['placa'];
            $vehiculoNuevo->marca = $request['marca'];
            $vehiculoNuevo->submarca = $request['submarca'];
            $vehiculoNuevo->modelo = $request['modelo'];
            $vehiculoNuevo->tipo_vehiculo = $request['tipo_vehiculo'];
            // Datos del motor
            $vehiculoNuevo->numero_motor = $request['numero_motor'];
            $vehiculoNuevo->numero_serie = $request['numero_serie'];
            $vehiculoNuevo->numero_economico = $request['numero_economico'];
            $vehiculoNuevo->cilindros = $request['cilindros'];
            $vehiculoNuevo->color = $request['color'];

            if ( isset( $request['interruptorAsignacion'] ) ) {
                $area = Area::select('*')
                            ->where('area_id', $request['area_id'] )
                            ->where('activo', true)
                            ->first();
                // Estatus del vehículo SI se selecciona el interruptor de asignación
                $vehiculoNuevo->estatus_vehiculo = 'ASIGNADO';
                // Datos de asignacion
                $vehiculoNuevo->area_id = ( $area ) ? $area->area_id : null;
                $vehiculoNuevo->nombre_conductor = $request['nombre_conductor'];
                $vehiculoNuevo->numero_tarjeta_combustible = $request['numero_tarjeta_combustible'];
            } else {
                // Estatus del vehículo si NO se selecciona el interruptor de asignación
                $vehiculoNuevo->estatus_vehiculo = 'DESHABILITADO';
            }
            // Documentación disponible
            $vehiculoNuevo->copia_factura = $request['copia_factura'];
            $vehiculoNuevo->copia_tarjeta_circulacion = $request['copia_tarjeta_circulacion'];
            $vehiculoNuevo->documentos_alta = 'alta' ;
            $vehiculoNuevo->documentos_baja = 'baja' ;

            return $vehiculoNuevo->save();
        }

    }



    /**
     * Método encargado de validar si existe la matricula en la BD del P08.
     * @param object $request
     * @return object $vehiculo->matricula
     */
    public function existeVehiculo($request) {

        if ( DB::table('p08_vehiculos')->where('placa', $request['placa'])->exists() ) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * Método encargado de guardar los datos de la Bitacorá del Vehículo.
     * Es el CATÁLOGO DE BITÁCORA de VEHÍCULOS del P08.
     * @param object $request de la bitácora
     * @return object $vehiculo_id
     */
    public function guardarBitacoraVehiculo($vehiculo, $request) {

        $areaUser = Auth::user()->area;
        $bitacoraNueva = new P08BitacoraRutaGas();

        //Se parsea la fecha de la ruta para obtener el Año y Mes
        $fecha = date_parse($request['fecha_ruta']);

        //Relación con el vehículo y el área
        $bitacoraNueva->p08_vehiculo_id = $vehiculo->p08_vehiculo_id;
        $bitacoraNueva->area_id = $areaUser->area_id;
        //Datos generales de la bitácora
        $bitacoraNueva->fecha_ruta = $request['fecha_ruta'];
        $bitacoraNueva->anio_bitacora = $fecha['year'];
        $bitacoraNueva->mes_bitacora = $fecha['day'];
        $bitacoraNueva->nombre_elabora = $request['nombre_elabora'];
        $bitacoraNueva->nombre_revisa = $request['nombre_revisa'];
        $bitacoraNueva->observaciones_ruta = $request['observaciones_ruta'];
        //Datos Kilometraje
        $bitacoraNueva->kilometros_inicial = $request['kilometros_inicial'];
        $bitacoraNueva->kilometros_final = $request['kilometros_final'];
        $bitacoraNueva->kilometros_total = $request['kilometros_total'];
        //Datos Combustible
        $bitacoraNueva->ticket = $request['ticket'];
        $bitacoraNueva->fecha_carga = $request['fecha_carga'];
        $bitacoraNueva->litros_combustible = $request['litros_combustible'];
        $bitacoraNueva->tipo_combustible = $request['tipo_combustible'];
        $bitacoraNueva->importe_combustible = $request['importe_combustible'];
        $bitacoraNueva->rendimiento = $request['rendimiento'];
        //Datos Lubricante
        $bitacoraNueva->litros_lubricante = $request['litros_lubricante'];
        $bitacoraNueva->importe_lubricante = $request['importe_lubricante'];
        $bitacoraNueva->partida = $request['partida'];

        return $bitacoraNueva->save();

    }

}
