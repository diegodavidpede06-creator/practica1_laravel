<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->foreignId('entrega_id')
                ->nullable()
                ->after('id')
                ->constrained('entregas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropForeign(['entrega_id']);
            $table->dropColumn('entrega_id');
        });
    }
};