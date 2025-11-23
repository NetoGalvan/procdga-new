<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    use HasFactory;
    
    protected $table = 'codigos_postales';
    protected $primaryKey = 'codigo_postal_id';

    public function getAsentamientoAttribute($value)
    {
        return mb_strtoupper($value);
    }
}
