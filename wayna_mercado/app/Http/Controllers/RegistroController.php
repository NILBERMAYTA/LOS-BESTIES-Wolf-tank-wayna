<?php
// app/Http/Controllers/RegistroController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emprendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistroController extends Controller
{
    public function formulario()
    {
        return view('auth.register-emprendedor');
    }

    public function guardar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
            'telefono' => 'nullable|string|max:30',
            'nombre_emprendimiento' => 'required|string|max:150',
            'descripcion_emprendimiento' => 'nullable|string|max:255',
            'biografia' => 'required|string',
            'frase_impacto' => 'required|string|max:255',
            'categoria' => 'required|in:gastronomia,cosmetica,artesania,textiles,otros',
            'ubicacion' => 'nullable|string|max:150',
        ]);

        // 1. Crear el usuario en la tabla `usuarios`
        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'id_rol' => 2, // 2 = Emprendedor
            'estado' => 'activo'
        ]);

        // 2. Crear el emprendedor en la tabla `emprendedores` - APROBADO AUTOMÁTICAMENTE
        Emprendedor::create([
            'id_usuario' => $user->id_usuario,
            'nombre_emprendimiento' => $request->nombre_emprendimiento,
            'descripcion_emprendimiento' => $request->descripcion_emprendimiento,
            'slug_emprendimiento' => Str::slug($request->nombre_emprendimiento) . '-' . uniqid(),
            'biografia' => $request->biografia,
            'frase_impacto' => $request->frase_impacto,
            'video_url' => $request->video_url ?? null,
            'categoria' => $request->categoria,
            'ubicacion' => $request->ubicacion,
            'estado_validacion' => 'aprobado',
            'verificado' => 1,
            'fecha_validacion' => now()
        ]);

        // Intentar iniciar sesión automáticamente
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // 3. Redirigir al dashboard con mensaje de éxito
        return redirect('/dashboard')->with('success', '¡Bienvenido emprendedor! Tu cuenta ha sido creada y aprobada.');
    }
}