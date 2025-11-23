<?php

namespace App\Models\p11_seleccion_candidatos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeleccionCandidatoEstructura extends Model
{
    use HasFactory;

    protected $table = 'p11_seleccion_candidatos';
    protected $primaryKey = 'seleccion_candidato_id';

    protected $fillable = [];

    public function detallesCandidatos(){
        return $this->hasMany(DetallesCandidato::class,  'seleccion_candidato_id');
    }

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function plaza()
    {
        return $this->belongsTo('App\Models\p24_directorio\Plaza', 'plaza_id');
    }

    public function getDetalleCandidatos($candidatoId)
    {
        return DetallesCandidato::where([
            ['candidato_id', '=', $candidatoId],
            ['seleccion_candidato_id', '=', $this->seleccion_candidato_id]
        ])->first();
    }

    public function getCandidatos($candidatoId)
    {

//         dd($candidatoId);
        return Candidato::where([
            ['candidato_id', '=', $candidatoId]

        ])->first();
    }
    public function codigoMovimiento()
    {
        return $this->belongsTo('App\Models\p01_movimientos_personal\CodigoMovimiento', 'codigo_de_movimiento_id');
    }


}
