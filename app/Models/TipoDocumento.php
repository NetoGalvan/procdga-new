<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipos_documentos';
    protected $primaryKey = 'tipo_documento_id';

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    public function scopeGrupo($query, $grupo) {
        return $query->where('nombre_grupo', $grupo);
    }
}
