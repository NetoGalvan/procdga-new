<?php

namespace App\Models\historico\lbpm_dga\p08_solicita_servicios;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\historico\lbpm_dga\HistoricoInstancia;

class HistoricoSolicitaServicio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p080910_servicios";
    protected $appends = ['p08_solicita_servicio_id', 'fecha_solicitud', 'estatus', 'cn', 'nombre_area', 'nombre_servicio_general', 'sub_area'];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function detalles()
    {
        return $this->hasMany(HistoricoSolicitaServicioDetalle::class, 'id_solicitud', 'id_solicitud');
    }

    public function getP08SolicitaServicioIdAttribute()
    {
        return $this->id_solicitud;
    }

    public function getFechaSolicitudAttribute()
    {
        return Carbon::parse($this->instancia->created_on)->format('Y-m-d H:m');
    }

    public function getEstatusAttribute()
    {
        $estatus = [
            "NEW" => "NUEVO",
            "PROPOSED" => "PROPUESTO",
            "REJECTED" => "RECHAZADO",
            "ACCEPTED" => "COMPLETADO",
            "DELIVERY_FAIL" => "ENVIO_RECHAZADO",
            "DELIVERY_OK" => "COMPLETADO",
        ];
        return $estatus[$this->status_solicitud];
    }

    public function getCnAttribute()
    {
        return $this->id_unidad_admva;
    }

    public function getNombreAreaAttribute()
    {
        return $this->nombre_unidad_admva;
    }

    public function getNombreServicioGeneralAttribute()
    {
        $tipoServicio = [
            "mantenimiento" => "Servicios y mantenimiento",
            "reproduccion" => "Servicio de reproducción de formatos, guillotina y engargolado",
            "telefonia" => "Servicios telefónicos",
            "vehiculos" => "Servicio de transporte de bienes o personal",
            "otros" => ""
        ];

        return $tipoServicio[$this->tipo_solicitud];
    }

    public function getSubAreaAttribute()
    {
        return $this->area_servicio;
    }
}
