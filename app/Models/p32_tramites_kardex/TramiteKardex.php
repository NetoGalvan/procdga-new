<?php

namespace App\Models\p32_tramites_kardex;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\EntidadFederativa;
use App\Models\User;

class TramiteKardex extends Model
{
    use HasFactory;

    protected $table = "p32_tramites_kardex";
    protected $primaryKey = "tramite_kardex_id";
    protected $fillable = [
        "estatus",
        "tipo_tramite_kardex_id",
        "revisado_por_usuario",
        "autorizado_por_usuario",
        "asignado_a_usuario",
        "observaciones",
        "area_id",
        "puesto",
        "codigo_puesto",
        "nivel_salarial",
        "campos_extra",
        "unidad_administrativa",
        "unidad_administrativa_nombre",
        "firmas",
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function tipoTramiteKardex()
    {
        return $this->hasOne(TipoTramiteKardex::class, 'tipo_tramite_kardex_id', 'tipo_tramite_kardex_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function entidad()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_id');
    }

    public function revisadoPorUsuario()
    {
        return $this->hasOne(User::class, 'id', 'revisado_por_usuario');
    }

    public function autorizadoPorUsuario()
    {
        return $this->hasOne(User::class, 'id', 'autorizado_por_usuario');
    }

    public function asignadoAUsuario()
    {
        return $this->hasOne(User::class, 'id', 'asignado_a_usuario');
    }

}
