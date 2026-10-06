<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'usuario',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Evidencias entregadas por el alumno.
     */
    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    /**
     * Calificaciones del alumno.
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}