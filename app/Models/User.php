<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Campos que pueden asignarse masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
    ];

    /**
     * Campos que deben ocultarse.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones automáticas.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    /**
     * Relación con docente.
     */
    public function docente()
    {
        return $this->hasOne(Docente::class);
    }

    /**
     * Relación con alumno.
     */
    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }

    /**
     * Verifica si el usuario es docente.
     */
    public function esDocente(): bool
    {
        return $this->role === 'docente';
    }

    /**
     * Verifica si el usuario es alumno.
     */
    public function esAlumno(): bool
    {
        return $this->role === 'alumno';
    }
}