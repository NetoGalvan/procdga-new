<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $table = 'manuales';
    protected $primaryKey = 'manual_id';
    protected $fillable = [
        'proceso_id', 'nombre', 'identificador', 'descripcion', 'ruta'
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function proceso()
    {
        return $this->belongsTo('App\Models\Proceso', 'proceso_id');
    }
}
