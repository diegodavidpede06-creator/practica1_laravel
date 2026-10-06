<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'tarea_id',
        'alumno_id',
        'archivo',
        'nombre_archivo',
    ];

    /**
     * Tarea a la que pertenece la evidencia.
     */
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    /**
     * Alumno que entregó la evidencia.
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    /**
     * Calificación de esta evidencia.
     */
    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }
}