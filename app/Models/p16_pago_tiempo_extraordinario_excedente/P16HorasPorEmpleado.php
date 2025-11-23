<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P16HorasPorEmpleado extends Model
{
    use HasFactory;

    protected $table = "p16_horas_por_empleado";
    protected $primaryKey = "horas_empleado_id";

    protected $fillable = [
        'subproceso_pago_tiempo_extra_excedente_id',
        'p16_presupuesto_quincenal_subareas_id',
        'unidad_administrativa_id',
        'unidad_administrativa_nombre',
        'folio',
        'rfc',
        'tipo',
        'numero_empleado',
        'nombre_empleado',
        'apellido_paterno',
        'apellido_materno',
        'nivel_salarial',
        'sindicalizado',
        'codigo_puesto',
        'horas',
        'monto_bruto',
        'observaciones'];




    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id','id');
    }

    public function presupuestoSubarea()
    {
        return $this->belongsTo(P16PresupuestoQuincenalSubAreas::class, 'p16_presupuesto_quincenal_subareas_id');
    }
}
