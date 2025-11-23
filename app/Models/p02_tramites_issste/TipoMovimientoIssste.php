<?php

namespace App\Models\p02_tramites_issste;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimientoIssste extends Model
{
    use HasFactory;

    protected $table = "tipos_movimientos_issste";
    protected $primaryKey = "tipo_movimiento_issste_id";

    public function P02DetalleIssste()
    {
        return $this->hasOne(TramiteIsssteDetalle::class, 'tipo_movimiento_issste_id', 'tipo_movimiento_issste_id');
    }

}
