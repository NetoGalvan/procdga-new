<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P16PresupuestoQuincenalAreas extends Model
{
    use HasFactory;

    protected $table = "p16_presupuesto_quincenal_areas";
    protected $primaryKey = "p16_presupuesto_quincenal_area_id";
    protected $fillable = ['presupuesto','folio'];

    public function pagoTiempoExtra()
    {
        return $this->belongsTo(\App\Models\p16_pago_tiempo_extraordinario_excedente\P16PagoTiempoExtraExcedente::class, 'pago_tiempo_extra_excedente_id');
    }
}
