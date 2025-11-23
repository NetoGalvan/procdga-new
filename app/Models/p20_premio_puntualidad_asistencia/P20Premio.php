<?php

namespace App\Models\p20_premio_puntualidad_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P20Premio extends Model
{
    use HasFactory;

    protected $table = "p20_premio";
    protected $primaryKey = "p20_premio_id";

    protected $fillable = [
        'instancia_id', 'estatus', 'folio', 'area_creadora_id'
    ];

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function unidadAdministrativa() {
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function subproceso(){
        return $this->hasMany('App\Models\p20_premio_puntualidad_asistencia\P20SubprocesoNomina', 'p20_premio_id', 'p20_premio_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_creadora_id');
    }
}
