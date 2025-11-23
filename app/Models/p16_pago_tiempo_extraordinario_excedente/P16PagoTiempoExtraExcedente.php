<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P16PagoTiempoExtraExcedente extends Model
{
    use HasFactory;

    protected $table = "p16_pago_tiempo_extra_excedente";
    protected $primaryKey = "pago_tiempo_extra_excedente_id";
    protected $fillable = [
        "estatus", "folio", "area_id", "fecha_limite"
    ];

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function subprocesos()
    {
        return $this->hasMany(P16SubProcesoPagoTiempoExtraExcedente::class, 'pago_tiempo_extra_excedente_id');
    }

    public function presupuestoQuincenalAreas()
    {
        return $this->hasMany(P16PresupuestoQuincenalAreas::class, 'pago_tiempo_extra_excedente_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
