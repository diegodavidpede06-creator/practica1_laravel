<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evidencia extends Model
{
    protected $table = 'evidencias';

    protected $fillable = [
        'tarea_id',
        'alumno_id',
        'archivo',
        'nombre_original',
        'mime_type',
        'tamano',
        'fecha_entrega',
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];

    /**
     * Tarea correspondiente.
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class);
    }

    /**
     * Alumno que entregó.
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }
}