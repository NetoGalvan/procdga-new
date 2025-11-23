<?php

namespace App\Models\p19_incentivos_empleado_mes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NivelSalarial;
use App\Models\Area;

class P19Nomina extends Model
{
    use HasFactory;
    protected $table = 'p19_nominas';
    protected $primaryKey = 'p19_nomina_id';
    protected $fillable = [
        'folio',
        'p19_incentivo_id',
        'p19_subproceso_id',
        'numero_empleado',
        'nombre_empleado',
        'apellido_paterno',
        'apellido_materno',
        'id_sindicato',
        'rfc',
        'nivel_salarial',
        'area_id',
        'area',
        'unidad_administrativa',
        'sub_area_id',
        'sub_area',
        'fecha_inicio_evaluacion',
        'fecha_fin_evaluacion',
        'comentarios_admin_incen',
        'nombre_mes',
        'fecha_inicio_siden',
        'fecha_fin_siden',
        'creado_por',
        'creado_por_area',
        'creado_por_nombre_completo',
        'creado_por_titulo',
    ];

    public function incentivo()
    {
        return $this->belongsTo(P19Incentivo::class, 'p19_incentivo_id');
    }

    public function subproceso()
    {
        return $this->belongsTo(P19Subproceso::class, 'p19_subproceso_id');
    }

    public function nivelSalarial()
    {
        return $this->belongsTo(NivelSalarial::class, 'nivel_salarial_id');
    }

    public function areaEmpleado()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function subareaEmpleado()
    {
        return $this->belongsTo(Area::class, 'sub_area_id');
    }

    public function areaCreadora()
    {
        return $this->belongsTo(Area::class, 'creado_por_area', 'area_id');
    }
}
