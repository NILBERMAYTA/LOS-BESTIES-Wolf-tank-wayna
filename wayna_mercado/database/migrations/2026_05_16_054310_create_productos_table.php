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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->foreignId('id_emprendedor')->constrained('emprendedores', 'id_emprendedor')->onDelete('cascade');
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->onDelete('restrict');
            $table->string('nombre_producto', 150);
            $table->string('slug', 200)->unique();
            $table->string('descripcion_corta', 255);
            $table->longText('descripcion_larga')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->string('imagen_principal')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'oculto'])->default('activo');
            $table->boolean('destacado')->default(false);
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('total_reseñas')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
