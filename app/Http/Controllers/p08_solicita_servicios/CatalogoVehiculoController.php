<?php

namespace App\Http\Controllers\p08_solicita_servicios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServicioController;

use App\Http\Controllers\p08_solicita_servicios\ManejadorTareas;
use App\Models\p08_solicita_servicios\P08Vehiculo;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;
use App\User;
use BD;
use Auth;
use DateTime;
use Illuminate\Pagination\Paginator;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class CatalogoVehiculoController extends Controller
{
    use ManejadorTareas;

    var $roles = ['JUD_TRANSPORTE' => 'JUD_TRANSPORTE', 'JUD_RM' => 'JUD_RM', 'SUPER_ADMIN' => 'SUPER_ADMIN', 'ADMIN' => 'ADMIN'];

    /**
     * CATALOGO VEHÍCULOS
     * Método encargado del CRUD para el Catálogo de Vehículos del P08 JUD_TRANSPORTE
     */
    public function catalogoVehiculos(Request $request, P08Vehiculo $vehiculos )   {
        $usuario = Auth::user();

        $areas = DB::table( 'areas' )
                    ->select( '*' )
                    ->where('activo', true)
                    ->whereNull('area_principal_id')
                    ->get();

        $nombreRol = DB::table( 'roles' )
                    ->select( 'name' )
                    ->whereIn('roles.id', DB::table('model_has_roles')->select('role_id')->where('model_id', '=', $usuario->id))
                    ->get();

        foreach ($nombreRol as $jud) {

            if ( $jud->name == $this->roles['JUD_RM'] )
            {

                $vehiculos = DB::table('p08_vehiculos')
                            ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                            ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                            ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                            ->where('p08_vehiculos.activo', true)
                            ->where('areas.area_id', $usuario->area->area_id )
                            ->orderBy('updated_at', 'desc')
                            ->get();

            }
            else if($jud->name == $this->roles['JUD_TRANSPORTE'] || $jud->name == $this->roles['SUPER_ADMIN'])
            {

                $vehiculos = DB::table('p08_vehiculos')
                                ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                                ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                                ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                                ->where('p08_vehiculos.activo', true)
                                ->orderBy('updated_at', 'desc')
                                ->get();
            }

        }

        if ( $request->ajax() ) {

            // Valida si es una actualización ya que la envía la petición con ID.
            if ( $request->input('p08_vehiculo_id') ) {

                $usuario = Auth::user();

                $nombreRol = DB::table( 'roles' )
                            ->select( 'name' )
                            ->whereIn('roles.id', DB::table('model_has_roles')->select('role_id')->where('model_id', '=', $usuario->id))
                            ->get();

                $area = null;
                if ( $request->input('interruptorAsignacion') )  {
                    $area = DB::table( 'areas' )
                                ->select( '*' )
                                ->where('activo', true)
                                ->where('area_id', $request->input('area_id') )
                                ->first();
                }

                P08Vehiculo::where('p08_vehiculo_id', $request->input('p08_vehiculo_id'))
                            ->update([
                                'area_id' => ( $area ) ? $area->area_id : $request->input('area_id'),
                                'estatus_vehiculo' => ( $area ) ? 'ASIGNADO' : 'LIBRE',
                                'placa' => $request->input('placa'),
                                'marca' => $request->input('marca'),
                                'submarca' => $request->input('submarca'),
                                'modelo' => $request->input('modelo'),
                                'nombre_conductor' => ( $area ) ? $request->input('nombre_conductor') : '',
                                'numero_motor' => $request->input('numero_motor'),
                                'numero_serie' => $request->input('numero_serie'),
                                'numero_economico' => $request->input('numero_economico'),
                                'cilindros' => $request->input('cilindros'),
                                'color' => $request->input('color'),
                                'copia_factura' => $request->input('copia_factura'),
                                'copia_tarjeta_circulacion' => $request->input('copia_tarjeta_circulacion'),
                                'numero_tarjeta_combustible' => ( $area ) ? $request->input('numero_tarjeta_combustible') : '',
                                'tipo_vehiculo' => $request->input('tipo_vehiculo'),
                                'documentos_alta' => ( $request->input('documentos_alta') ) ? $request->input('documentos_alta') : 'alta' ,
                                'documentos_baja' => ( $request->input('documentos_baja') ) ? $request->input('documentos_baja') : 'baja',
                            ]);

                $vehiculos = DB::table('p08_vehiculos')
                        ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                        ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                        ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                        ->where('p08_vehiculos.activo', true)
                        ->orderBy('updated_at', 'desc')
                        ->get();

                return  response()->json([
                    'actualizado' => true,
                    'mensaje' => 'El vehículo se actualizó correctamente',
                    'vehiculos' => $vehiculos
                ]);

            } else {

                //Guardará el vehículo pero antes Validará si existe esa Placa en la BD.
                if ( $this->guardarVehiculo( $request->all() ) ) {

                    $nombreRol = DB::table( 'roles' )
                            ->select( 'name' )
                            ->whereIn('roles.id', DB::table('model_has_roles')->select('role_id')->where('model_id', '=', $usuario->id))
                            ->get();

                    $vehiculos = DB::table('p08_vehiculos')
                            ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                            ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                            ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                            ->where('p08_vehiculos.activo', true)
                            ->orderBy('updated_at', 'desc')
                            ->get();

                    //Si la placa no existe, entonces enviará una vista con la tabla y los registros nuevos.
                    return  response()->json([
                        'guardado' => true,
                        'mensaje' => 'El vehículo fue guardado exitosamente',
                        'vehiculos' => $vehiculos
                    ]);

                } else {
                    //Si existe la placa enviará un mensaje de alerta.
                    return  response()->json([
                        'existe' => true,
                        'mensaje' => 'El vehículo que quieres ingresar ya existe'
                    ]);
                }
            }
        }

        return view('p08_solicita_servicios.catalogos.CAT_vehiculo', [ 'vehiculos' => $vehiculos, 'areas' => $areas, 'nombreRol' => $nombreRol ]);
    }


    // Este método busca el id de un 'Vehículo' y lo coloca en activo false. forma parte del CATALOGO de VEHÍCULOS del P08
    public function eliminarVehiculo(Request $request, P08Vehiculo $vehiculos){

        P08Vehiculo::where('p08_vehiculo_id', $request->id)
                    ->update([ 'activo' => false ]);

        $vehiculos = DB::table('p08_vehiculos')
                ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                ->where('p08_vehiculos.activo', true)
                ->orderBy('updated_at', 'desc')
                ->get();

        return response()->json([
            'eliminado' => true,
            'mensaje' => 'El vehículo fue eliminado exitosamente',
            'vehiculos' => $vehiculos
        ]);

    }


    // Este método busca el id de un 'Vehículo' y lo carga en el formulario para su edición. forma parte del CATALOGO de VEHÍCULOS del P08
    public function editarVehiculo( Request $request, P08Vehiculo $vehiculos ){

        if ( $request->ajax() ) {

            $vehiculo = P08Vehiculo::findOrFail($request->id);

            return response()->json([
                'vehiculo' => $vehiculo
            ]);
        }

    }


    /**
     * Método encargado del Guardar la Bitacora de Vehículos del P08 JUD_RM
     */
    public function catalogoVehiculoBitacoraRutaGas(Request $request, P08Vehiculo $vehiculo)   {

        $user = Auth::user();

        if ( $request->isMethod('post') ) {

            // Guardará LA BITÁCORA del VEHÍCULO en la BD.
            if ( $this->guardarBitacoraVehiculo( $vehiculo, $request->all() ) ) {

                $vehiculo = DB::table('p08_vehiculos')
                            ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                            ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*' )
                            ->where('p08_vehiculos.activo', true)
                            ->where('p08_vehiculos.p08_vehiculo_id', $vehiculo->p08_vehiculo_id)
                            ->first();

                $bitacoras = DB::table('p08_bitacora_rutas_gas')
                            ->leftjoin('areas', 'p08_bitacora_rutas_gas.area_id', '=', 'areas.area_id')
                            ->select('p08_bitacora_rutas_gas.*', 'areas.identificador', 'areas.nombre')
                            ->where('p08_bitacora_rutas_gas.activo', true)
                            ->where('p08_bitacora_rutas_gas.p08_vehiculo_id', $vehiculo->p08_vehiculo_id)
                            ->orderBy('p08_bitacora_ruta_gas_id', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(3);

                // Si se guardo bien responderá correctamente y se actualizará la tabla.
                $mensaje = 'El registro se guardo exitosamente en la bitácora';
                return redirect()
                        ->route( 'solicitud.servicio.administrar.catalogo.vehiculo.bitacora.ruta.gas', ['vehiculo' => $vehiculo->p08_vehiculo_id] )
                        ->with('success', $mensaje);

            }
        }

        $vehiculo = DB::table('p08_vehiculos')
                            ->leftjoin('areas', 'p08_vehiculos.area_id', '=', 'areas.area_id')
                            ->leftjoin('unidades_administrativas', 'areas.unidad_administrativa_id', '=', 'unidades_administrativas.unidad_administrativa_id')
                            ->select( 'areas.nombre', 'areas.identificador', 'areas.area_id', 'p08_vehiculos.*', 'unidades_administrativas.nombre' )
                            ->where('p08_vehiculos.activo', true)
                            ->where('p08_vehiculos.p08_vehiculo_id', $vehiculo->p08_vehiculo_id)
                            ->first();

        $bitacoras = DB::table('p08_bitacora_rutas_gas')
                        ->leftjoin('areas', 'p08_bitacora_rutas_gas.area_id', '=', 'areas.area_id')
                        ->select('p08_bitacora_rutas_gas.*', 'areas.identificador', 'areas.nombre')
                        ->where('p08_bitacora_rutas_gas.activo', true)
                        ->where('p08_bitacora_rutas_gas.p08_vehiculo_id', $vehiculo->p08_vehiculo_id)
                        ->orderBy('p08_bitacora_ruta_gas_id', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(3);

        $ultimoKilomatraje = DB::table('p08_bitacora_rutas_gas')
                        ->select('kilometros_final')
                        ->where('activo', true)
                        ->where('p08_bitacora_rutas_gas.p08_vehiculo_id', $vehiculo->p08_vehiculo_id)
                        ->orderBy('p08_bitacora_ruta_gas_id', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->first();

        return view('p08_solicita_servicios.catalogos.CAT_vehiculo_bitacora_ruta_gas', ['vehiculo' => $vehiculo, 'bitacoras' => $bitacoras, 'usuario' => $user, 'ultimoKilomatraje' => $ultimoKilomatraje]);
    }


}
