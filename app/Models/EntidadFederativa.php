<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadFederativa extends Model
{
    use HasFactory;
    
    protected $table = 'entidades_federativas';
    protected $primaryKey = 'entidad_federativa_id';

    public function servicioSocial()
    {
        return $this->hasOne('App\Models\p06_servicio_social\P06ServicioSocial', 'entidad_federativa_id');
    }
    
    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function municipios() 
    {
        return $this->hasMany(Municipio::class, "entidad_federativa_id")->where("activo", true);
    }
}
