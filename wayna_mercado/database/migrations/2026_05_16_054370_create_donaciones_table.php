<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id('id_donacion');
            $table->foreignId('id_cliente')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_emprendedor')->constrained('emprendedores', 'id_emprendedor')->cascadeOnDelete();
            $table->decimal('monto', 12, 2);
            $table->longText('mensaje_apoyo')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'rechazada'])->default('confirmada');
            $table->timestamp('fecha_donacion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donaciones');
    }
};
