<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineamiento extends Model
{
    use HasFactory;

    protected $table = "lineamientos";
    protected $primaryKey = "lineamiento_id";
    protected $fillable = [
        "nombre", "identificador", "ruta"
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
