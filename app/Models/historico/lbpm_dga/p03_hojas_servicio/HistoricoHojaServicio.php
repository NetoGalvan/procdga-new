<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
namespace App\Models\historico\lbpm_dga\p03_hojas_servicio;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\HistoricoInstancia;
use Carbon\Carbon;

class HistoricoHojaServicio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p03_hoja_de_servicio";
    protected $appends = [ 'p03_hoja_servicio_id', 'folio', 'primer_apellido', 'segundo_apellido', 'nombre_entidad', 'fecha_creacion_hoja_servicio'];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function detallesBajas()
    {
        return $this->hasMany(HistoricoDetalle::class, 'p03_id', 'p03_id')->where('tipo_detalle', 'BAJA');
    }

    public function detallesAportaciones()
    {
        return $this->hasMany(HistoricoDetalle::class, 'p03_id', 'p03_id')->where('tipo_detalle', 'APORTACION');
    }

    public function detalles()
    {
        return $this->hasMany(HistoricoDetalle::class, 'p03_id', 'p03_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(HistoricoSeguimiento::class, 'p03_id', 'p03_id');
    }

    public function getP03HojaServicioIdAttribute()
    {
        return $this->p03_id;
    }

    public function getFolioAttribute()
    {
        return $this->folio_contrasena;
    }

    public function getPrimerApellidoAttribute()
    {
        return $this->apellido_paterno;
    }

    public function getSegundoApellidoAttribute()
    {
        return $this->apellido_materno;
    }

    public function getNombreEntidadAttribute()
    {
        return $this->entidad;
    }

    public function getFechaCreacionHojaServicioAttribute()
    {
        return Carbon::parse($this->instancia->created_on)->format('d-m-Y');
    }
}
