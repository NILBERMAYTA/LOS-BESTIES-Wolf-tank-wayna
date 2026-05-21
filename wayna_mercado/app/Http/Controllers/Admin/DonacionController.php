<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donacion;
use App\Models\Emprendedor;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonacionController extends AdminController
{
    public function index()
    {
        $this->authorizeAdmin();
        
        $donaciones = Donacion::with(['cliente', 'emprendedor'])
            ->latest()
            ->paginate(15);
        
        return view('admin.donaciones.index', compact('donaciones'));
    }

    public function show($id)
    {
        $this->authorizeAdmin();
        
        $donacion = Donacion::with(['cliente', 'emprendedor'])
            ->findOrFail($id);
        
        return view('admin.donaciones.show', compact('donacion'));
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        
        $donacion = Donacion::findOrFail($id);
        $emprendedores = Emprendedor::all();
        $usuarios = Usuario::where('id_rol', 3)->get(); // Clientes
        
        return view('admin.donaciones.edit', compact('donacion', 'emprendedores', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        
        $donacion = Donacion::findOrFail($id);
        
        $validated = $request->validate([
            'id_cliente' => 'required|exists:usuarios,id_usuario',
            'id_emprendedor' => 'required|exists:emprendedores,id_emprendedor',
            'monto' => 'required|numeric|min:0.01',
            'mensaje_apoyo' => 'nullable|string|max:1000',
            'estado' => 'required|in:pendiente,confirmada,rechazada',
        ]);
        
        $donacion->update($validated);
        
        return redirect()->route('admin.donaciones.show', $donacion->id_donacion)
            ->with('success', 'Donación actualizada correctamente');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();
        
        $donacion = Donacion::findOrFail($id);
        
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,confirmada,rechazada',
        ]);
        
        $donacion->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        
        $donacion = Donacion::findOrFail($id);
        $donacion->delete();
        
        return redirect()->route('admin.donaciones.index')
            ->with('success', 'Donación eliminada correctamente');
    }
}
