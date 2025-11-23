<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $table = 'bancos';
    protected $primaryKey = 'banco_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
