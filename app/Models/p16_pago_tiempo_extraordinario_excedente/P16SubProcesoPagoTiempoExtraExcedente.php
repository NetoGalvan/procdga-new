<?php


namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P16SubProcesoPagoTiempoExtraExcedente extends Model
{
    use HasFactory;

    protected $table = "p16_subproceso_pago_tiempo_extra_excedente";
    protected $primaryKey = "subproceso_pago_tiempo_extra_excedente_id";

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function pagoTiempoExtra()
    {
        return $this->belongsTo(P16PagoTiempoExtraExcedente::class, 'pago_tiempo_extra_excedente_id');
    }

    public function presupuestoQuincenalArea()
    {
        return $this->HasOne(P16PresupuestoQuincenalAreas::class, 'subproceso_pago_tiempo_extra_excedente_id');
    }

    public function presupuestoQuincenalSubAreas()
    {
        return $this->hasMany(P16PresupuestoQuincenalSubAreas::class, 'subproceso_pago_tiempo_extra_excedente_id');
    }

    public function horasEmpleados()
    {
        return $this->hasMany(P16HorasPorEmpleado::class, 'subproceso_pago_tiempo_extra_excedente_id')->orderBy('horas_empleado_id', 'desc');;
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }


}
