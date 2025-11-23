<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universo extends Model
{
    use HasFactory;

    protected $table = 'universos';
    protected $primaryKey = 'universo_id';

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function getNombreUniversoAttribute($value)
    {
        return mb_strtoupper($value);
    }
}
