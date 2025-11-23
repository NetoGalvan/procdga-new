<?php

namespace App\Models\p19_incentivos_empleado_mes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P19Incentivo extends Model
{
    use HasFactory;

    protected $table = 'p19_incentivos';
    protected $primaryKey = 'p19_incentivo_id';
    protected $fillable = [
        'estatus',
        'nombre_quincena',
        'fecha_inicio_pago',
        'fecha_fin_pago',
        'comentarios_opera_incen',
        'numero_documento',
        'premios_aprobados',
        'firmas',
        'tabla_concurrente',
        'estructura_concurrente',
        'fecha_subproceso_inicio',
        'fecha_subproceso_finalizo',
        'creado_por',
        'creado_por_area',
        'creado_por_nombre_completo',
        'creado_por_titulo',
    ];

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function instancias()
    {
        return $this->belongsTo('App\Models\Instancia', 'instancia_id','instancia_id');
    }

    public function subprocesosEnProceso()
    {
        return $this->hasMany(P19Subproceso::class, 'p19_incentivo_id')->where('estatus', 'EN_PROCESO');
    }

    public function subprocesos()
    {
        return $this->hasMany(P19Subproceso::class, 'p19_incentivo_id');
    }

    public function nominas()
    {
        return $this->hasMany(P19Nomina::class, 'p19_incentivo_id');
    }

    public function areaCreadora()
    {
        return $this->belongsTo(Area::class, 'creado_por_area', 'area_id');
    }

    public function getEstructuraConcurrenteAttribute($value)
    {
        return json_decode($value);
    }
}
