<?php

namespace App\Models\p02_tramites_issste;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNombramiento extends Model
{
    use HasFactory;
    
    protected $table = "tipos_nombramientos_issste";
    protected $primaryKey = "tipo_nombramiento_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_nombramiento', 'valor_tipo_nombramiento'
    ];

    function TramiteIsssteDetalle() {
        return $this->belongsTo('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tipo_nombramiento_id', 'tipo_nombramiento_id');
    }

}
