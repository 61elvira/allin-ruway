<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROL_ADMIN = 'admin';
    const ROL_TRABAJADOR = 'trabajador';
    const ROL_CLIENTE = 'cliente';

    protected $fillable = [
        'name',
        'apellido',
        'email',
        'telefono',
        'distrito',
        'especialidad',
        'experiencia',
        'descripcion',
        'foto',
        'rol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function isTrabajador(): bool
    {
        return $this->rol === self::ROL_TRABAJADOR;
    }

    public function isCliente(): bool
    {
        return $this->rol === self::ROL_CLIENTE;
    }

    public function calificacionesRecibidas()
    {
        return $this->hasMany(Calificacion::class, 'trabajador_id');
    }

    public function calificacionesRealizadas()
    {
        return $this->hasMany(Calificacion::class, 'cliente_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'trabajador_id');
    }

    public function contratacionesComoCliente()
    {
        return $this->hasMany(Contratacion::class, 'cliente_id');
    }

    public function contratacionesComoTrabajador()
    {
        return $this->hasMany(Contratacion::class, 'trabajador_id');
    }
}
