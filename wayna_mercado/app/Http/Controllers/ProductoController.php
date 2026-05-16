<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::where('estado', 'activo')
            ->whereHas('emprendedor', function ($query) {
                $query->where('estado_validacion', 'aprobado')->where('verificado', 1);
            })
            ->with('emprendedor.user', 'categoria')
            ->paginate(12);

        return view('productos.index', compact('productos'));
    }

    public function show($slug)
    {
        $producto = Producto::where('slug', $slug)
            ->where('estado', '!=', 'oculto')
            ->with('emprendedor.user', 'categoria')
            ->firstOrFail();

        $metodosPago = PaymentMethod::where('activo', 1)->get();

        return view('productos.show', compact('producto', 'metodosPago'));
    }

    /**
     * Mostrar formulario para crear nuevo producto
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->id_rol != 2) {
            abort(403, 'Solo los emprendedores pueden crear productos.');
        }
        
        $categorias = Categoria::all();
        $emprendedor = $user->emprendedor;

        if (!$emprendedor) {
            return redirect()->route('register.emprendedor')
                ->with('error', 'Debes crear un perfil de emprendedor primero.');
        }

        return view('producto.create', compact('categorias', 'emprendedor'));
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->id_rol != 2) {
            abort(403, 'Solo los emprendedores pueden crear productos.');
        }

        $emprendedor = $user->emprendedor;

        $request->validate([
            'nombre_producto' => 'required|string|max:150',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'descripcion_corta' => 'required|string|max:255',
            'descripcion_larga' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'imagen_principal' => 'nullable|image|max:5120',
        ]);

        $data = $request->all();
        $data['id_emprendedor'] = $emprendedor->id_emprendedor;
        $data['slug'] = Str::slug($request->nombre_producto) . '-' . uniqid();
        $data['estado'] = 'activo';

        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('emprendedor.productos', $emprendedor->slug_emprendimiento)
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar producto
     */
    public function edit($id)
    {
        $user = auth()->user();
        if ($user->id_rol != 2) {
            abort(403, 'Solo los emprendedores pueden editar productos.');
        }

        $producto = Producto::findOrFail($id);
        $emprendedor = $user->emprendedor;

        if ($producto->id_emprendedor !== $emprendedor->id_emprendedor) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $categorias = Categoria::all();

        return view('producto.edit', compact('producto', 'categorias', 'emprendedor'));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->id_rol != 2) {
            abort(403, 'Solo los emprendedores pueden actualizar productos.');
        }

        $producto = Producto::findOrFail($id);
        $emprendedor = $user->emprendedor;

        if ($producto->id_emprendedor !== $emprendedor->id_emprendedor) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $request->validate([
            'nombre_producto' => 'required|string|max:150',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'descripcion_corta' => 'required|string|max:255',
            'descripcion_larga' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'imagen_principal' => 'nullable|image|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('emprendedor.productos', $emprendedor->slug_emprendimiento)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Eliminar producto
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->id_rol != 2) {
            abort(403, 'Solo los emprendedores pueden eliminar productos.');
        }

        $producto = Producto::findOrFail($id);
        $emprendedor = $user->emprendedor;

        if ($producto->id_emprendedor !== $emprendedor->id_emprendedor) {
            abort(403, 'No tienes permiso para eliminar este producto.');
        }

        $slug = $emprendedor->slug_emprendimiento;
        $producto->delete();

        return redirect()->route('emprendedor.productos', $slug)
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
