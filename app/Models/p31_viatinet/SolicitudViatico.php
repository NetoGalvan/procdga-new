<?php

namespace App\Models\p31_viatinet;

use App\Models\Area;
use App\Models\Documento;
use App\Models\Instancia;
use Illuminate\Database\Eloquent\Model;

class SolicitudViatico extends Model
{
    protected $table = 'p31_solicitudes_viaticos';
    protected $primaryKey = 'solicitud_viatico_id';
    protected $fillable = [ 
        'estatus',
        'folio',
        'area_id',
        'lugar_zona_tarifaria_id',
        'tipo_financiamiento_id',
        'porcentaje_financiamiento',
        'tipo_cambio',
        'dias',
        'fecha_inicio',
        'fecha_final',
        'motivo_comision',
        'motivo_rechazado'
    ];

    public function scopeActivo($query) 
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne(Instancia::class, 'model');
    }

    public function documentos()
    {
        return $this->morphMany(Documento::class, 'model');
    }

    function area() 
    {
        return $this->belongsTo(Area::class, 'area_id');
    } 
    
    function lugarZonaTarifaria() 
    {
        return $this->belongsTo(LugarZonaTarifaria::class, 'lugar_zona_tarifaria_id');
    } 
    
    public function comisionados() {
        return $this->hasMany(Comisionado::class, 'solicitud_viatico_id');
    }

    public function updateEstatus($estatus) {
        $this->estatus = $estatus;
        return $this->save();
    }
}
