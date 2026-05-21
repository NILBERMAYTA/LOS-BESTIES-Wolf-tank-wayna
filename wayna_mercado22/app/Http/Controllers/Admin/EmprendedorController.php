<?php

namespace App\Http\Controllers\Admin;

use App\Models\Emprendedor;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmprendedorController extends AdminController
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = Emprendedor::with('user')
            ->withCount('productos')
            ->orderByDesc('fecha_solicitud');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($sub) use ($search) {
                $sub->where('nombre_emprendimiento', 'like', "%{$search}%")
                    ->orWhere('categoria', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%")
                            ->orWhere('nombre', 'like', "%{$search}%")
                            ->orWhere('apellido', 'like', "%{$search}%");
                    });
            });
        }

        $emprendedores = $query->paginate(20)->withQueryString();

        return view('admin.emprendedores.index', compact('emprendedores'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $emprendedor = Emprendedor::with(['user', 'productos.categoria'])
            ->findOrFail($id);

        return view('admin.emprendedores.show', compact('emprendedor'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $categorias = Categoria::orderBy('nombre_categoria')->get();
        return view('admin.emprendedores.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'nombre_emprendimiento' => 'required|string|max:255',
            'categoria' => 'required|string',
            'biografia' => 'required|string|max:1000',
            'frase_impacto' => 'required|string|max:500',
            'descripcion' => 'nullable|string|max:1000',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        // Crear usuario
        $user = User::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono'),
            'password' => Hash::make($request->input('password')),
            'id_rol' => 2, // Emprendedor
        ]);

        // Crear emprendedor
        $emprendedor = Emprendedor::create([
            'id_usuario' => $user->id_usuario,
            'nombre_emprendimiento' => $request->input('nombre_emprendimiento'),
            'slug_emprendimiento' => Str::slug($request->input('nombre_emprendimiento')) . '-' . uniqid(),
            'categoria' => $request->input('categoria'),
            'biografia' => $request->input('biografia'),
            'frase_impacto' => $request->input('frase_impacto'),
            'descripcion' => $request->input('descripcion'),
            'ubicacion' => $request->input('ubicacion'),
            'estado_validacion' => 'aprobado',
            'verificado' => 1,
            'id_admin_validador' => Auth::id(),
            'fecha_validacion' => now(),
        ]);

        return redirect()->route('admin.emprendedores.show', $emprendedor->id_emprendedor)
            ->with('success', 'Emprendedor creado exitosamente.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $emprendedor = Emprendedor::with('user')->findOrFail($id);
        $categorias = Categoria::orderBy('nombre_categoria')->get();

        return view('admin.emprendedores.edit', compact('emprendedor', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $emprendedor = Emprendedor::with('user')->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $emprendedor->id_usuario . ',id_usuario',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'nombre_emprendimiento' => 'required|string|max:255',
            'categoria' => 'required|string',
            'biografia' => 'required|string|max:1000',
            'frase_impacto' => 'required|string|max:500',
            'descripcion' => 'nullable|string|max:1000',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        // Actualizar usuario
        $emprendedor->user->nombre = $request->input('nombre');
        $emprendedor->user->apellido = $request->input('apellido');
        $emprendedor->user->email = $request->input('email');
        $emprendedor->user->telefono = $request->input('telefono');

        if ($request->filled('password')) {
            $emprendedor->user->password = Hash::make($request->input('password'));
        }

        $emprendedor->user->save();

        // Actualizar emprendedor
        $emprendedor->nombre_emprendimiento = $request->input('nombre_emprendimiento');
        $emprendedor->categoria = $request->input('categoria');
        $emprendedor->biografia = $request->input('biografia');
        $emprendedor->frase_impacto = $request->input('frase_impacto');
        $emprendedor->descripcion = $request->input('descripcion');
        $emprendedor->ubicacion = $request->input('ubicacion');
        $emprendedor->save();

        return redirect()->route('admin.emprendedores.show', $emprendedor->id_emprendedor)
            ->with('success', 'Emprendedor actualizado exitosamente.');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => 'required|in:aprobado,rechazado',
            'comentario_rechazo' => 'nullable|string|max:255',
        ]);

        $emprendedor = Emprendedor::findOrFail($id);
        $status = $request->input('status');

        $emprendedor->estado_validacion = $status;
        $emprendedor->verificado = $status === 'aprobado' ? 1 : 0;
        $emprendedor->comentario_rechazo = $status === 'rechazado'
            ? $request->input('comentario_rechazo', 'Rechazado por administrador.')
            : null;
        $emprendedor->id_admin_validador = Auth::id();
        $emprendedor->fecha_validacion = now();
        $emprendedor->save();

        return redirect()->back()->with('success', 'Estado de emprendedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $emprendedor = Emprendedor::findOrFail($id);
        $emprendedor->estado_validacion = 'rechazado';
        $emprendedor->verificado = 0;
        $emprendedor->comentario_rechazo = 'Perfil ocultado por administrador.';
        $emprendedor->id_admin_validador = Auth::id();
        $emprendedor->fecha_validacion = now();
        $emprendedor->save();

        return redirect()->route('admin.emprendedores.index')
            ->with('success', 'Emprendedor ocultado y removido del listado público.');
    }
}
