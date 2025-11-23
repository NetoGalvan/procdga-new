<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaPagadora extends Model
{
    use HasFactory;

    protected $table = 'zonas_pagadoras';
    protected $primaryKey = 'zona_pagadora_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
