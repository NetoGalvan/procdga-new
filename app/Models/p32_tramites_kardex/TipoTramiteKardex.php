<?php

namespace App\Models\p32_tramites_kardex;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTramiteKardex extends Model
{
    use HasFactory;

    protected $table = "p32_tipos_tramite_kardex";
    protected $primaryKey = "tipo_tramite_kardex_id";

    public function scopeActivo($query) {
        return $query->where('activo', true);
    }

    function tramiteKardex() {
        return $this->belongsTo(TramiteKardex::class, 'tipo_tramite_kardex_id', 'tipo_tramite_kardex_id');
    }
}
