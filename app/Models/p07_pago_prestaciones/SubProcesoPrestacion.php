<?php

namespace App\Models\p07_pago_prestaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProcesoPrestacion extends Model
{
    use HasFactory;
    
    protected $table = 'p07_subprocesos';
    protected $primaryKey = 'subproceso_id';
    
    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function pagoPrestacion()
    {
        return $this->belongsTo('App\Models\p07_pago_prestaciones\PagoPrestacion', 'pago_prestacion_id');
    }
    
    public function tipoPrestacion()
    {
        return $this->belongsTo('App\Models\p07_pago_prestaciones\TipoPrestacion','tipo_prestacion_id','tipo_prestacion_id');
    }

    public function candidatos()
    {
        return $this->hasMany('App\Models\p07_pago_prestaciones\CandidatoPrestacion', 'subproceso_id');
    }

    public function getEstructuraConcurrenteAttribute($value)
    {
        return json_decode($value);
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }
}
