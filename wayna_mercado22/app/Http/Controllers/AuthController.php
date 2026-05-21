<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials['estado'] = 'activo';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            /** @var User $user */
            $user = Auth::user();
            
            // Redirigir según rol
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenido administrador');
            } elseif ($user->isEmprendedor()) {
                return redirect()->route('dashboard')->with('success', 'Bienvenido emprendedor');
            } else {
                return redirect()->route('cliente.dashboard')->with('success', 'Bienvenido cliente');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Sesión cerrada correctamente');
    }
}
