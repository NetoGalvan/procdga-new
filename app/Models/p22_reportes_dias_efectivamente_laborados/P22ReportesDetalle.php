<?php

namespace App\Models\p22_reportes_dias_efectivamente_laborados;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Empleado;

class P22ReportesDetalle extends Model
{
    use HasFactory;

    protected $table = "p22_reporte_detalle";
    protected $primaryKey = "p22_reporte_detalle_id";

    public function reportes()
    {
        return $this->belongsTo('App\Models\p22_reportes_dias_efectivamente_laborados\P22Reportes', 'p22_reporte_detalle_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'elaboro_id');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
