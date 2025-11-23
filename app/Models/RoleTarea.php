<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTarea extends Model
{
    use HasFactory;
    
    protected $table = 'role_tarea';
    protected $primaryKey = 'role_tarea_id';
}
