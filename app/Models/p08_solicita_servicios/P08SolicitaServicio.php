<?php

namespace App\Models\p08_solicita_servicios;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P08SolicitaServicio extends Model
{
    protected $primaryKey = "p08_solicita_servicio_id";
    protected $fillable = [
        "estatus",
        "servicio_general_id",
        "servicio_id",
        "tipo_tramite",
        "comentarios_rechazo"
    ];
    protected $appends = ['fecha_solicitud', 'cn', 'nombre_area', 'nombre_servicio_general'];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function detalles()
    {
        return $this->hasMany(P08DetalleSolicitaServicio::class, 'p08_solicita_servicio_id', 'p08_solicita_servicio_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function servicioGeneral()
    {
        return $this->hasOne(ServicioGeneral::class, 'servicio_general_id', 'servicio_general_id');
    }

    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'servicio_id', 'servicio_id');
    }

    public function getFechaSolicitudAttribute()
    {
        return $this->created_at->format('Y-m-d H:m');
    }

    public function getCnAttribute()
    {
        return $this->area ? $this->area->identificador : null;
    }

    public function getNombreAreaAttribute()
    {
        return $this->area ? $this->area->nombre : null;
    }

    public function getNombreServicioGeneralAttribute()
    {
        return $this->servicioGeneral->nombre_servicio_general ?? '';
    }

}

