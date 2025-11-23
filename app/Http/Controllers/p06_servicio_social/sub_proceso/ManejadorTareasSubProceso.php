<?php

namespace App\Http\Controllers\p06_servicio_social\sub_proceso;

use App\Http\Traits\RegistroInstancias;
use App\Http\Traits\P06_servicio_social\ValidacionFormularios;

use App\Models\Dependencia;
use App\Models\UnidadAdministrativa;
use App\Models\EntidadFederativa;
use App\Models\Proceso;
use App\Models\Instancia;
use App\Models\p06_servicio_social\P06Detalle;
use App\Models\p06_servicio_social\P06Escuela;
use App\Models\p06_servicio_social\P06Nomina;
use App\Models\p06_servicio_social\P06NominaDetalle;
use App\Models\p06_servicio_social\P06Prestador;
use App\Models\p06_servicio_social\P06Programa;
use App\Models\p06_servicio_social\P06ServicioSocial;
use App\Models\p06_servicio_social\P06Instituciones;

use Illuminate\Support\Carbon;
use DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

trait ManejadorTareasSubProceso{
    use RegistroInstancias;

    public function crearTarea($instancia, $nombreTarea, $estatus){
        return $instancia->crearInstanciaTarea($nombreTarea, $estatus);
    }

    public function crearFolio($instancia, $instanciaTarea) {
        $instancia->folio  = $this->crearFolioProceso($instancia, $instanciaTarea);
        $instancia->save();

        return $instancia->folio;
    }

    public function crearServicioSocial($instancia, $folio){
        return P06Nomina::create([
            'estatus_trabajo' => 'WORKING',
            'instancia_id' => $instancia->instancia_id,
            'folio' => $folio
        ]);
    }

    public function actualizarEstatusTarea($instanciaTarea, $estatus){
        $instanciaTarea->estatus = $estatus;
        return $instanciaTarea->save();
    }

    public function actualizarEstatusTareasMismaInstancia($instanciaTarea, $estatus){

        return DB::table('instancia_tarea')
                ->where(['instancia_id' => $instanciaTarea->instancia_id])
                ->update(['estatus' => $estatus,
                        'autorizado_por_usuario' => Auth::user()->id,
                        'autorizado_por_area' => Auth::user()->area->area_id]);
    }

    public function getInstanciaTarea($instancia, $nombreTarea, $area_usuario){
        return $instancia->getInstanciaTarea($nombreTarea, $area_usuario);
    }

    public function getInstanciaTareaSubproceso($instancia, $nombreTarea, $instanciaSubPro){
        return $instanciaSubPro->getInstanciaTareaSubProceso($nombreTarea);
    }

    public function finalizarProceso($instanciaTarea, $estatus){

        try {
            DB::beginTransaction();

            Instancia::where('instancia_id', $instanciaTarea->instancia_id)->update(['estatus' => $estatus]);

            return DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
        }

    }

    public function guardarTareaT01Nomina($nomina, $request) {
        try {
            DB::beginTransaction();

            $nomina->tipo_validacion = $request['tipo_nomina'];
            $nomina->descripcion = $request['nombreNomina'];
            $nomina->fecha_inicio = $request['fecha_inicio'];
            $nomina->fecha_fin = $request['fecha_fin'];
            $nomina->observaciones = $request['observacionesNomina'];
            $nomina->save();

            DB::commit();
            return ['guardado' => true];
        } catch (\Throwable $th) {
            DB::rollback();
            return ['guardado' => false, 'mensaje' => $th];
        }
    }

    public function guardarTareaT02Validacion($request, $nomina) {
        try {
            DB::beginTransaction();
            foreach($request->get('asignar_validacion') as $asignar) {
                $asignar = explode(',', $asignar);

                $servicioSocial = P06ServicioSocial::firstWhere('servicio_social_id', $asignar[1]);
                $existe = P06NominaDetalle::where('servicio_social_id', $asignar[1])->exists();

                if ($asignar[0] == "ACEPTADO" && !$existe) 
                {
                        P06ServicioSocial::where('servicio_social_id', $asignar[1])
                        ->update([
                            'nomina_id' => $nomina->nomina_id
                        ]);

                        $inicio = Carbon::parse($servicioSocial->fecha_inicio);
                        $fin = Carbon::parse($servicioSocial->fecha_fin);

                        $diferencia_entre_fechas = $fin->diff($inicio);
                        $diferencia_de_meses = $diferencia_entre_fechas->format("%m");
                        $diferencia_de_anios = $diferencia_entre_fechas->format("%y")*12;
                        
                        $total_de_meses = $diferencia_de_meses + $diferencia_de_anios;
                        
                        $meses_a_pagar = $total_de_meses;

                        $nominaDetalle = new P06NominaDetalle();
                        $nominaDetalle->nomina_id = $nomina->nomina_id;
                        $nominaDetalle->servicio_social_id = $asignar[1];
                        $nominaDetalle->tipo_pago = "COMPLETA";
                        $nominaDetalle->meses_pagar = $meses_a_pagar;
                        $nominaDetalle->created_at = now();
                        $nominaDetalle->updated_at = now();
                        $nominaDetalle->save();

                }
            }

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function guardarTareaT03Cierre($nomina, $prestadoresYaValidados){

        try {

            $existeServicio = P06NominaDetalle::where('nomina_id', $nomina->nomina_id)->exists();

            if ($existeServicio) {

                DB::beginTransaction();

                    DB::table('p06_nomina_detalle')
                    ->where(['nomina_id' => $nomina->nomina_id])
                    ->update(['fecha_cerrado' => now()]);

                DB::commit();

                return [ 'estatus' => true ];
            }else {
                return [ 'estatus' => true ];
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Fallo: ' . $th ];
        }
    }

    public function crearTareasParaSubEa($instancia, $areas_sub_ea) {

        foreach ($areas_sub_ea as $area) {
            
            $instancia->crearInstanciaTarea('SUBT02', 'NUEVO', $area);

        }

        return true;
    }
}
