<?php

namespace App\Models\p23_solicitud_expediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class P23Solicitud extends Model
{
    use HasFactory;

    protected $table = "p23_solicitud";
    protected $primaryKey = "p23_solicitud_id";

    protected $fillable = [
        'estatus', 'folio', 'area_creadora_id'
    ];

    public function indice()
    {
        return $this->belongsTo('App\Models\p23_solicitud_expediente\P23Indice', 'p23_solicitud_id');
    }

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_creadora_id');
    }
}
