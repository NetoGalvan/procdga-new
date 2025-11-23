<?php

namespace App\Models\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P23Digitalizacion extends Model
{
    use HasFactory;

    protected $table = "p23_digitalizacion";
    protected $primaryKey = "p23_digitalizacion_id";
    protected $fillable = [
        'p23_digitalizacion_id',
        'activo',
        'area_creadora_id',
        'p23_indice_id',
        'fecha_carga',
        'version',
        'created_at',
        'updated_at',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'numero_expediente',
        'expediente_actual',
        'ruta_archivo',
        'nombre_archivo',
        'hash_archivo',
        'creado_por_nombre',
        'creado_por_puesto',
        'archivo_original',
        'subido_por',
        'subido_por_usuario',
        'subido_por_ip',
        'comentarios_eliminacion',
        'creado_por',
        'folio',
        'estatus',
        'numero_empleado',
        'nombre_empleado'
    ];
/*
    protected $fillable = [
        'estatus', 'folio', 'area_creadora_id'
    ];
*/
    public function indice()
    {
        return $this->belongsTo('App\Models\p23_solicitud_expediente\P23Indice', 'p23_digitalizacion_id');
    }

    public function detalleDigitalizacion(){
        return $this->hasMany('App\Models\p23_solicitud_expediente\P23DetalleDigitalizacion', 'p23_digitalizacion_id', 'p23_digitalizacion_id');
    }

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_creadora_id');
    }

    public function getNombreEmpleadoCompletoAttribute()
    {
        return $this->apellido_paterno.' '.$this->apellido_materno.' '.$this->nombre_empleado;
    }
}
