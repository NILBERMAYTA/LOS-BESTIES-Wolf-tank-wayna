<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Donacion;
use App\Models\HistorialStock;
use App\Models\PaymentMethod;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function purchase(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', 'activo')
            ->firstOrFail();

        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isCliente()) {
            return back()->withInput()->withErrors(['general' => 'Debes usar una cuenta de cliente para comprar.']);
        }

        $validated = $request->validate([
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

        $cantidad = (int) $validated['cantidad'];
        if ($cantidad > $producto->stock) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible'])->withInput();
        }

        $paymentMethod = null;
        $methodName = 'Pago';
        $methodId = null;

        if (in_array($validated['payment_method_id'], ['wayna_qr', 'transferencia_bancaria', 'efectivo'], true)) {
            $methodName = match ($validated['payment_method_id']) {
                'wayna_qr' => 'Wayna QR',
                'transferencia_bancaria' => 'Transferencia Bancaria',
                'efectivo' => 'Efectivo',
                default => 'Pago'
            };
        } else {
            $paymentMethod = PaymentMethod::where('id_metodo', $validated['payment_method_id'])
                ->where('activo', 1)
                ->firstOrFail();
            $methodName = $paymentMethod->nombre;
            $methodId = $paymentMethod->id_metodo;
        }

        $pedido = DB::transaction(function () use ($producto, $validated, $cantidad, $methodId, $methodName, $user) {
            $subtotal = round($producto->precio * $cantidad, 2);
            $comision = round($subtotal * 0.20, 2);
            $totalEmprendedor = round($subtotal - $comision, 2);

            // Crear pedido con estado confirmado (pendiente de confirmación de pago)
            $pedido = Pedido::create([
                'id_cliente' => $user->id_usuario,
                'fecha_pedido' => now(),
                'estado_pedido' => 'confirmado', // Cambiar a 'pagado' cuando se confirme el pago
                'tipo' => 'compra',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'metodo_pago' => $methodName,
                'id_metodo_pago' => $methodId,
                'comision_plataforma' => $comision,
                'total_emprendedor' => $totalEmprendedor,
                'fecha_pago' => null, // Se actualiza cuando se confirma el pago
                'fecha_confirmacion' => now(),
            ]);

            DetallePedido::create([
                'id_pedido' => $pedido->id_pedido,
                'id_producto' => $producto->id_producto,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $subtotal,
            ]);

            // NOTA: El stock se reduce aquí. En producción, considerar reducirlo
            // solo después de confirmar el pago mediante webhook
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
                'tipo_movimiento' => 'compra',
                'id_pedido' => $pedido->id_pedido,
                'descripcion' => "Venta de $cantidad unidades a cliente #{$user->id_usuario}",
            ]);

            return $pedido;
        });

        return redirect()->route('payment.confirmation', ['type' => 'compra', 'id' => $pedido->id_pedido]);
    }

    public function donate(Request $request, $slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', '!=', 'oculto')
            ->firstOrFail();

        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$user->isCliente()) {
            return back()->withInput()->withErrors(['general' => 'Solo clientes pueden hacer donaciones.']);
        }

        $validated = $request->validate([
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

        $donacion = DB::transaction(function () use ($validated, $producto, $user) {
            return Donacion::create([
                'id_cliente' => $user->id_usuario,
                'id_emprendedor' => $producto->emprendedor->id_emprendedor,
                'monto' => round($validated['monto'], 2),
                'mensaje_apoyo' => $validated['mensaje_apoyo'] ?? null,
                'estado' => 'confirmada',
                'fecha_donacion' => now(),
            ]);
        });

        return redirect()->route('payment.confirmation', ['type' => 'donacion', 'id' => $donacion->id_donacion]);
    }

    public function confirmation($type, $id)
    {
        if ($type === 'compra') {
            $pedido = Pedido::with(['cliente', 'detalles.producto'])->findOrFail($id);
            /** @var User|null $user */
            $user = Auth::user();
            abort_unless($user && ($user->isAdmin() || $user->id_usuario === $pedido->id_cliente), 403);

            return view('payments.confirmation', [
                'type' => $type,
                'pedido' => $pedido,
            ]);
        }

        if ($type === 'donacion') {
            $donacion = Donacion::with(['cliente', 'emprendedor'])->findOrFail($id);
            /** @var User|null $user */
            $user = Auth::user();
            abort_unless($user && ($user->isAdmin() || $user->id_usuario === $donacion->id_cliente), 403);

            return view('payments.confirmation', [
                'type' => $type,
                'donacion' => $donacion,
            ]);
        }

        abort(404);
    }
}
