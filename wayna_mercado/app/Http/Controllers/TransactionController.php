<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Producto;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function purchase(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', 'activo')
            ->firstOrFail();

        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'payment_method_id' => 'required|exists:metodos_pago,id_metodo',
        ]);

        $cantidad = (int) $request->cantidad;
        if ($cantidad > $producto->stock) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible'])->withInput();
        }

        $paymentMethod = PaymentMethod::where('id_metodo', $request->payment_method_id)
            ->where('activo', 1)
            ->firstOrFail();

        // Aquí se podría crear un pedido o iniciar el pago.
        return redirect()->route('producto.show', $producto->slug)
            ->with('success', "Compra simulada: $cantidad x $producto->nombre_producto con método $paymentMethod->nombre.");
    }

    public function donate(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', '!=', 'oculto')
            ->firstOrFail();

        $request->validate([
            'monto' => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:metodos_pago,id_metodo',
        ]);

        $paymentMethod = PaymentMethod::where('id_metodo', $request->payment_method_id)
            ->where('activo', 1)
            ->firstOrFail();

        return redirect()->route('producto.show', $producto->slug)
            ->with('success', "Donación simulada: Bs. {$request->monto} para $producto->nombre_producto con método $paymentMethod->nombre.");
    }
}
