<?php

namespace App\Http\Controllers\p06_servicio_social\catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\p06_servicio_social\ManejadorTareas;
use App\Models\p06_servicio_social\P06Programa;
use App\Models\p06_servicio_social\P06AreasAdscripcion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatAreasAdscripcionController extends Controller
{
    use ManejadorTareas;

    public function catalogoAreasAdscripcion(Request $request) {
        if ( $request->ajax() ) {
            $areasAdscripcion =  P06AreasAdscripcion::where('activo',true)->get();
            return response()->json($areasAdscripcion);
        }
        //$areasAds = P06AreasAdscripcion::where('activo', true)->orderBy('area_adscripcion_id', 'asc')->get();
/*
        if ($request->isMethod('post')) {
            if ($this->catalogoGuardarNuevaArea($request->all())) {
                return response()->json([ "estatus" => true, "mensaje" => 'Área guardada correctamente', "ruta" => route('servicio.social.catalogo.areas.adscripcion')]);
            }else{
                return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error al tratar de guardar la información, favor de intentar de nuevo más tarde.' ]);
            }
        }
*/
        return view('p06_servicio_social.Catalogos.CAT_areas_adscripcion'/*, compact('areasAds')*/);
    }

    public function modalDatosAreaAdscripcion($nombre_area, $direccion_area){
        $areaAdscripcion = P06AreasAdscripcion::where('nombre_area_adscripcion', $nombre_area)->where('direccion_area_adscripcion', $direccion_area)->first();
        return response()->json($areaAdscripcion);
    }

    public function areaAdscripcion(Request $request, $nombre_area, $direccion_area) // Area adscripcion (Crear - Actualizar)
    {
        try {
            DB::beginTransaction();
            $nombre_area = ( $nombre_area == "null") ? $request->nombre_area : $nombre_area; 

            $areaAdscripcion = P06AreasAdscripcion::updateOrCreate(
            [ 
                'nombre_area_adscripcion' => $nombre_area
            ], [
                'nombre_area_adscripcion' => $request->nombre_area,
                'direccion_area_adscripcion' => $request->direccion_area,
                'activo' => true,
                'updated_at' => now()
            ]);

            if ( $areaAdscripcion->wasChanged() ) { //Comprobar si existen cambios realizados
                $tipo = ( array_key_exists('activo', $areaAdscripcion->getChanges()) ) ? 'guardó' : 'actualizó'; //Identificar si el campo activo cambio (false -> true)
            } else {
                $areaAdscripcion->created_at = now();
                $areaAdscripcion->save();
                $tipo = 'guardó';
            }
            //$instituciones = P06AreasAdscripcion::where('activo',true)->get();

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => "El área de adscripción se $tipo correctamente."/*, 'instituciones' => $instituciones*/]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => "Surgio algún percance, comuniquese con el administrador" ]);
        }
    }

    public function eliminarAreaAdscripcion($nombre_area, $direccion_area){
        try {
            DB::beginTransaction();

            $areaAdscripcion = P06AreasAdscripcion::where('nombre_area_adscripcion', $nombre_area)
                                                  ->where('direccion_area_adscripcion', $direccion_area)
                                                  ->update([ 'activo' => false ]);
            //$prestadores = P06AreasAdscripcion::where('activo', true)->with(['escuela.institucion','municipio.entidad'])->orderBy('primer_apellido')->get()->append('nombre_prestador_completo');

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => "El área de <br> <b>$nombre_area</b> <br> se elimino exitosamente."/*, 'prestadores' => $prestadores*/]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => "Surgio algún percance, comuniquese con el administrador" ]);
        }
    }

/*
    public function editarAreasAdscripcion(Request $request){
        
        if ( $request->si_es == 'recuperarDatosParaEditarPorAjax' ) {
            $area = P06AreasAdscripcion::where('area_adscripcion_id', $request['area_adscripcion_id'])->first();
            return response()->json(['area' => $area]);
        }

        if ($request->isMethod('post')) {
            if ($this->catalogoEditarArea($request->all())) {
                return response()->json(["estatus" => true, "mensaje" =>'Área actualizada correctamente', "ruta" => route('servicio.social.catalogo.areas.adscripcion')]);
            }else{
                return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error al actualizar la información, favor de intentar de nuevo más tarde.' ]);
            }
        }
    }

    public function eliminarAreasAdscripcion(Request $request){

        if ($request->isMethod('post')) {
            if ($this->pasarAreaAFalse($request->all())) {
                return response()->json([ "estatus" => true, "mensaje" => 'Área eliminada correctamente', "ruta" => route('servicio.social.catalogo.areas.adscripcion')]);
            }else{
                return response()->json([ "estatus" => false, "mensaje" => 'Ocurrio un error al eliminar la escuela, favor de intentar de nuevo más tarde.' ]);
            }
        }
    }

    public function recuperarProgramas(Request $request){

        $programas = P06Programa::where('activo', true)
                    ->where('institucion_id', $request->idInstitucion)
                    ->orderBy('programa_id', 'desc')
                    ->get();
        return $programas;
    }
*/

}
