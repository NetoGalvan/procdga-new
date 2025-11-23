<?php

namespace App\Models\p11_seleccion_candidatos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesCandidato extends Model
{
    use HasFactory;
    
    protected $table = 'p11_detalles';
    protected $primaryKey = 'detalle_id';

    protected $fillable = ['aceptacion_srio', 'fecha_cita', 'hora_cita', 'lugar_cita'];

    public function seleccionCandidatos()
    {
        return $this->belongsTo('App\Models\p11_seleccion_candidatos\SeleccionCandidatoEstructura','seleccion_candidato_id','seleccion_candidato_id');
    }


    public function candidato()
    {
        return $this->belongsTo('App\Models\p11_seleccion_candidatos\Candidato', 'candidato_id','candidato_id');
    }


}
