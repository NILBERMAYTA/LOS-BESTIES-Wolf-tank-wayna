<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Emprendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del emprendedor autenticado
     */
    public function index()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect('/login')->with('error', 'Debe iniciar sesión');
        }

        // Si el usuario es emprendedor, obtener sus datos
        $emprendedor = Emprendedor::where('id_usuario', $usuario->id_usuario)->first();
        
        return view('perfil', compact('usuario', 'emprendedor'));
    }

    /**
     * Mostrar el formulario de edición del perfil
     */
    public function edit()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect('/login')->with('error', 'Debe iniciar sesión');
        }

        $emprendedor = Emprendedor::where('id_usuario', $usuario->id_usuario)->first();

        if (!$emprendedor) {
            return redirect('/perfil')->with('error', 'Debe ser emprendedor para editar el perfil');
        }

        return view('emprendedor.editar-perfil', compact('emprendedor', 'usuario'));
    }

    /**
     * Actualizar el perfil del emprendedor
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect('/login')->with('error', 'Debe iniciar sesión');
        }

        $emprendedor = Emprendedor::where('id_usuario', $usuario->id_usuario)->first();

        if (!$emprendedor) {
            return redirect('/perfil')->with('error', 'Debe ser emprendedor para editar el perfil');
        }

        // Validación
        $validated = $request->validate([
            'nombre_emprendimiento' => 'required|string|max:150',
            'slug_emprendimiento' => 'required|string|max:150|unique:emprendedores,slug_emprendimiento,' . $emprendedor->id_emprendedor . ',id_emprendedor',
            'biografia' => 'nullable|string|max:2000',
            'frase_impacto' => 'nullable|string|max:255',
            'categoria' => 'required|in:gastronomia,cosmetica,artesania,textiles,otros',
            'ubicacion' => 'nullable|string|max:150',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video_url' => 'nullable|url|max:255',
        ]);

        // Procesar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            if ($emprendedor->foto_perfil && Storage::disk('public')->exists($emprendedor->foto_perfil)) {
                Storage::disk('public')->delete($emprendedor->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('emprendedores', 'public');
        }

        // Procesar foto de portada
        if ($request->hasFile('foto_portada')) {
            if ($emprendedor->foto_portada && Storage::disk('public')->exists($emprendedor->foto_portada)) {
                Storage::disk('public')->delete($emprendedor->foto_portada);
            }
            $validated['foto_portada'] = $request->file('foto_portada')->store('emprendedores', 'public');
        }

        // Actualizar el emprendedor
        $emprendedor->update($validated);

        return redirect('/perfil')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}