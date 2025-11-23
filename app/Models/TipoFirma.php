<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFirma extends Model
{
    use HasFactory;

    protected $table = 'tipos_firmas';
    protected $primaryKey = 'tipo_firma_id';

}
