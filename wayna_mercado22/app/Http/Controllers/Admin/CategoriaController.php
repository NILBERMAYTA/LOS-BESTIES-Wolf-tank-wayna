<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends AdminController
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = Categoria::withCount('productos')->orderBy('nombre_categoria');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre_categoria', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
        }

        $categorias = $query->paginate(20)->withQueryString();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $categoria = Categoria::with('productos')->findOrFail($id);

        return view('admin.categorias.show', compact('categoria'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $categoria = Categoria::create([
            'nombre_categoria' => $request->input('nombre_categoria'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('admin.categorias.show', $categoria->id_categoria)
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria,' . $id . ',id_categoria',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $categoria->nombre_categoria = $request->input('nombre_categoria');
        $categoria->descripcion = $request->input('descripcion');
        $categoria->save();

        return redirect()->route('admin.categorias.show', $categoria->id_categoria)
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $categoria = Categoria::findOrFail($id);

        // No permitir eliminar si hay productos
        if ($categoria->productos()->count() > 0) {
            return redirect()->back()->with('error', 'No puedes eliminar una categoría que tiene productos.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
