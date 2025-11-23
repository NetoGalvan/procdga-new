<?php

namespace App\Models\p21_premio_administracion;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\p21_premio_administracion\PremioAdministracion;

class P21Inscripcion extends Model
{
    use HasFactory;

    protected $table = "p21_inscripcion";
    protected $primaryKey = "p21_inscripcion_id";

    protected $fillable = [
        'estatus',
        'folio',
        'p21_premio_id',
        'area_id',
        'area_creadora_id',
        'creado_por',
        'creado_por_area',
        'creado_por_area_nombre',
        'creado_por_titulo',
        'activo',
        'comentarios_oper_cap_21',
        'creado_por',
        'creado_por_area',
        'creado_por_area_nombre',
        'creado_por_titulo',
        'area_creadora_id',
        'evaluado_por',
        'evaluado_por_area',
        'evaluado_por_area_nombre',
        'evaluado_por_titulo',
        'evaluado_fecha',
        'validado_por',
        'validado_por_area',
        'validado_por_area_nombre',
        'validado_por_titulo',
        'validado_fecha',
        'json_cursos'
    ];

    public function premioAdministracion()
    {
        return $this->belongsTo(PremioAdministracion::class, 'p21_premio_id');
    }

    public function candidatosPremio(){
        return $this->hasMany(P21CandidatosPremio::class, 'p21_inscripcion_id', 'p21_inscripcion_id');
    }

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
