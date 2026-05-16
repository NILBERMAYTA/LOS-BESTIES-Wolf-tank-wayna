<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Donacion;
use App\Models\Emprendedor;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->id_rol == 1) {
            return $this->admin();
        }

        if ($user->id_rol == 2) {
            return $this->emprendedor();
        }

        return $this->cliente();
    }

    public function admin()
    {
        $totalUsuarios = User::count();
        $totalEmprendedores = Emprendedor::count();
        $totalProductos = Producto::count();
        $totalPedidos = Pedido::count();
        $totalDonaciones = Donacion::count();
        $totalVentas = Pedido::sum('total');
        $totalMontoDonaciones = Donacion::sum('monto');
        $ingresosWayna = Pedido::sum('comision_plataforma');

        return view('dashboard.admin', compact(
            'totalUsuarios',
            'totalEmprendedores',
            'totalProductos',
            'totalPedidos',
            'totalDonaciones',
            'totalVentas',
            'totalMontoDonaciones',
            'ingresosWayna'
        ));
    }

    public function emprendedor()
    {
        $user = Auth::user();
        $emprendedor = $user->emprendedor;
        $productoIds = $emprendedor ? $emprendedor->productos->pluck('id_producto')->toArray() : [];

        $totalProductos = count($productoIds);
        $totalVentas = $productoIds ? DetallePedido::whereIn('id_producto', $productoIds)->sum('subtotal') : 0;
        $totalUnidadesVendidas = $productoIds ? DetallePedido::whereIn('id_producto', $productoIds)->sum('cantidad') : 0;
        $totalDonaciones = $emprendedor ? Donacion::where('id_emprendedor', $emprendedor->id_emprendedor)->sum('monto') : 0;
        $productosActivos = $emprendedor ? $emprendedor->productosActivos()->count() : 0;

        return view('emprendedor.dashboard', compact(
            'emprendedor',
            'totalProductos',
            'productosActivos',
            'totalVentas',
            'totalUnidadesVendidas',
            'totalDonaciones'
        ));
    }

    public function cliente()
    {
        return view('dashboard.cliente');
    }

    public function adminPedidos()
    {
        $user = Auth::user();
        if (!$user || $user->id_rol != 1) {
            abort(403, 'Acceso restringido.');
        }

        $pedidos = Pedido::with(['cliente', 'detalles.producto'])
            ->orderBy('fecha_pedido', 'desc')
            ->paginate(20);

        return view('dashboard.admin-pedidos', compact('pedidos'));
    }

    public function adminDonaciones()
    {
        $user = Auth::user();
        if (!$user || $user->id_rol != 1) {
            abort(403, 'Acceso restringido.');
        }

        $donaciones = Donacion::with(['cliente', 'emprendedor'])
            ->orderBy('fecha_donacion', 'desc')
            ->paginate(20);

        return view('dashboard.admin-donaciones', compact('donaciones'));
    }
}
