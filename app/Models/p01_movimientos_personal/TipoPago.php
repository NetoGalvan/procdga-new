<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    use HasFactory;

    protected $table = 'tipos_pagos';
    protected $primaryKey = 'tipo_pago_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
