<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

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

        return view('dashboard.admin', compact('totalUsuarios', 'totalEmprendedores', 'totalProductos'));
    }

    public function emprendedor()
    {
        return view('emprendedor.dashboard');
    }

    public function cliente()
    {
        return view('dashboard.cliente');
    }
}
