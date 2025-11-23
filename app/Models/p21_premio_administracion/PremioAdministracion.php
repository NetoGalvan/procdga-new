<?php

namespace App\Models\p21_premio_administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\p21_premio_administracion\P21Inscripcion;
use App\Models\p21_premio_administracion\P21CandidatosPremio;

class PremioAdministracion extends Model
{
    use HasFactory;

    protected $table = "p21_premio";
    protected $primaryKey = "p21_premio_id";

    protected $fillable = [
        'instancia_id',
        'estatus',
        'folio',
        'area_creadora_id',
        'creado_por',
        'creado_por_area',
        'creado_por_area_nombre',
        'creado_por_titulo',
    ];

    public function candidatosPremio(){
        return $this->hasMany(P21CandidatosPremio::class, 'p21_premio_id', 'p21_premio_id');
    }

    public function candidatosPremioEstatusSolicitado(){
        return $this->hasMany(P21CandidatosPremio::class, 'p21_premio_id', 'p21_premio_id')->where('estatus_declinacion', 'SOLICITADO');
    }

    public function inscripcion(){
        return $this->hasOne(P21Inscripcion::class, 'p21_premio_id', 'p21_premio_id');
    }

    public function inscripciones(){
        return $this->hasMany(P21Inscripcion::class, 'p21_premio_id', 'p21_premio_id');
    }

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function unidadAdministrativa() {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function areacreadora()
    {
        return $this->belongsTo(Area::class, 'area_creadora_id');
    }
}
