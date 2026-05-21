<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->foreignId('id_cliente')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->enum('estado_pedido', ['pendiente', 'confirmado', 'pagado', 'entregado', 'cancelado'])->default('pendiente');
            $table->enum('tipo', ['compra', 'donacion'])->default('compra');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('comision_plataforma', 12, 2)->default(0);
            $table->decimal('total_emprendedor', 12, 2)->default(0);
            $table->string('metodo_pago', 50)->nullable();
            $table->foreignId('id_metodo_pago')->nullable()->constrained('metodos_pago', 'id_metodo_pago')->nullOnDelete();
            $table->longText('comprobante_pago')->nullable();
            $table->timestamp('fecha_pedido')->useCurrent();
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
