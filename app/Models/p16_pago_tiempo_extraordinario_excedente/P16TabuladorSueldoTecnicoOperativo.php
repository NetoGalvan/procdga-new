<?php

namespace App\Models\p16_pago_tiempo_extraordinario_excedente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P16TabuladorSueldoTecnicoOperativo extends Model
{
    use HasFactory;

    protected $table = "p16_tabulador_calcular_tiempo_extra";
    protected $primaryKey = "tabulador_calcular_tiempo_extra_id";
    /**
     * Regresa una coleccion con los sueldos de acuerdo al año solicitado
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $anio   año a filtrar
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYear($query, $year)
    {
        return $query->where('anio', $year);
    }
    /**
     * Regresa una coleccion con los sueldos de acuerdo al año, nivel salarial y tipo
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $anio año a buscar
     * @param  int  $nivel_salarial nivel salarial a buscar
     * @param  string  $tipo tipo de empleado a buscar
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExiste($query, $anio, $nivel_salarial, $tipo)
    {
        return $query->where('anio', $anio)
            ->where('nivel_salarial', $nivel_salarial)
            ->where('tipo', $tipo);
    }
}
