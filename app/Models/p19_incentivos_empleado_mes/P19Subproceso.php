<?php

namespace App\Models\p19_incentivos_empleado_mes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P19Subproceso extends Model
{
    use HasFactory;

    protected $table = 'p19_subprocesos';
    protected $primaryKey = 'p19_subproceso_id';
    protected $fillable = [
        'folio',
        'p19_incentivo_id',
        'estatus',
        'comentarios_sub_ea',
        'tabla_concurrente',
        'estructura_concurrente',
        'instancia_padre_id',
        'folio_padre',
        'nombre_quincena',
        'fecha_inicio_pago',
        'fecha_fin_pago',
        'comentarios_opera_incen',
        'creado_por',
        'creado_por_area',
        'creado_por_nombre_completo',
        'creado_por_titulo',
    ];

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function instanciaPadre()
    {
        return $this->belongsTo('App\Models\Instancia', 'instancia_id', 'instancia_padre_id');
    }

    public function incentivo()
    {
        return $this->belongsTo(P19Incentivo::class, 'p19_incentivo_id');
    }

    public function nominas()
    {
        return $this->hasMany(P19Nomina::class, 'p19_subproceso_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'area_id');
    }

    public function areaCreadora()
    {
        return $this->belongsTo(Area::class, 'area_id', 'creado_por_area');
    }

    public function getEstructuraConcurrenteAttribute($value)
    {
        return json_decode($value);
    }
}
