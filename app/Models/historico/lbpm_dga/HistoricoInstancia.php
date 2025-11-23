<?php

namespace App\Models\historico\lbpm_dga;

use Illuminate\Database\Eloquent\Model;

class HistoricoInstancia extends Model
{
    protected $connection = "lbpm_dga";
    protected $table = "instances";
    protected $primaryKey = "id_instance";
    public $timestamps = false; 

    protected $fillable = [
        'id_proc',
        'id_instance',
        'created_on',
        'last_modified',
        'created_by',
        'created_by_ou',
        'created_by_mail',
        'created_by_cn',
        'created_by_title',
        'created_by_uas_ou',
        'closed_by',
        'closed_by_task',
        'status',
    ];
}
