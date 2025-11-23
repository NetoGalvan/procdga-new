<?php

namespace App\Models\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P23DetalleDigitalizacion extends Model
{
    use HasFactory;

    protected $table = "p23_detalle_digitalizacion";
    protected $primaryKey = "p23_detalle_digitalizacion_id";

    protected $fillable = [
        'p23_digitalizacion_id',
        'area_creadora_id',
        'folio_prestamo_fisico',
        'creado_por',
        'creado_por_nombre',
        'creado_por_puesto',
        'folio',
        'documento',
        'hojas'
    ];

    public function digitalizacion()
    {
        return $this->belongsTo('App\Models\p23_solicitud_expediente\P23Digitalizacion', 'p23_detalle_digitalizacion_id');
    }

}
