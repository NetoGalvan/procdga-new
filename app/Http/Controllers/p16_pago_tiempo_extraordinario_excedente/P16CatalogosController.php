<?php

namespace App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente;

use App\Http\Controllers\Controller;
use App\Models\UnidadAdministrativa;
// use App\Models\p16_pago_tiempo_extraordinario_excedente\P16PresupuestoAnualExtraordinarioExcedente;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16TabuladorSueldoTecnicoOperativo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class P16CatalogosController extends Controller
{

//Funciones del catalogo de Tabulador de sueldos

    /**
     * Vista del catalogo de tabulador de sueldos para el calculo del tiempo extra/excedente
     *
     * @return Illuminate\Support\Facades\View  p16_pago_tiempo_extraordinario_excedente.catalogos.tabulador_sueldos.index
     */
    public function catalogoTabuladoresVista(){
        return response()->view('p16_pago_tiempo_extraordinario_excedente.catalogos.tabulador_sueldos.index');
    }
    /**
     * Tabulador de Sueldos para el calculo del tiempo extra/excedente
     *
     * @param   int     $year   año a buscar
     * @return \Illuminate\Database\Eloquent\Builder    catalogo de tabulador de sueldos
     */
    public function catalogoTabuladoresData($year = null){
        (isset($year)) ?: $year = now()->year;
        return P16TabuladorSueldoTecnicoOperativo::Year($year)->where('activo', true)->orderBy('nivel_salarial', 'asc')->get();
    }
    /**
     * Modal de edicion del catalogo de Tabulador de sueldos
     *
     * @param   \Illuminate\Http\Request    $request   id del modelo a buscar
     * @return  \Illuminate\Support\Facades\View    p16_pago_tiempo_extraordinario_excedente.catalogos.tabulador_sueldos.modals.edit
     */
    public function catalogoTabuladoresModalEdit(Request $request){
        try {
            $sueldo = P16TabuladorSueldoTecnicoOperativo::find($request->id);
            return view("p16_pago_tiempo_extraordinario_excedente.catalogos.tabulador_sueldos.modals.edit", compact('sueldo'));
        } catch (\Throwable $e) {
            Log::warning(__METHOD__ . "--->Line:" . $e->getLine() . "----->" . $e->getMessage());
            return response('Ocurrio un error al buscar el Sueldo señalado. Code-TEECC', 500);
        }
    }
    /**
     * Funcion para editar la informacion de un registro en el catalogo
     * @param  \Illuminate\Http\Request     $request    informacion con la que actualizaremos elregistro del catalogo
     * @return \Illuminate\Http\Response    estatus de la edicion del registro
     */
    public function catalogoTabuladoresEdit(Request $request){

        try {

            $existe = P16TabuladorSueldoTecnicoOperativo::where('anio', $request->anio_sueldo)->where('tipo', $request->tipo)->where('nivel_salarial', $request->nivel_salarial)->exists();

            if ($existe) {
                return back()->withInput()->withErrors(['mensaje_error' => "Ya existe un registro que coincide con los valores ingresados."]);
            } else {
                
                DB::beginTransaction();
                    P16TabuladorSueldoTecnicoOperativo::query()->where('tabulador_calcular_tiempo_extra_id', $request->sueldo_id)
                    ->update(['tipo' => $request->tipo,
                            'anio' => $request->anio_sueldo,
                            'nivel_salarial' => $request->nivel_salarial,
                            'tabulador_autorizado_bruto' => $request->tabulador_autorizado,
                            'reconocimiento_mensual_bruto' => $request->reconocimiento_mensual,
                            'cantidad_adicional_bruto' => $request->cantidad_adicional,
                            'asignacion_adicional_bruto' => $request->asignacion_adicional,
                            'total_mensual_bruto' => $request->total_mensual
                        ]);
                DB::commit();
    
                return redirect()->route('tiempo.extraordinario.excedente.catalogo.tabuladores')->with("success", "¡Tabulador editado correctamente!");
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->withErrors(['mensaje_error' => "Error: $th"]);
        }
    }
    /**
     * Crea una entrada para el tabulador de sueldos de tecnico operativo
     *
     * @param  \Illuminate\Http\Request  $request Datos para crear un sueldo asignado a un nivel salarial
     * @return \Illuminate\Http\Response    estatus del registro creado
     */
    public function catalogoTabuladoresCreate(Request $request){

        $existe = P16TabuladorSueldoTecnicoOperativo::where('anio', $request->anio_sueldo)->where('tipo', $request->tipo)->where('nivel_salarial', $request->nivel_salarial)->exists();

        if ($existe) {
            return back()->withInput()->withErrors(['mensaje_error' => "Ya existe un registro que coincide con los valores ingresados."]);
        } else {
            
            try {   
                $catalogo = new P16TabuladorSueldoTecnicoOperativo;

                DB::beginTransaction();
                    $catalogo->anio = $request->anio_sueldo;
                    $catalogo->tipo = $request->tipo;
                    $catalogo->nivel_salarial = $request->nivel_salarial;
                    $catalogo->tabulador_autorizado_bruto = $request->tabulador_autorizado;
                    $catalogo->reconocimiento_mensual_bruto = $request->reconocimiento_mensual;
                    $catalogo->cantidad_adicional_bruto = $request->cantidad_adicional;
                    $catalogo->asignacion_adicional_bruto = $request->asignacion_adicional;
                    $catalogo->total_mensual_bruto = $request->total_mensual;
                    $catalogo->save();
                DB::commit();

                return redirect()->route('tiempo.extraordinario.excedente.catalogo.tabuladores')->with("success", "¡Tabulador agregado correctamente!");

            } catch (\Throwable $th) {
                DB::rollback();
                return back()->withInput()->withErrors(['mensaje_error' => "Error: $th"]);
            }
        }
    }

    public function eliminarTabulador(Request $request){
        
        try {
            DB::beginTransaction();
                P16TabuladorSueldoTecnicoOperativo::query()->where('tabulador_calcular_tiempo_extra_id', $request->id)->update(['activo' => false]);
            DB::commit();
            return response()->json([ "estatus" => true, "mensaje" => "Tabulador eliminado correctamente." ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([ "estatus" => false, "mensaje" => "Error: $th" ]);
        }
    }
}
