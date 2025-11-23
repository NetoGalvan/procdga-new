<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P06AreasAdscripcion extends Model
{
    use HasFactory;

    protected $table = "p06_areas_adscripcion";
    protected $primaryKey = "area_adscripcion_id";

    protected $fillable = [
        'nombre_area_adscripcion', 
        'direccion_area_adscripcion',
        'activo',
        'created_at',
        'updated_at'
    ];

    public function areaAdscripcion() {
        return $this->hasMany('App\Models\p06_servicio_social\P06ServicioSocial', 'area_adscripcion_id');
    }
}
