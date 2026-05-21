<?php

namespace App\Http\Controllers\Admin;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Emprendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends AdminController
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = Producto::with(['emprendedor.user', 'categoria'])
            ->orderByDesc('id_producto');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre_producto', 'like', "%{$search}%")
                ->orWhereHas('emprendedor', function ($sub) use ($search) {
                    $sub->where('nombre_emprendimiento', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('email', 'like', "%{$search}%")
                                ->orWhere('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%");
                        });
                });
        }

        $productos = $query->paginate(20)->withQueryString();

        return view('admin.productos.index', compact('productos'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $producto = Producto::with(['emprendedor.user', 'categoria'])
            ->findOrFail($id);

        return view('admin.productos.show', compact('producto'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $categorias = Categoria::orderBy('nombre_categoria')->get();
        $emprendedores = Emprendedor::with('user')->where('estado_validacion', 'aprobado')->get();

        return view('admin.productos.create', compact('categorias', 'emprendedores'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'id_emprendedor' => 'required|exists:emprendedores,id_emprendedor',
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = new Producto();
        $producto->id_emprendedor = $request->input('id_emprendedor');
        $producto->nombre_producto = $request->input('nombre_producto');
        $producto->descripcion = $request->input('descripcion');
        $producto->id_categoria = $request->input('id_categoria');
        $producto->precio = $request->input('precio');
        $producto->stock = $request->input('stock');
        $producto->estado = 'activo';

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }

        $producto->save();

        return redirect()->route('admin.productos.show', $producto->id_producto)
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre_categoria')->get();
        $emprendedores = Emprendedor::with('user')->where('estado_validacion', 'aprobado')->get();

        return view('admin.productos.edit', compact('producto', 'categorias', 'emprendedores'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $producto = Producto::findOrFail($id);

        $request->validate([
            'id_emprendedor' => 'required|exists:emprendedores,id_emprendedor',
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto->id_emprendedor = $request->input('id_emprendedor');
        $producto->nombre_producto = $request->input('nombre_producto');
        $producto->descripcion = $request->input('descripcion');
        $producto->id_categoria = $request->input('id_categoria');
        $producto->precio = $request->input('precio');
        $producto->stock = $request->input('stock');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }

        $producto->save();

        return redirect()->route('admin.productos.show', $producto->id_producto)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'estado' => 'required|in:activo,oculto,agotado',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->estado = $request->input('estado');
        $producto->save();

        return redirect()->back()->with('success', 'Estado del producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $producto = Producto::findOrFail($id);
        $producto->estado = 'oculto';
        $producto->save();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto ocultado correctamente.');
    }
}
