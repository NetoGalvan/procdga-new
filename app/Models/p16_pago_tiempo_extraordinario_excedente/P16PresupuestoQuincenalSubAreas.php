<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P16PresupuestoQuincenalSubAreas extends Model
{
    use HasFactory;

    protected $table = "p16_presupuesto_quincenal_subareas";
    protected $primaryKey = "p16_presupuesto_quincenal_subareas_id";
    protected $fillable = ['presupuesto_sub_area'];

    public function subProcesoTiempoExtra()
    {
        return $this->belongsTo(\App\Models\p16_pago_tiempo_extraordinario_excedente\P16SubProcesoPagoTiempoExtraExcedente::class, 'subproceso_pago_tiempo_extra_excedente_id');
    }

    public function subproceso()
    {
        return $this->belongsTo(P16SubProcesoPagoTiempoExtraExcedente::class, 'subproceso_pago_tiempo_extra_excedente_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function empleados()
    {
        return $this->HasMany(P16HorasPorEmpleado::class, 'p16_presupuesto_quincenal_subareas_id');
    }
}
