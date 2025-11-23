<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06DetalleArchivos extends Model
{
    use HasFactory;

    protected $table = "p06_detalle_archivos";
    protected $primaryKey = "detalle_archivo_id";

    protected $fillable = [
        'servicio_social_id',
        'ruta_archivo',
    ];

    public function detalleArchivos(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06ServicioSocial', 'detalle_archivo_id');
    }
}
