<?php

namespace App\Models\p15_asistencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometrico extends Model
{
    use HasFactory;

    protected $table = "p15_biometricos";
    protected $primaryKey = "biometrico_id";
    protected $fillable = [
        "nombre",
        "acceso",
        "ip",
        "tipo",
        "ubicacion",
        "activo"
    ];
    protected $appends = [
        "ruta_edit"
    ];

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function getRutaEditAttribute()
    {       
        return route("asistencia.catalogo.biometricos.edit", $this);
    }
}
