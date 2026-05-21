<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmprendedorController extends Controller
{
    /**
     * Mostrar todos los emprendedores aprobados
     */
    public function index()
    {
        $emprendedores = Emprendedor::where('estado_validacion', 'aprobado')
            ->where('verificado', 1)
            ->with('user', 'productosActivos')
            ->paginate(12);

        return view('emprendedor.index', compact('emprendedores'));
    }

    /**
     * Mostrar perfil de un emprendedor específico
     */
    public function show($slugEmprendimiento)
    {
        $emprendedor = Emprendedor::where('slug_emprendimiento', $slugEmprendimiento)
            ->where('estado_validacion', 'aprobado')
            ->where('verificado', 1)
            ->with('user', 'productosActivos.categoria')
            ->firstOrFail();

        $productos = $emprendedor->productosActivos()
            ->where('estado', '!=', 'oculto')
            ->get();

        return view('emprendedor.show', compact('emprendedor', 'productos'));
    }

    /**
     * Mostrar productos de un emprendedor
     */
    public function productos($slugEmprendimiento)
    {
        $emprendedor = Emprendedor::where('slug_emprendimiento', $slugEmprendimiento)
            ->where('estado_validacion', 'aprobado')
            ->where('verificado', 1)
            ->firstOrFail();

        $productos = $emprendedor->productosActivos()
            ->where('estado', '!=', 'oculto')
            ->paginate(12);

        return view('emprendedor.productos', compact('emprendedor', 'productos'));
    }

    /**
     * Mostrar formulario para editar perfil del emprendedor
     */
    public function editPerfil()
    {
        $emprendedor = Auth::user()->emprendedor;

        if (!$emprendedor) {
            return redirect()->route('register.emprendedor')
                ->with('error', 'Debes crear un perfil de emprendedor.');
        }

        return view('emprendedor.edit-perfil', compact('emprendedor'));
    }

    /**
     * Actualizar perfil del emprendedor
     */
    public function updatePerfil(Request $request)
    {
        $emprendedor = Auth::user()->emprendedor;

        if (!$emprendedor) {
            return redirect()->route('register.emprendedor')
                ->with('error', 'Debes crear un perfil de emprendedor.');
        }

        $request->validate([
            'nombre_emprendimiento' => 'required|string|max:150',
            'descripcion_emprendimiento' => 'nullable|string|max:255',
            'biografia' => 'required|string',
            'frase_impacto' => 'required|string|max:255',
            'categoria' => 'required|in:gastronomia,cosmetica,artesania,textiles,otros',
            'ubicacion' => 'nullable|string|max:150',
            'foto_perfil' => 'nullable|image|max:5120',
            'foto_portada' => 'nullable|image|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')
                ->store('emprendedores', 'public');
        }

        if ($request->hasFile('foto_portada')) {
            $data['foto_portada'] = $request->file('foto_portada')
                ->store('emprendedores', 'public');
        }

        $emprendedor->update($data);

        return redirect()->route('emprendedor.dashboard')
            ->with('success', 'Tu perfil ha sido actualizado exitosamente.');
    }
}
