<?php

namespace App\Models\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\User;

class P22Reportes extends Model
{
    use HasFactory;

    protected $table = "p22_reporte";
    protected $primaryKey = "p22_reporte_id";

    protected $fillable = [
        'estatus', 'folio', 'area_creadora_id'
    ];

    public function instancia(){
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function reportesDetalle(){
        return $this->hasMany('App\Models\p22_reportes_dias_efectivamente_laborados\P22ReportesDetalle', 'p22_reporte_id', 'p22_reporte_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'elaboro_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_creadora_id');
    }
}
