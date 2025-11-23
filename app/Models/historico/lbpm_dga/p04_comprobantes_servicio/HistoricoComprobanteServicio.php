<?php

namespace App\Models\historico\lbpm_dga\p04_comprobantes_servicio;

use Illuminate\Database\Eloquent\Model;
use App\Models\historico\lbpm_dga\HistoricoInstancia;
use Carbon\Carbon;

class HistoricoComprobanteServicio extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "p04_comprobante_de_servicio";
    protected $appends = [ 'p04_comprobante_servicio_id', 'folio', 'primer_apellido', 'segundo_apellido', 'nombre_entidad', 'fecha_creacion_comprobante_servicio', 'nombre_verifica', 'puesto_verifica', 'nombre_unidad'];

    public function instancia()
    {
        return $this->belongsTo(HistoricoInstancia::class, 'id_instance');
    }

    public function detalles()
    {
        return $this->hasMany(HistoricoDetalle::class, 'p04_id', 'p04_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(HistoricoSeguimiento::class, 'p04_id', 'p04_id');
    }

    public function getP04ComprobanteServicioIdAttribute()
    {
        return $this->p04_id;
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

    public function getFechaCreacionComprobanteServicioAttribute()
    {
        return Carbon::parse($this->instancia->created_on)->format('d-m-Y');
    }

    public function getNombreVerificaAttribute()
    {
        return $this->nombre_revisa;
    }

    public function getPuestoVerificaAttribute()
    {
        return $this->puesto_revisa;
    }

    public function getNombreUnidadAttribute()
    {
        return $this->unidad_administrativa;
    }

}
