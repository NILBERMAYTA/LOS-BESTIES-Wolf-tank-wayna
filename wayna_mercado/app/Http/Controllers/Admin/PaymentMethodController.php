<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function editQr($id)
    {
        $metodo = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit_qr', compact('metodo'));
    }

    public function updateQr(Request $request, $id)
    {
        $metodo = PaymentMethod::findOrFail($id);
        $request->validate([
            'qr_file' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        if ($request->hasFile('qr_file')) {
            $path = $request->file('qr_file')->store('metodos', 'public');
            $metodo->qr_code = $path;
            $metodo->save();
        }

        return redirect()->back()->with('success', 'QR actualizado.');
    }
}
