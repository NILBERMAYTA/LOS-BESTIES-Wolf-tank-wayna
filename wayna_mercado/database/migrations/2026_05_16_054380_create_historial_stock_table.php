<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_stock', function (Blueprint $table) {
            $table->id('id_historial');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->cascadeOnDelete();
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_nueva');
            $table->enum('tipo_movimiento', ['compra', 'ajuste', 'restock', 'cancelacion'])->default('ajuste');
            $table->foreignId('id_pedido')->nullable()->constrained('pedidos', 'id_pedido')->nullOnDelete();
            $table->string('descripcion', 255)->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_stock');
    }
};
