<?php

namespace App\Models\p08_solicita_servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primarykey = 'servicio_id';

    public function scopeActivo($query) 
    {
        return $query->where('activo', true);
    }
}
