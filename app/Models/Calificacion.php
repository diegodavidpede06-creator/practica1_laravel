<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'entrega_id',
        'alumno_id',
        'tarea_id',
        'calificacion',
        'estado',
        'comentario',
    ];

    protected $casts = [
        'calificacion' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON ALUMNO
    |--------------------------------------------------------------------------
    */

    public function alumno()
    {
        return $this->belongsTo(
            Alumno::class,
            'alumno_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON TAREA
    |--------------------------------------------------------------------------
    */

    public function tarea()
    {
        return $this->belongsTo(
            Tarea::class,
            'tarea_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIÓN CON ENTREGA
    |--------------------------------------------------------------------------
    */

    public function entrega()
    {
        return $this->belongsTo(
            Entrega::class,
            'entrega_id'
        );
    }
}