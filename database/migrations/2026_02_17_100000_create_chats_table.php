<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario2_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_anonymous')->default(true);
            $table->timestamp('ultimo_mensaje_at')->nullable();
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index(['usuario1_id', 'usuario2_id']);
            $table->index('ultimo_mensaje_at');

            // Evitar conversaciones duplicadas
            $table->unique(['usuario1_id', 'usuario2_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
