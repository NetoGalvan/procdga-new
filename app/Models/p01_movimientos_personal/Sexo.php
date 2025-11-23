<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;

    protected $table = 'sexos';
    protected $primaryKey = 'sexo_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
