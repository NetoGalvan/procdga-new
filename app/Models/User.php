<?php

namespace App\Models;

use App\Models\p15_asistencia\Horario;
use App\Models\p15_asistencia\HorarioUser;
use App\Models\p24_directorio\AlfabeticoMain;
use App\Notifications\Auth\PasswordReset;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Http;

use App\Models\p22_reportes_dias_efectivamente_laborados\P22Reporte;
use App\Models\p22_reportes_dias_efectivamente_laborados\P22ReporteDetalle;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'nombre_usuario',
        'numero_empleado',
        'puesto',
        'rfc',
        'curp',
        'puesto',
        'area_id',
        'email',
        'password',
        'change_password',
        'tipo_registro',
        'empleado_id',
        'activo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['nombre_completo', 'ruta_editar'];

    public function sendPasswordResetNotification($token) {
        $this->notify((new PasswordReset($token, $this)));
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . " " . $this->apellido_paterno . " " . $this->apellido_materno);
    }

    public function getRutaEditarAttribute()
    {
        return route('usuarios.edit', $this);
    }

    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'p15_horarios_users', 'user_id', 'horario_id')
            ->using(HorarioUser::class)
            ->withPivot("fecha_inicio", "fecha_final");
    }

    public function attachHorario($horario, $fechaInicio, $fechaFinal = null)
    {
        return $this->horarios()->attach($horario->horario_id, [
            'fecha_inicio' => $fechaInicio,
            'fecha_final' => $fechaFinal
        ]);
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'rfc', 'rfc') ;
    }

    // Función para revocar tokens de Crencialización
    public function logoutFromCreden() {
        $access_token = session()->get("access_token");
        $response = Http::withHeaders([
            "Accept"        => "application/json",
            "Authorization" => "Bearer " . $access_token
        ])->get(env('SERVER_CREDENCIALIZACION')."/api/logoutsso");
    }

   /*  public function empleado() {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'empleado_id');
    } */

    #FROM::P22
    public function p22Reporte()
    {
        return $this->hasMany(P22Reporte::class, 'elaboro_user_id');
    }

    public function p22ReporteDetalle()
    {
        return $this->hasMany(P22ReporteDetalle::class, 'elaboro_user_id');
    }
    #END::P22
}
