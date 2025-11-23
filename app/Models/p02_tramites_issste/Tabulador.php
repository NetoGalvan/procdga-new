<?php

namespace App\Models\p02_tramites_issste;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabulador extends Model
{
    use HasFactory;
    
    protected $table = "p02_tabuladores";
    protected $primaryKey = "p02_tabulador_id";

    public function detalles()
    {
        return $this->hasMany('app\Models\p02_tramites_issste\TramiteIsssteDetalle');
    }

}
