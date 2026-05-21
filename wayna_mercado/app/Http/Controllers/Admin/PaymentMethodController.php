<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends AdminController
{
    public function index()
    {
        $this->authorizeAdmin();

        $metodos = PaymentMethod::orderBy('nombre')->get();
        return view('admin.payment_methods.index', compact('metodos'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nombre' => 'required|string|max:255|unique:metodos_pago,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => 'required|in:transferencia,efectivo,qr,otro',
            'activo' => 'boolean',
            'qr_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $metodo = PaymentMethod::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'tipo' => $request->input('tipo'),
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        if ($request->hasFile('qr_file')) {
            $path = $request->file('qr_file')->store('metodos', 'public');
            $metodo->qr_code = $path;
            $metodo->save();
        }

        return redirect()->route('admin.metodos.show', $metodo->id_metodo)
            ->with('success', 'Método de pago creado exitosamente.');
    }

    public function show($id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.show', compact('metodo'));
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit', compact('metodo'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:metodos_pago,nombre,' . $id . ',id_metodo',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => 'required|in:transferencia,efectivo,qr,otro',
            'activo' => 'boolean',
        ]);

        $metodo->nombre = $request->input('nombre');
        $metodo->descripcion = $request->input('descripcion');
        $metodo->tipo = $request->input('tipo');
        $metodo->activo = $request->has('activo') ? 1 : 0;
        $metodo->save();

        return redirect()->route('admin.metodos.show', $metodo->id_metodo)
            ->with('success', 'Método de pago actualizado exitosamente.');
    }

    public function editQr($id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit_qr', compact('metodo'));
    }

    public function updateQr(Request $request, $id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);
        $request->validate([
            'qr_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        if ($request->hasFile('qr_file')) {
            if ($metodo->qr_code && Storage::disk('public')->exists($metodo->qr_code)) {
                Storage::disk('public')->delete($metodo->qr_code);
            }

            $path = $request->file('qr_file')->store('metodos', 'public');
            $metodo->qr_code = $path;
            $metodo->save();
        }

        return redirect()->back()->with('success', 'QR actualizado.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $metodo = PaymentMethod::findOrFail($id);

        // Si tiene QR, eliminar el archivo
        if ($metodo->qr_code && Storage::disk('public')->exists($metodo->qr_code)) {
            Storage::disk('public')->delete($metodo->qr_code);
        }

        $metodo->delete();

        return redirect()->route('admin.metodos.index')
            ->with('success', 'Método de pago eliminado correctamente.');
    }
}

