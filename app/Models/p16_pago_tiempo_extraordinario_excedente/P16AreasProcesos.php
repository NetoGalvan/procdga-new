<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P16AreasProcesos extends Model
{
    use HasFactory;

    protected $table = "areas_procesos";
    protected $primaryKey = "areas_procesos_id";
    protected $fillable = ['zona_pagadora'];

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }

    public function proceso()
    {
        return $this->belongsTo('App\Models\Proceso', 'proceso_id');
    }
}
