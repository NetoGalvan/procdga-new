<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alfabetico extends Model
{
    use HasFactory;

    protected $table = "alfabeticos";
    protected $primaryKey = "alfabetico_id";
    protected $fillable = [
        "estatus",
        "folio",
        "quincena",
        "activo",
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function archivo()
    {
        return $this->hasOne(AlfabeticoArchivo::class, 'alfabetico_id', 'alfabetico_id');
    }

    public function archivoSinJson()
    {
        return $this->hasOne(AlfabeticoArchivo::class, 'alfabetico_id', 'alfabetico_id')
                    ->select(['archivo_id', 'nombre_archivo', 'cantidad_empleados', 'fecha_carga', 'cargado_por_usuario', 'area_id']);
    }

}
