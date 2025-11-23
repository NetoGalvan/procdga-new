<?php

namespace App\Models\p07_pago_prestaciones;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoPrestacion extends Model
{
    use HasFactory;
    
    protected $table = 'p07_pago_prestaciones';
    protected $primaryKey = 'pago_prestacion_id';
    protected $fillable = [
        "estatus"
    ];
    
    
    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }
    
    public function instancias()
    {
        return $this->belongsTo('App\Models\Instancia', 'instancia_id','instancia_id');
        
    }
    
    public function subprocesos()
    {
        return $this->hasMany('App\Models\p07_pago_prestaciones\SubProcesoPrestacion', 'pago_prestacion_id');
    }

    public function tipoPrestacion()
    {
        return $this->belongsTo('App\Models\p07_pago_prestaciones\TipoPrestacion','tipo_prestacion_id','tipo_prestacion_id');
    }

    public function getEstructuraConcurrenteAttribute($value)
    {
        return json_decode($value);
    }

    public function getFechaLimiteAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }
}
