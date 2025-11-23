<?php

namespace App\Http\Controllers\p06_servicio_social\catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\p06_servicio_social\P06Instituciones;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatInstitucionController extends Controller {

    public function catalogoInstituciones(Request $request) {
        
        if ( $request->ajax() ) {
            $instituciones =  P06Instituciones::where('activo',true)->get();
            return response()->json($instituciones);
        }
        return view('p06_servicio_social.Catalogos.CAT_institucion');
    }

    public function modalDatosInstitucion($clave_institucion) {
        $institucion = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
        return response()->json($institucion);
    }

    public function institucion($clave_institucion = null, Request $request) // Institucion (Crear - Actualizar)
    {
        try {
            DB::beginTransaction();
            $clave_institucion = ( $clave_institucion == "null") ? $request->clave_institucion : $clave_institucion; 

            $institucion = P06Instituciones::updateOrCreate(
            [ 
                'clave_institucion' => $clave_institucion
            ], [
                'nombre_institucion' => $request->nombre_institucion,
                'acronimo_institucion' => $request->acronimo_institucion,
                'clave_institucion' => $request->clave_institucion,
                'activo' => true,
                'updated_at' => now()
            ]);

            if ( $institucion->wasChanged() ) { //Comprobar si existen cambios realizados
                $tipo = ( array_key_exists('activo', $institucion->getChanges()) ) ? 'guardó' : 'actualizó'; //Identificar si el campo activo cambio (false -> true)
            } else {
                $institucion->created_at = now();
                $institucion->save();
                $tipo = 'guardó';
            }
            $instituciones = P06Instituciones::where('activo',true)->get();

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => "La institucion se $tipo correctamente.", 'instituciones' => $instituciones]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        }
    }

    public function eliminarInstitucion( $clave_institucion = null ) {
        try {
            DB::beginTransaction();

            $institucion = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
            $institucion->activo = false; //Cambiar el campo activo ( true -> false )
            $institucion->save();
            
            $instituciones = P06Instituciones::where('activo',true)->get();

            DB::commit();
            return response()->json(['estatus' => true, 'instituciones' => $instituciones]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        } 
    }
}
