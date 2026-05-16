<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Donacion;
use App\Models\HistorialStock;
use App\Models\PaymentMethod;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function purchase(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', 'activo')
            ->firstOrFail();

        if (Auth::user()->id_rol != 3) {
            return back()->withErrors(['general' => 'Debes usar una cuenta de cliente para comprar.']);
        }

        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'payment_method_id' => ['required', function ($attribute, $value, $fail) {
                if (in_array($value, ['wayna_qr', 'transferencia_bancaria', 'efectivo'], true)) {
                    return;
                }
                if (!PaymentMethod::where('id_metodo', $value)->where('activo', 1)->exists()) {
                    $fail('El método de pago seleccionado no es válido.');
                }
            }],
        ]);

        $cantidad = (int) $request->cantidad;
        if ($cantidad > $producto->stock) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible'])->withInput();
        }

        $paymentMethod = null;
        $methodName = 'Pago';
        $methodId = null;

        if (in_array($request->payment_method_id, ['wayna_qr', 'transferencia_bancaria', 'efectivo'], true)) {
            $methodName = match ($request->payment_method_id) {
                'wayna_qr' => 'Wayna QR',
                'transferencia_bancaria' => 'Transferencia Bancaria',
                'efectivo' => 'Efectivo',
                default => 'Pago'
            };
        } else {
            $paymentMethod = PaymentMethod::where('id_metodo', $request->payment_method_id)
                ->where('activo', 1)
                ->firstOrFail();
            $methodName = $paymentMethod->nombre;
            $methodId = $paymentMethod->id_metodo;
        }

        $subtotal = round($producto->precio * $cantidad, 2);
        $comision = round($subtotal * 0.20, 2);
        $totalEmprendedor = round($subtotal - $comision, 2);

        $pedido = Pedido::create([
            'id_cliente' => Auth::user()->id_usuario,
            'fecha_pedido' => now(),
            'estado_pedido' => 'pagado',
            'tipo' => 'compra',
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'metodo_pago' => $methodName,
            'id_metodo_pago' => $methodId,
            'comision_plataforma' => $comision,
            'total_emprendedor' => $totalEmprendedor,
            'fecha_pago' => now(),
            'fecha_confirmacion' => now(),
        ]);

        DetallePedido::create([
            'id_pedido' => $pedido->id_pedido,
            'id_producto' => $producto->id_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $producto->precio,
            'subtotal' => $subtotal,
        ]);

        $previousStock = $producto->stock;
        $newStock = max(0, $previousStock - $cantidad);
        $producto->update([
            'stock' => $newStock,
            'estado' => $newStock > 0 ? 'activo' : 'agotado',
        ]);

        HistorialStock::create([
            'id_producto' => $producto->id_producto,
            'cantidad_anterior' => $previousStock,
            'cantidad_nueva' => $newStock,
            'tipo_cambio' => 'venta',
            'referencia_id' => $pedido->id_pedido,
            'observaciones' => "Venta de $cantidad unidades a cliente #{auth()->user()->id_usuario}",
        ]);

        return redirect()->route('producto.show', $producto->slug)
            ->with('success', "Compra realizada: $cantidad x $producto->nombre_producto. Stock actualizado.");
    }

    public function donate(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', '!=', 'oculto')
            ->firstOrFail();

        $request->validate([
            'monto' => 'required|numeric|min:1',
            'payment_method_id' => ['required', function ($attribute, $value, $fail) {
                if (in_array($value, ['wayna_qr', 'transferencia_bancaria', 'efectivo'], true)) {
                    return;
                }
                if (!PaymentMethod::where('id_metodo', $value)->where('activo', 1)->exists()) {
                    $fail('El método de pago seleccionado no es válido.');
                }
            }],
            'mensaje_apoyo' => 'nullable|string|max:255',
        ]);

        Donacion::create([
            'id_cliente' => Auth::user()->id_usuario,
            'id_emprendedor' => $producto->emprendedor->id_emprendedor,
            'monto' => round($request->monto, 2),
            'mensaje_apoyo' => $request->mensaje_apoyo,
            'estado' => 'confirmada',
            'fecha_donacion' => now(),
        ]);

        return redirect()->route('producto.show', $producto->slug)
            ->with('success', "Donación realizada: Bs. {$request->monto} a {$producto->emprendedor->nombre_emprendimiento}.");
    }
}
