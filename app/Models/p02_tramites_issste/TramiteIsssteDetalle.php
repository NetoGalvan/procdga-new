<?php

namespace App\Models\p02_tramites_issste;

use App\Models\EntidadFederativa;
use App\Models\p01_movimientos_personal\MovimientoPersonal;
use App\Models\p01_movimientos_personal\TipoMovimiento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramiteIsssteDetalle extends Model
{
    use HasFactory;

    protected $table = "p02_detalles";
    protected $primaryKey = "detalle_id";
    protected $fillable = [
        'tramite_issste_id', 'folio_p01', 'nombre_empleado', 'apellido_paterno', 'apellido_materno',
        'calle', 'ciudad', 'colonia', 'cp', 'numero_exterior', 'numero_interior', 'curp',
        'homoclave', 'rfc', 'fecha_nacimiento', 'municipio_alcaldia', 'fecha_alta', 'fecha_baja', 'numero_empleado', 'numero_seguridad_social',
        'pagaduria', 'qna_procesado', 'estatus_issste', 'entidad_federativa_domicilio_id', 'abreviatura_entidad_domicilio',
        'nombre_entidad_domicilio', 'identificador_entidad_federativa_domicilio', 'entidad_federativa_nacimiento_id',
        'abreviatura_entidad_nacimiento', 'nombre_entidad_nacimiento', 'identificador_entidad_federativa_nacimiento',
        'sexo_id', 'tipo_nombramiento_id', 'nombramiento_issste', 'identificador_nombramiento_issste',
        'tipo_movimiento_id', 'tipo_movimiento', 'descripcion_movimiento', 'tipo_movimiento',
        'motivo_rechazo', 'clave_cobro', 'clave_ramo', 'guia', 'fecha_modificacion', 'fecha_recepcion',
        'fecha_registro', 'qna_issste', 'sueldo_cotizable', 'sueldo_sar', 'sueldo_total', 'listo',
        'nivel_salarial_id', 'tipo_movimiento_issste_id'
    ];
    protected $appends = ["anio", "nombre_unidad", "tipo_movimiento_issste_nombre"];

    public function tramiteIssste()
    {
        return $this->belongsTo(TramiteIssste::class, 'tramite_issste_id');
    }

    public function entidadFederativaNacimiento()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_nacimiento_id', 'entidad_federativa_id');
    }

    public function entidadFederativaDomicilio()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_domicilio_id');
    }

    public function tipoNombramiento()
    {
        return $this->belongsTo(TipoNombramiento::class, 'tipo_nombramiento_id');
    }

    public function tipoMovimientoIssste()
    {
        return $this->belongsTo(TipoMovimientoIssste::class, 'tipo_movimiento_issste_id');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }

    public function movimientoPersonal() {
        return $this->hasOne(MovimientoPersonal::class, "folio", "folio_p01");
    }

    public function getAnioAttribute() {
        $year = date('Y', strtotime($this->created_at));
        return $year;
    }

    public function getNombreUnidadAttribute() {
        return  $this->movimientoPersonal ? $this->movimientoPersonal->area->nombre : null;
    }

    public function getTipoMovimientoIsssteNombreAttribute() {
        return $this->tipoMovimientoIssste->nombre;
    }

}
