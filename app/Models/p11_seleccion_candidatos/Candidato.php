<?php

namespace App\Models\p11_seleccion_candidatos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;
    
    protected $table = 'p11_candidatos';
    protected $primaryKey = 'candidato_id';


    public function detalles()
    {
        return $this->belongsTo('App\Models\p11_seleccion_candidatos\DetallesCandidato', 'instancia_id','instancia_id');
        
    }
    
    public function estadoCivil()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\EstadoCivil', 'estado_civil_id','estado_civil_id');
    }
    
    public function sexo()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\Sexo', 'sexo_id','sexo_id');
    }
}
