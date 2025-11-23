<?php

namespace App\Models\p02_tramites_issste;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramiteIssste extends Model
{
    use HasFactory;

    protected $table = "p02_tramites_issste";
    protected $primaryKey = "tramite_issste_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instancia_id', 'estatus', 'folio'
    ];
    protected $casts = [
        'created_at' => "datetime:d-m-Y - H:i:s",
        'updated_at' => "datetime:d-m-Y - H:i:s",
    ];

    public function instancia()
    {
        return $this->morphOne('App\Models\Instancia', 'model');
    }

    public function detalles()
    {
        return $this->hasMany('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tramite_issste_id')->whereIn('estatus_issste', ['EN_PROCESO', 'LISTO'])->orderBy('detalle_id', 'desc');
    }

    public function detallesRechazados()
    {
        return $this->hasMany('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tramite_issste_id', 'tramite_issste_id')->where('estatus_issste', 'RECHAZADO')->orderBy('detalle_id', 'desc');
    }

    public function detallesAlta()
    {
        // Esta relación se usa para mostrar los datos en la Tabla de Archivos para ISSSTE
        // Y se usa para generar el Excel, *NOTA: Debe estas alineados los atributos a DetallesArchivoIsssteExport ya que se muestran los datos tal cual como se obtiene y se alinean a las cabeceras de esta clase
        return $this->hasMany('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tramite_issste_id', 'tramite_issste_id')
                ->where('tipos_movimientos_issste.nombre', 'ALTA')
                ->whereIn('estatus_issste', ['LISTO'])
                ->select('apellido_paterno', 'apellido_materno', 'nombre_empleado', 'rfc', 'curp',
                'fecha_nacimiento', 'sexos.nombre as sexo', 'fecha_registro', 'sueldo_cotizable', 'tipos_nombramientos_issste.nombre as tipo_nombramiento_issste',
                'calle', 'numero_exterior', 'numero_interior', 'colonia', 'cp', 'clave_ramo', 'pagaduria', 'guia',
                'fecha_recepcion', 'numero_seguridad_social', 'entidades_federativas.nombre as entidad_federativa', 'sueldo_sar', 'sueldo_total',
                'clave_cobro', 'fecha_alta', 'tipos_movimientos_issste.tipo_movimiento_issste_id', 'tipos_movimientos_issste.nombre', 'qna_issste')
                ->join('sexos', 'sexos.sexo_id', '=', 'p02_detalles.sexo_id')
                ->join('tipos_nombramientos_issste', 'tipos_nombramientos_issste.tipo_nombramiento_id', '=', 'p02_detalles.tipo_nombramiento_id')
                ->leftJoin('entidades_federativas', 'entidades_federativas.entidad_federativa_id', '=', 'p02_detalles.entidad_federativa_domicilio_id')
                ->join('tipos_movimientos_issste', 'tipos_movimientos_issste.tipo_movimiento_issste_id', '=', 'p02_detalles.tipo_movimiento_issste_id');
    }

    public function detallesBaja()
    {
        // Esta relación se usa para mostrar los datos en la Tabla de Archivos para ISSSTE
        // Y se usa para generar el Excel, *NOTA: Debe estas alineados los atributos a DetallesArchivoIsssteExport ya que se muestran los datos tal cual como se obtiene y se alinean a las cabeceras de esta clase
        return $this->hasMany('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tramite_issste_id', 'tramite_issste_id')
                ->where('tipos_movimientos_issste.nombre', 'BAJA')
                ->whereIn('estatus_issste', ['LISTO'])
                ->select('apellido_paterno', 'apellido_materno', 'nombre_empleado', 'rfc', 'curp',
                'fecha_baja', 'clave_ramo', 'pagaduria', 'guia', 'fecha_recepcion',
                'numero_seguridad_social', 'tipos_movimientos_issste.tipo_movimiento_issste_id', 'tipos_movimientos_issste.nombre', 'qna_issste')
                ->join('tipos_movimientos_issste', 'tipos_movimientos_issste.tipo_movimiento_issste_id', '=', 'p02_detalles.tipo_movimiento_issste_id');
    }
    public function detallesModificacion()
    {
        // Esta relación se usa para mostrar los datos en la Tabla de Archivos para ISSSTE
        // Y se usa para generar el Excel, *NOTA: Debe estas alineados los atributos a DetallesArchivoIsssteExport ya que se muestran los datos tal cual como se obtiene y se alinean a las cabeceras de esta clase
        return $this->hasMany('App\Models\p02_tramites_issste\TramiteIsssteDetalle', 'tramite_issste_id', 'tramite_issste_id')
                ->where('tipos_movimientos_issste.nombre', 'MODIFICACION')
                ->whereIn('estatus_issste', ['LISTO'])
                ->select('apellido_paterno', 'apellido_materno', 'nombre_empleado', 'rfc', 'curp',
                'fecha_nacimiento', 'fecha_registro', 'sueldo_cotizable', 'tipos_nombramientos_issste.nombre as tipo_nombramiento_issste',
                'calle', 'numero_exterior', 'numero_interior', 'colonia', 'cp', 'clave_ramo', 'pagaduria', 'guia',
                'fecha_recepcion', 'numero_seguridad_social', 'entidades_federativas.nombre as entidad_federativa', 'sueldo_sar', 'sueldo_total',
                'clave_cobro', 'fecha_alta', 'tipos_movimientos_issste.tipo_movimiento_issste_id', 'tipos_movimientos_issste.nombre', 'qna_issste')
                ->join('tipos_nombramientos_issste', 'tipos_nombramientos_issste.tipo_nombramiento_id', '=', 'p02_detalles.tipo_nombramiento_id')
                ->leftJoin('entidades_federativas', 'entidades_federativas.entidad_federativa_id', '=', 'p02_detalles.entidad_federativa_domicilio_id')
                ->join('tipos_movimientos_issste', 'tipos_movimientos_issste.tipo_movimiento_issste_id', '=', 'p02_detalles.tipo_movimiento_issste_id');
    }

}
