<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogLocal extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'log_id';
    protected $fillable = [
        "tipo",
        "modulo",
        "mensaje",
        "datos_extra",
    ];
}
