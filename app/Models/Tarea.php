<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'fecha_entrega',
        'cancelada',
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
        'cancelada' => 'boolean',
    ];

    /**
     * Evidencias entregadas para esta tarea.
     */
    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    /**
     * Calificaciones asociadas a esta tarea.
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}