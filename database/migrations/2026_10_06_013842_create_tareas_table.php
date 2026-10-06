<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');

            $table->text('descripcion')->nullable();

            $table->enum('tipo', [
                'casa',
                'clase',
                'exposicion',
            ]);

            $table->dateTime('fecha_entrega');

            $table->boolean('cancelada')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};