<?php

namespace App\Models\p01_movimientos_personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegimenIssste extends Model
{
    use HasFactory;

    protected $table = 'regimenes_issste';
    protected $primaryKey = 'regimen_issste_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }
}
