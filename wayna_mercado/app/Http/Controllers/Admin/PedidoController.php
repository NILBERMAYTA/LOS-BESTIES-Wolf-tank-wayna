<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends AdminController
{
    public function index()
    {
        $this->authorizeAdmin();
        
        $pedidos = Pedido::with(['cliente', 'detalles.producto'])
            ->latest()
            ->paginate(15);
        
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();
        
        $pedido = Pedido::with(['cliente', 'detalles.producto', 'metodo'])
            ->findOrFail($id);
        
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        
        $pedido = Pedido::findOrFail($id);
        
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        
        $pedido = Pedido::findOrFail($id);
        
        $validated = $request->validate([
            'estado_pedido' => 'required|in:pendiente,confirmado,pagado,entregado,cancelado',
        ]);
        
        $pedido->update($validated);
        
        return redirect()->route('admin.pedidos.show', $pedido->id_pedido)
            ->with('success', 'Pedido actualizado correctamente');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();
        
        $pedido = Pedido::findOrFail($id);
        
        $validated = $request->validate([
            'estado_pedido' => 'required|in:pendiente,confirmado,pagado,entregado,cancelado',
        ]);
        
        $pedido->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        
        $pedido = Pedido::findOrFail($id);
        
        // Restaurar stock si se cancela
        if ($pedido->estado_pedido !== 'cancelado') {
            foreach ($pedido->detalles as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }
        }
        
        $pedido->delete();
        
        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado correctamente');
    }
}
