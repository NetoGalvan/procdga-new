<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';
    protected $primaryKey = 'documento_id';
    protected $fillable = [
        'documento_id',
        'nombre_original',
        'nombre',
        'descripcion',
        'disco',
        'ruta',
        'fecha_subida',
        'tipo_documento_id',
    ];

    protected $appends = ['ruta_show', 'ruta_download', 'ruta_destroy'];

    public function tipoDocumento() {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    
    public function model() {
        return $this->morphTo();
    }

    public function getRutaShowAttribute() {
        return route("documentos.show", [$this]);
    }

    public function getRutaDownloadAttribute() {
        return route("documentos.download", [$this]);
    }
    
    public function getRutaDestroyAttribute() {
        return route("documentos.destroy", [$this]);
    }
}
