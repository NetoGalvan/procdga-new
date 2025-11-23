<?php
namespace App\Http\Controllers\p06_servicio_social\catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\p06_servicio_social\P06Instituciones;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatProgramasInstitucionController extends Controller
{
    public $remplazar = ['Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U'];
    public $rem = ['Y DE LAS', 'Y DE LA', ' LAS ', ' LA ', ' Y ', ' E ', '–', '-', ','];

    public function catalogoProgramas($clave_institucion){
        $inst = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
        $programas = P06ProgramasInstitucion::programasPorInstitucion( $inst->institucion_id );
        return response()->json($programas);
    }

    public function modalDatosPrograma($clave_programa){
        $programa = P06ProgramasInstitucion::firstWhere('clave_programa', $clave_programa);
        return response()->json($programa);
    }

    public function programa($clave_institucion, $clave_programa = null, Request $request) // Programa (Crear - Actualizar)
    {
        try {
            DB::beginTransaction();
            $nombre_programa = trim($request->nombre_programa);

            if( $clave_programa == 'null' ) #Configurar clave del programa de forma interna
            { 
                $nombreProgModificado = strtr( $nombre_programa, $this->remplazar );
                if ( str_word_count($nombreProgModificado, 0) == 1 ){ # --------------------------------> Una palabra tres caracteres
                    $clave_programa = ($clave_institucion.'-'.substr($nombreProgModificado, 0, 3));

                } else{ # ------------------------------------------------------------------------------> Más de una palabra, iniciales de cada una de ellas
                    $nombreProgModificado = str_replace($this->rem, ' ', $nombreProgModificado);
                    $clave = '';
                    $arrNombre = explode(" ", $nombreProgModificado);
                    foreach ($arrNombre as $partNombre) $clave .= (substr( trim($partNombre), 0, 1));
                    $clave_programa = $clave_institucion.'-'.$clave;
                }
            }

            $inst = P06Instituciones::firstWhere('clave_institucion', $clave_institucion);
            $programa = P06ProgramasInstitucion::updateOrCreate(
            [ 
                'institucion_id' => $inst->institucion_id,
                'clave_programa' => $clave_programa
            ], [
                'institucion_id' => $inst->institucion_id,
                'nombre_programa' => $nombre_programa,
                'clave_programa' => $clave_programa,
                'activo' => true,
                'updated_at' => now()
            ]);

            if ( $programa->wasChanged() ) { //Comprobar si existen cambios realizados
                $tipo = ( array_key_exists('activo', $programa->getChanges()) ) ? 'guardó' : 'actualizó'; //Identificar si el campo activo cambio (false -> true)
            } else {
                $programa->created_at = now();
                $programa->save();
                $tipo = 'guardó';
            }
            $programas = P06ProgramasInstitucion::programasPorInstitucion( $inst->institucion_id );

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => "La programa se $tipo correctamente.", 'programas' => $programas]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        }
    }

    public function eliminarPrograma( $clave_programa = null ) {
        try {
            DB::beginTransaction();

            $programa = P06ProgramasInstitucion::firstWhere('clave_programa', $clave_programa);
            $programa->activo = false; //Cambiar el campo activo ( true -> false )
            $programa->save();
            
            $programas = P06ProgramasInstitucion::programasPorInstitucion( $programa->institucion_id );

            DB::commit();
            return response()->json(['estatus' => true, 'programas' => $programas]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        } 
    }
}