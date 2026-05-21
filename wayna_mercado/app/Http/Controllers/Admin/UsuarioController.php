<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends AdminController
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = User::orderByDesc('id_usuario');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($sub) use ($search) {
                $sub->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('id_rol', $request->input('role'));
        }

        $usuarios = $query->paginate(20)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $usuario = User::findOrFail($id);
        
        // Si es emprendedor, cargar su perfil
        if ($usuario->isEmprendedor()) {
            $usuario->emprendedor = $usuario->emprendedor()->first();
        }

        return view('admin.usuarios.show', compact('usuario'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.usuarios.create');
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
            'id_rol' => 'required|in:2,3',
        ]);

        $user = User::create([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono'),
            'password' => Hash::make($request->input('password')),
            'id_rol' => $request->input('id_rol'),
        ]);

        return redirect()->route('admin.usuarios.show', $user->id_usuario)
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id . ',id_usuario',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'id_rol' => 'required|in:2,3',
        ]);

        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellido');
        $usuario->email = $request->input('email');
        $usuario->telefono = $request->input('telefono');
        $usuario->id_rol = $request->input('id_rol');

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.show', $usuario->id_usuario)
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $usuario = User::findOrFail($id);
        
        // No permitir borrar el usuario admin actual
        if ($usuario->id_usuario === auth()->id() && $usuario->isAdmin()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
