<?php

namespace App\Models\p07_pago_prestaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class CandidatoPrestacion extends Model
{
    use HasFactory;

    protected $table = 'p07_candidatos_prestaciones';
    protected $primaryKey = 'candidato_prestacion_id';

    public function subproceso()
    {
        return $this->belongsTo('App\Models\p07_pago_prestaciones\SubProcesoPrestacion', 'subproceso_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function usuarioCapturo()
    {
        return $this->hasOne('App\Models\User', 'id', 'usuario_capturo_id');
    }

    public function usuarioAutorizo()
    {
        return $this->hasOne('App\Models\User', 'id', 'usuario_autorizo_id');
    }

    public function getCamposAdicionalesAttribute($value)
    {
        return json_decode($value);
    }
}
