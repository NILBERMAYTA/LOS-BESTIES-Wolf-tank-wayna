<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id('id_notificacion');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->string('titulo', 150);
            $table->longText('contenido');
            $table->enum('tipo', ['pedido', 'donacion', 'producto', 'perfil', 'pago', 'otra'])->default('otra');
            $table->boolean('leida')->default(false);
            $table->foreignId('id_relacionada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
