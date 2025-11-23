<?php

namespace App\Models\p31_viatinet;

use Illuminate\Database\Eloquent\Model;

class ComisionadoPartida extends Model
{
    protected $table = 'p31_comisionado_partida';
    protected $primaryKey = 'comisionado_partida_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partida_id', 'comisionado_id', 'monto_total_partida', 'origen_inicial', 'destino',
        'origen_final', 'servicios'
    ];

}
