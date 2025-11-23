<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    use HasFactory;

    protected $table = 'firmas';
    protected $primaryKey = 'firma_id';
    protected $fillable = [
        'cadena_original',
        'folio_consulta',
        'nombre_completo',
        'rfc',
        'sello',
        'fecha_firma',
        'ruta_firma',
        'tipo_firma_id',
        'usuario_id',
        'rol_id'
    ];

    public function model() 
    {
        return $this->morphTo();
    }
    
    public function usuario() 
    {
        return $this->morphTo();
    }
}
