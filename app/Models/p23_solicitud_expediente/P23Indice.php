<?php

namespace App\Models\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\p23_solicitud_expediente\P23Digitalizacion;

class P23Indice extends Model
{
    use HasFactory;

    protected $table = "p23_indice";
    protected $primaryKey = "p23_indice_id";

    protected $fillable = [
        'area_creadora_id',
        'folio',
        'numero_empleado',
        'nombre_empleado',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'numero_expediente',
        'notas',
        'creado_por',
        'creado_por_nombre',
        'creado_por_puesto',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['nombre_empleado_completo'];

/*
    protected $fillable = [
        'instancia_id', 'folio'
    ];
*/
    public function solicitud(){
        return $this->hasMany('App\Models\p23_solicitud_expediente\P23Solicitud', 'p23_indice_id', 'p23_indice_id');
    }

    public function digitalizacion(){
        return $this->hasMany('App\Models\p23_solicitud_expediente\P23Digitalizacion', 'p23_indice_id', 'p23_indice_id');
    }

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function digitalizacionFolio(){
         return $this->belongsTo('App\Models\p23_solicitud_expediente\P23Digitalizacion', 'folio', 'folio');
    }

    public function getNombreEmpleadoCompletoAttribute()
    {
        return $this->apellido_paterno.' '.$this->apellido_materno.' '.$this->nombre_empleado;
    }

    public function getArchivoExpedienteAttribute()
    {
        $p23 = P23Digitalizacion::where('expediente_actual', true)->where('numero_expediente', $this->numero_expediente)->first();
        return $p23->nombre_archivo ?? '' ;
    }

    public function getEstatusExpedienteAttribute()
    {
        $p23 = P23Digitalizacion::where('expediente_actual', true)->where('numero_expediente', $this->numero_expediente)->first();
        return $p23->estatus;
    }

    public function getVersionExpedienteAttribute()
    {
        $p23 = P23Digitalizacion::where('expediente_actual', true)->where('numero_expediente', $this->numero_expediente)->first();
        return $p23->version ?? '';
    }
}
