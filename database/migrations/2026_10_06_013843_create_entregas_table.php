<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tarea_id')
                ->constrained('tareas')
                ->cascadeOnDelete();

            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            $table->string('archivo');

            $table->timestamps();

            $table->unique([
                'tarea_id',
                'alumno_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};