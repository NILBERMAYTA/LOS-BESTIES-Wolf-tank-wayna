<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Emprendedor;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del emprendedor
     */
    public function index()
    {
        // Para demostración, usamos el ID 1. En producción, usarías auth()->id()
        $emprendedor = Emprendedor::find(1);

        if (!$emprendedor) {
            // Si no existe, usamos datos de demostración
            $usuario = Usuario::obtenerUsuario();
            return view('perfil', compact('usuario'));
        }

        

        $usuario = $emprendedor->obtenerDatosCompletos();
        return view('perfil', [
            'emprendedor' => $emprendedor,
            'usuario' => $usuario
        ]);

    }

    /**
     * Mostrar el formulario de edición del perfil
     */
    public function edit()
    {
        $emprendedor = Emprendedor::find(1);

        if (!$emprendedor) {
            return redirect('/perfil')->with('error', 'Emprendedor no encontrado');
        }

        return view('emprendedor.editar-perfil', compact('emprendedor'));
    }

    /**
     * Actualizar el perfil del emprendedor
     */
    public function update(Request $request)
    {
        $emprendedor = Emprendedor::find(1);

        if (!$emprendedor) {
            return redirect('/perfil')->with('error', 'Emprendedor no encontrado');
        }

        // Validación
        $validated = $request->validate([
            'nombre_emprendimiento' => 'required|string|max:150',
            'descripcion_emprendimiento' => 'required|string|max:1000',
            'biografia' => 'nullable|string|max:2000',
            'frase_impacto' => 'nullable|string|max:255',
            'categoria' => 'required|string',
            'ubicacion' => 'nullable|string|max:150',
            'video_url' => 'nullable|url',
        ]);

        // Actualizar el emprendedor
        $emprendedor->update($validated);

        return redirect('/perfil')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}