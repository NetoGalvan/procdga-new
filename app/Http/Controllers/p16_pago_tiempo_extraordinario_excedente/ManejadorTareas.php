<?php

namespace App\Http\Controllers\p16_pago_tiempo_extraordinario_excedente;
use App\Models\Proceso;
use App\Models\Instancia;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16SubProcesoPagoTiempoExtraExcedente;
use App\Models\p16_pago_tiempo_extraordinario_excedente\P16HorasPorEmpleado;
use Illuminate\Support\Facades\DB;
use App\Models\InstanciaTarea;

trait ManejadorTareas {

    public function finalizarTareasTodosSubprocesos($pago) {
        try {
            DB::beginTransaction();
                $instancia = $pago->instancia;
                $subInstancias = $instancia->subInstancias->where('model.estatus', 'EN_PROCESO');

                $id_instancias = [];
                $folio_subprocesos = [];

                foreach ($subInstancias as $value) {
                    $id_instancias []= $value->instancia_id;
                    $folio_subprocesos []= $value->folio;
                }

                foreach ($id_instancias as $instancia) {
                    InstanciaTarea::where('instancia_id', $instancia )->whereIn('estatus', ["NUEVO", "EN_CORRECCION"])
                    ->update([ 'estatus' => 'CANCELADO',
                                'motivo_rechazo' => 'CANCELACIÓN AUTOMATICA DESDE T02 POR NO CONCLUIR LAS SUBTAREAS - REVISAR HORAS EMPLEADO' ]);
                }

                foreach ($folio_subprocesos as $folio) {
                    P16SubProcesoPagoTiempoExtraExcedente::where('folio', $folio )->where('estatus', "EN_PROCESO")
                    ->update([ 'estatus' => 'CANCELADO' ]);

                    P16HorasPorEmpleado::where('folio', $folio)->delete();
                }

            DB::commit();

            return [ 'estatus' => true ];
        } catch (\Throwable $th) {

            DB::rollback();
            return [ 'estatus' => false, 'mensaje' => 'Error: ' . $th ];
        }
    }
}
