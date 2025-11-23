<?php
namespace App\Http\Controllers\p06_servicio_social\catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06Instituciones;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatEscuelaController extends Controller {

    public function catalogoEscuelas( $clave_institucion ) {
        $inst = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
        $escuelas = P06Escuela::escuelasPorInstitucion( $inst->institucion_id );
        return response()->json($escuelas);
    }

    public function modalDatosEscuela( $acronimo_escuela ) {
        $escuela = P06Escuela::firstWhere('acronimo_escuela', $acronimo_escuela);
        return response()->json($escuela);
    }

    public function escuela($clave_institucion, $acronimo_escuela = null, Request $request) // Escuela (Crear - Actualizar)
    {
        try {
            DB::beginTransaction();
            $acronimo_escuela = ( $acronimo_escuela == "null") ? $request->acronimo_escuela : $acronimo_escuela; 

            $inst = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
            $escuela = P06Escuela::updateOrCreate(
            [ 
                'institucion_id' => $inst->institucion_id,
                'acronimo_escuela' => $acronimo_escuela
            ], [
                'institucion_id' => $inst->institucion_id,
                'nombre_escuela' => $request->nombre_escuela,
                'acronimo_escuela' => $request->acronimo_escuela,
                'direccion_escuela' => $request->direccion_escuela,
                'activo' => true,
                'updated_at' => now()
            ]);

            if ( $escuela->wasChanged() ) { //Comprobar si existen cambios realizados
                $tipo = ( array_key_exists('activo', $escuela->getChanges()) ) ? 'guardó' : 'actualizó'; //Identificar si el campo activo cambio (false -> true)
            } else {
                $escuela->created_at = now();
                $escuela->save();
                $tipo = 'guardó';
            }
            $escuelas = P06Escuela::escuelasPorInstitucion( $inst->institucion_id );

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => "La escuela se $tipo correctamente.", 'escuelas' => $escuelas]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        }
    }

    public function eliminarEscuela( $acronimo_escuela = null ) {
        try {
            DB::beginTransaction();

            $escuela = P06Escuela::firstWhere('acronimo_escuela', $acronimo_escuela);
            $escuela->activo = false; //Cambiar el campo activo ( true -> false )
            $escuela->save();
            
            $escuelas = P06Escuela::escuelasPorInstitucion( $escuela->institucion_id );

            DB::commit();
            return response()->json(['estatus' => true, 'escuelas' => $escuelas]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        } 
    }
}