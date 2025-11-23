<?php

namespace App\Models\p06_servicio_social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\EntidadFederativa;
use App\Models\Municipio;

class P06Prestador extends Model
{
    use HasFactory;

    protected $table = "p06_prestadores";
    protected $primaryKey = "prestador_id";
/*
    protected $fillable = [
        'instancia_id', 'estatus_trabajo', 'folio'
    ];
*/
    protected $fillable = [
        'escuela_id',
        'programa_id',
        'tipo_prestador',
        'primer_apellido',
        'segundo_apellido',
        'nombre_prestador',
        'telefono',
        'email',
        'carrera',
        'matricula',
        'calle',
        'numero_interior',
        'numero_exterior',
        'ciudad',
        'colonia',
        'cp',
        'municipio_id', 
        'horario_tentativo',
        'total_horas',
        'observaciones',
        'nombre_funcionario',
        'puesto_funcionario',
        'telefono_funcionario',
        'activo',
        'created_at',
        'updated_at'
    ];

    #BEGIN::Relaciones
    public function escuela(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06Escuela', 'escuela_id', 'escuela_id');
    }

    public function entidad(){
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id');
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function unidadAdministrativa(){
        return $this->belongsTo('App\Models\UnidadAdministrativa', 'unidad_administrativa_id');
    }

    public function instancia(){
        return $this->belongsTo('App\Models\Instancia', 'instancia_id');
    }

    public function servicioSocial()
    {
        return $this->hasOne('App\Models\p06_servicio_social\P06ServicioSocial', 'prestador_id');
    }

    // public function servicioSocial() // Así estaba originalmente, se cambio a hasOne y se quito un prestador_id (por si truena en algo)
    // {
    //     return $this->belongsTo('App\Models\p06_servicio_social\P06ServicioSocial', 'prestador_id', 'prestador_id');
    // }

    public function programa(){
        return $this->belongsTo('App\Models\p06_servicio_social\P06ProgramasInstitucion', 'programa_id');
    }
    #END::Relaciones

    #BEGIN::Scopes
    public function scopePrestadoresActivos($query) {
        $query->where('activo', true)->with(['escuela.institucion','municipio.entidad'])->orderBy('primer_apellido')->get()->append('nombre_prestador_completo');
    }
    #END::Scopes

    #BEGIN::Atributos virtuales
    public function getNombrePrestadorCompletoAttribute() {
        return $this->primer_apellido.' '.$this->segundo_apellido.' '.$this->nombre_prestador;
    }
    #END::Atributos virtuales
}
