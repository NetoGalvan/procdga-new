<?php

namespace App\Http\Controllers\p06_servicio_social\catalogos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EntidadFederativa;
use App\Models\Municipio;
//use App\Http\Controllers\p06_servicio_social\ManejadorTareas;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06ProgramasInstitucion;
use App\Models\p06_servicio_social\P06Instituciones;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatPrestadorController extends Controller{

    //use ManejadorTareas;

    public function horario($hora) {
        $horario_24 = [
            '1' => '13', '2' => '14', '3' => '15', '4' => '16', '5' => '17', '6' => '18', 
            '7' => '19', '8' => '20', '9' => '21', '10' => '22', '11' => '23', '12' => '24', 
        ];

        if ( strpos($hora, 'PM') !== false ) { 
            $simpHora = str_replace(' PM', '', $hora);
            $particionarHr = explode(':',$simpHora);
            return $horario_24[$particionarHr[0]].':'.$particionarHr[1]; 

        } else {  
            return str_replace(' AM', '', $hora);
        }
    }

    public function catalogoPrestador(Request $request){
        if ( $request->ajax() ) {
            $prestadores = P06Prestador::where('activo', true)->with(['escuela.institucion','municipio.entidad'])->orderBy('primer_apellido')->get()->append('nombre_prestador_completo');
            return response()->json($prestadores);
        }

        $instituciones = P06Instituciones::get();
        $entidades = EntidadFederativa::get();
        $tipos = ["SERVICIO SOCIAL", "PRACTICAS PROFESIONALES"];

        return view('p06_servicio_social.Catalogos.CAT_prestador', compact('instituciones', 'entidades','tipos'));
    }
    public function modalPrestador($prestador_id)
    {
        $prestador = P06Prestador::where('prestador_id',$prestador_id)->with(['escuela.institucion','municipio','programa'])->first();

        return response()->json([ 'prestador' => $prestador ]);
    }

    public function prestador($prestador_id, Request $request) // Crear o Actualizar Prestador
    {
        //dd($request->all());
        try {
            DB::beginTransaction();

            $entrada = $this->horario($request->hora_entrada);
            $salida = $this->horario($request->hora_salida);

            $prestador = P06Prestador::updateOrCreate(
            [ 
                'prestador_id' => $prestador_id,
            ], [
                'escuela_id' => intval($request->escuela_id),
                'programa_id' => isset($request->programa_id) ? intval($request->programa_id) : null,
                'tipo_prestador' => $request->tipo_prestador,
                'primer_apellido' => $request->apePaterno,
                'segundo_apellido' => $request->apeMaterno,
                'nombre_prestador' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->correo,
                'carrera' => $request->carrera,
                'matricula' => $request->matricula,
                'calle' => $request->calle,
                'numero_interior' => $request->interior,
                'numero_exterior' => $request->exterior,
                'ciudad' => $request->ciudad,
                'colonia' => $request->colonia,
                'cp' => $request->cp,
                'municipio_id' => intval($request->municipio_id), 
                'horario_tentativo' => "$entrada - $salida",
                'total_horas' => $request->total_horas,
                'observaciones' => $request->observaciones,
                'nombre_funcionario' => $request->nombre_funcionario,
                'puesto_funcionario' => $request->puesto_funcionario,
                'telefono_funcionario' => $request->telefono_funcionario,
                'activo' => true,
                'updated_at' => now()
            ]);

            if ( $prestador->wasChanged() ) {
                $mensaje = 'El prestador se actualizó correctamente.';
            } else {
                $prestador->created_at = now();
                $prestador->save();

                $mensaje = 'El prestador se guardó correctamente.';
            }
            $prestadores = P06Prestador::where('activo', true)->with(['escuela.institucion','municipio.entidad'])->orderBy('primer_apellido')->get()->append('nombre_prestador_completo');

            DB::commit();
            return response()->json(['estatus' => true, 'mensaje' => $mensaje, 'prestadores' => $prestadores]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        }
    }

    public function eliminarPrestador($prestador_id){
        try {
            DB::beginTransaction();

            $prestador = P06Prestador::where('prestador_id', $prestador_id)->update([ 'activo' => false ]);
            $prestadores = P06Prestador::where('activo', true)->with(['escuela.institucion','municipio.entidad'])->orderBy('primer_apellido')->get()->append('nombre_prestador_completo');

            DB::commit();
            return response()->json(['estatus' => true, 'prestadores' => $prestadores]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error(__METHOD__.'('.__LINE__.')'.$e->getMessage());
            return response()->json([ 'estatus' => true, 'mensaje' => $e->getMessage() ]);
        }
    }

    public function getEscuelasProgramas(Request $request) {
        $escuelas = P06Escuela::where('institucion_id', $request->institucion_id)->where('activo', true)->get(['escuela_id','nombre_escuela','acronimo_escuela']);
        $programas = P06ProgramasInstitucion::where('institucion_id', $request->institucion_id)->where('activo', true)->get(['programa_id','nombre_programa']);

        return response()->json([ 'escuelas' => $escuelas, 'programas' => $programas]);
    }

    public function getAlcaldiasMunicipios(Request $request) {
        $municipios = Municipio::whereHas('entidad', function($q) use ($request) {
                                    $q->where('entidad_federativa_id', $request->entidad_id);
                                })->get();

        return response()->json([ 'municipios' => $municipios ]);
    }
}